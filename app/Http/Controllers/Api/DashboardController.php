<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function admin()
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

    public function customer()
    {
        try {
            $user = auth()->user();
            $data = [];
            $data['name'] = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
            $data['account_number'] = $user->account->account_number;
            $data['balance'] = $user->account->balance;
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
