<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;

class B2bController extends Controller
{
    public function index(Request $request)
    {
        $b2bPartners = User::where('role', User::ROLE_B2B)->get();
        $defaultCreditLimit = SystemSetting::getVal('default_b2b_credit_limit', 50000000);
        $autoBlockDays = SystemSetting::getVal('auto_block_overdue_days', 30);

        return view('b2b.index', compact('b2bPartners', 'defaultCreditLimit', 'autoBlockDays'));
    }
}
