<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::withCount('products')->orderBy('name', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(25);

        if ($request->wantsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'suppliers' => $suppliers,
            ]);
        }

        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:150',
            'code'                => 'nullable|string|max:50|unique:suppliers,code',
            'contact_person'      => 'nullable|string|max:100',
            'phone'               => 'required|string|max:30',
            'address'             => 'nullable|string|max:500',
            'payment_terms_days'  => 'required|integer|min:0|max:180',
            'category'            => 'nullable|string|max:100',
        ]);

        if (empty($validated['code'])) {
            $validated['code'] = 'SUP-' . strtoupper(Str::random(5));
        }

        $validated['is_active'] = true;

        $supplier = Supplier::create($validated);

        AuditLogger::log(
            action: 'CREATE_SUPPLIER',
            description: "Mendaftarkan Master Suplayer baru [{$supplier->name}] ({$supplier->code}).",
            model: $supplier,
            newValues: $supplier->toArray()
        );

        if ($request->wantsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'message' => "Suplayer [{$supplier->name}] berhasil ditambahkan!",
                'supplier' => $supplier,
            ]);
        }

        return back()->with('success', "Suplayer [{$supplier->name}] ({$supplier->code}) berhasil didaftarkan!");
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:150',
            'code'                => ['required', 'string', 'max:50', Rule::unique('suppliers')->ignore($supplier->id)],
            'contact_person'      => 'nullable|string|max:100',
            'phone'               => 'required|string|max:30',
            'address'             => 'nullable|string|max:500',
            'payment_terms_days'  => 'required|integer|min:0|max:180',
            'category'            => 'nullable|string|max:100',
            'is_active'           => 'required|boolean',
        ]);

        $oldValues = $supplier->toArray();
        $supplier->update($validated);

        AuditLogger::log(
            action: 'UPDATE_SUPPLIER',
            description: "Memperbarui Master Suplayer [{$supplier->name}] ({$supplier->code}).",
            model: $supplier,
            oldValues: $oldValues,
            newValues: $supplier->toArray()
        );

        if ($request->wantsJson() || $request->isXmlHttpRequest()) {
            return response()->json([
                'success' => true,
                'message' => "Data suplayer [{$supplier->name}] berhasil diperbarui!",
                'supplier' => $supplier,
            ]);
        }

        return back()->with('success', "Data suplayer [{$supplier->name}] berhasil diperbarui!");
    }

    public function destroy(Supplier $supplier)
    {
        $supplierName = $supplier->name;
        $supplier->update(['is_active' => false]);

        AuditLogger::log(
            action: 'DEACTIVATE_SUPPLIER',
            description: "Menonaktifkan Master Suplayer [{$supplierName}].",
            model: $supplier
        );

        return back()->with('success', "Suplayer [{$supplierName}] berhasil dinonaktifkan!");
    }
}
