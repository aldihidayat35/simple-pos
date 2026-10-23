<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SystemSetting;

class ProductFuzzyMatcher
{
    /**
     * Memeriksa kemiripan nama produk baru terhadap seluruh produk terdaftar di database.
     * Menggabungkan Levenshtein Distance, Trigram N-Grams, dan Similar Text.
     *
     * @param string $inputName
     * @param int|null $excludeProductId (opsional jika sedang edit produk sendiri)
     * @return array
     */
    public static function checkSimilarity(string $inputName, ?int $excludeProductId = null): array
    {
        $normalizedInput = Product::normalizeName($inputName);

        if (mb_strlen($normalizedInput) < 3) {
            return [
                'has_duplicate_risk' => false,
                'threshold' => (float)SystemSetting::getVal('fuzzy_matching_threshold', 75),
                'highest_similarity' => 0,
                'matches' => [],
            ];
        }

        $threshold = (float)SystemSetting::getVal('fuzzy_matching_threshold', 75);

        $query = Product::where('is_active', true);
        if ($excludeProductId) {
            $query->where('id', '!=', $excludeProductId);
        }
        $existingProducts = $query->with('units')->get();

        $matches = [];
        $highestSimilarity = 0.0;

        foreach ($existingProducts as $product) {
            $normalizedExisting = $product->normalized_name ?: Product::normalizeName($product->name);

            $similarity = self::calculateSimilarityScore($normalizedInput, $normalizedExisting);

            if ($similarity >= $threshold) {
                $matches[] = [
                    'product_id'          => $product->id,
                    'sku'                 => $product->sku,
                    'name'                => $product->name,
                    'category'            => $product->category,
                    'base_uom'            => $product->base_uom,
                    'current_hpp'         => $product->current_hpp,
                    'min_market_price'    => $product->min_market_price,
                    'max_market_price'    => $product->max_market_price,
                    'total_stock'         => $product->getTotalStock(),
                    'similarity_percent'  => round($similarity, 1),
                    'units_count'         => $product->units->count(),
                ];
            }

            if ($similarity > $highestSimilarity) {
                $highestSimilarity = $similarity;
            }
        }

        // Urutkan dari kemiripan tertinggi
        usort($matches, fn($a, $b) => $b['similarity_percent'] <=> $a['similarity_percent']);

        return [
            'has_duplicate_risk'  => count($matches) > 0,
            'threshold'           => $threshold,
            'highest_similarity'  => round($highestSimilarity, 1),
            'input_name'          => $inputName,
            'matches'             => $matches,
        ];
    }

    /**
     * Menghitung nilai kemiripan komposit (0 - 100%).
     */
    public static function calculateSimilarityScore(string $str1, string $str2): float
    {
        if ($str1 === $str2) {
            return 100.0;
        }

        // 1. Oliver's similar_text
        similar_text($str1, $str2, $similarPercent);

        // 2. Levenshtein Distance Ratio
        $maxLen = max(mb_strlen($str1), mb_strlen($str2));
        $levDistance = levenshtein(substr($str1, 0, 255), substr($str2, 0, 255));
        $levPercent = $maxLen > 0 ? max(0, (1 - ($levDistance / $maxLen)) * 100) : 0;

        // 3. Space-stripped matching (Contoh PRD: "Beras Rojolele 10kg" vs "Beras Rojo Lele 10 kg")
        $noSpace1 = str_replace(' ', '', $str1);
        $noSpace2 = str_replace(' ', '', $str2);
        if ($noSpace1 === $noSpace2) {
            return 100.0;
        }
        similar_text($noSpace1, $noSpace2, $noSpaceSim);
        $maxLenNoSpace = max(mb_strlen($noSpace1), mb_strlen($noSpace2));
        $levNoSpace = levenshtein(substr($noSpace1, 0, 255), substr($noSpace2, 0, 255));
        $noSpaceLev = $maxLenNoSpace > 0 ? max(0, (1 - ($levNoSpace / $maxLenNoSpace)) * 100) : 0;

        // 4. Trigram Character Matching (N-Grams dengan koefisien Dice)
        $trigramPercent = self::calculateTrigramSimilarity($str1, $str2);

        // 5. Token Word Matching (Jaccard & Szymkiewicz-Simpson Overlap)
        $tokenScores = self::calculateTokenSimilarityScores($str1, $str2);

        // Ambil nilai kecocokan tertinggi untuk mendeteksi variasi penulisan pasar
        return max(
            $similarPercent,
            $levPercent,
            $noSpaceSim,
            $noSpaceLev,
            $trigramPercent,
            $tokenScores['jaccard'],
            $tokenScores['overlap']
        );
    }

    /**
     * Hitung kemiripan trigram (character 3-grams) dengan koefisien Dice.
     */
    protected static function calculateTrigramSimilarity(string $str1, string $str2): float
    {
        $trigrams1 = self::generateTrigrams($str1);
        $trigrams2 = self::generateTrigrams($str2);

        if (empty($trigrams1) || empty($trigrams2)) {
            return 0.0;
        }

        $intersection = 0;
        $counts2 = array_count_values($trigrams2);

        foreach ($trigrams1 as $tg) {
            if (isset($counts2[$tg]) && $counts2[$tg] > 0) {
                $intersection++;
                $counts2[$tg]--;
            }
        }

        $total = count($trigrams1) + count($trigrams2);
        return ($intersection * 2.0 / $total) * 100;
    }

    protected static function generateTrigrams(string $str): array
    {
        $padded = '  ' . $str . '  ';
        $length = mb_strlen($padded);
        $trigrams = [];

        for ($i = 0; $i < $length - 2; $i++) {
            $trigrams[] = mb_substr($padded, $i, 3);
        }

        return $trigrams;
    }

    /**
     * Hitung kemiripan token kata dengan koefisien Jaccard dan Overlap.
     */
    protected static function calculateTokenSimilarityScores(string $str1, string $str2): array
    {
        $words1 = array_values(array_filter(explode(' ', $str1)));
        $words2 = array_values(array_filter(explode(' ', $str2)));

        if (empty($words1) || empty($words2)) {
            return ['jaccard' => 0.0, 'overlap' => 0.0];
        }

        $intersection = count(array_intersect($words1, $words2));
        $union = count(array_unique(array_merge($words1, $words2)));
        $minWords = min(count($words1), count($words2));

        $jaccard = $union > 0 ? ($intersection / $union) * 100 : 0.0;
        $overlap = ($minWords >= 2 && $intersection >= 2) ? ($intersection / $minWords) * 100 : 0.0;

        return [
            'jaccard' => $jaccard,
            'overlap' => $overlap,
        ];
    }
}
