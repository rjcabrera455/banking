<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        try {
            $data = [];
            $data['total_accounts'] = Account::count();
            $data['total_account_balance'] = Account::all()->sum('balance');
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
