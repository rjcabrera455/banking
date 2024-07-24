<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\RelationshipTrait;
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
            $users = $this->loadRelationships(User::query());
            $data = UserResource::collection($users->where('role', 'Customer')->latest()->get());
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

            $validated['role'] = 'Customer';
            $validated['account_number'] = rand(100000000, 999999999);

            User::create($validated);

            DB::commit();
            return response()->json(['message' => 'Account added successfully'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(User $user)
    {
        try {
            $user = $this->loadRelationships($user);
            $data = new UserResource($user);
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the acccount.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(AccountRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            if (!$validated['password']) {
                unset($validated['password']);
            }
            $user->update($validated);
            DB::commit();
            return response()->json(['message' => 'Account updated successfully'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'Account deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while deleting the account.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
