<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function updateAccountSettings(AccountSettingRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $user = $request->user();

            if ($request->hasFile('profile')) {
                $filePath = public_path('/uploads/' . $user->profile);
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }

                $profile = $request->file('profile');
                $file = random_int(1000, 9999) . time() . '.' . $profile->extension();
                $profile->move(public_path('uploads'), $file);

                $validated['profile'] = $file;
            } else {
                unset($validated['profile']);
            }

            if ($user->role == 'Admin') {
                unset($validated['pin']);
            }

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            DB::commit();

            return response()->json(['message' => 'Account setting updated successfully'], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
