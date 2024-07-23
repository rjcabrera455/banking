<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use App\Http\Traits\RelationshipTrait;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    use RelationshipTrait;
    private  $relations = ['user'];

    public function index()
    {
        try {
            $accounts = $this->loadRelationships(Account::query());
            $data = AccountResource::collection($accounts->latest()->get());
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(AccountRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            $user = User::create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'password' => $validated['password'],
                'role' => 'Customer'
            ]);

            $user->account()->create([
                'account_number' => rand(100000000, 999999999),
                'pin' => $validated['pin']
            ]);

            DB::commit();
            return response()->json(['message' => 'Account added successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Account $account)
    {
        try {
            $account = $this->loadRelationships($account);
            $data = new AccountResource($account);
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the account.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(AccountRequest $request, Account $account)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $account->update($validated);
            DB::commit();
            return response()->json(['message' => 'Account updated successfully'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while updating the account.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Account $account)
    {
        try {
            DB::beginTransaction();
            $account->delete();
            DB::commit();
            return response()->json(['message' => 'Account deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while deleting the account.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
