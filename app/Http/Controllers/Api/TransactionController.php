<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Traits\RelationshipTrait;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use RelationshipTrait;
    private $relations = [];
    public function index()
    {
        try {
            $transactions = $this->loadRelationships(Transaction::query());
            $data = TransactionResource::collection($transactions->where('user_id', auth()->user()->id)->latest()->get());
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching transactions.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deposit(DepositRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $account = $request->user();
            $account->update([
                'balance' => $account->balance + $validated['amount']
            ]);
            Transaction::create([
                'user_id' => $account->id,
                'type' => 1,
                'amount' => $validated['amount'],
                'remarks' => 'Deposit'
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
            Transaction::create([
                'user_id' => $account->id,
                'type' => 2,
                'amount' => $validated['amount'],
                'remarks' => 'Withdraw'
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
                $senderName = $sender->first_name . ' ' . $sender->middle_name . ' ' . $sender->last_name;

                $receiverName = $receiver->first_name . ' ' . $receiver->middle_name . ' ' . $receiver->last_name;

                $sender->update([
                    'balance' => $sender->balance - $validated['amount']
                ]);

                $receiver->update([
                    'balance' => $receiver->balance + $validated['amount']
                ]);

                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 3,
                    'amount' => $validated['amount'],
                    'remarks' => 'Transferred ' . number_format($validated['amount'], 2) . ' to ' . $receiverName
                ]);

                Transaction::create([
                    'user_id' => $receiver->id,
                    'type' => 4,
                    'amount' => $validated['amount'],
                    'remarks' => 'Transferred ' . number_format($validated['amount'], 2) . ' from ' . $senderName
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
