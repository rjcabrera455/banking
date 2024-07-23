<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function deposit(DepositRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $account = Account::where('user_id', auth()->user()->id)->first();
            $account->update([
                'balance' => $account->balance + $validated['amount']
            ]);
            DB::commit();
            return response()->json(['message' => 'Deposit successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
