<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\User;
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

    public function withdraw(DepositRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $account = Account::where('user_id', auth()->user()->id)->first();
            $account->update([
                'balance' => $account->balance - $validated['amount']
            ]);
            DB::commit();
            return response()->json(['message' => 'Withdraw successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function receiver()
    {
        try {
            $account_number = request()->account_number;
            $account = Account::where('account_number', $account_number)->first();

            if (!$account) {
                throw new \Exception('Oooops! Bank account not found!');
            } else {
                $user = User::where('id', $account->user_id)->first();
                $name = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
            }

            return response()->json(['data' => $name], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function transfer(TransferRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $sender = Account::where('user_id', auth()->user()->id)->first();
            $receiver = Account::where('account_number', $request->receiver_account_number)->first();
            $sender->update([
                'balance' => $sender->balance - $validated['amount']
            ]);
            $receiver->update([
                'balance' => $receiver->balance + $validated['amount']
            ]);
            DB::commit();
            return response()->json(['message' => 'Transfer successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
