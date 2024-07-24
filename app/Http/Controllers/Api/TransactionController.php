<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
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
            $account = $request->user();
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
            $account = $request->user();
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

    public function transfer(TransferRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $sender = $request->user();

            $receiver = User::where('account_number', $request->receiver_account_number)
                ->where('account_number', '!=', $sender->account_number)
                ->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), $request->receiver_name)
                ->first();

            if ($receiver) {
                $sender->update([
                    'balance' => $sender->balance - $validated['amount']
                ]);

                $receiver->update([
                    'balance' => $receiver->balance + $validated['amount']
                ]);
            } else {
                throw new \Exception('Oooops! Bank account not found.');
            }

            DB::commit();
            return response()->json(['message' => 'Transfer successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
