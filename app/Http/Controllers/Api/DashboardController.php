<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function admin()
    {
        try {
            $data = [];
            $data['total_accounts'] = User::where('role', 'Customer')->count();
            $data['total_account_balance'] = User::where('role', 'Customer')->get()->sum('balance');
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
