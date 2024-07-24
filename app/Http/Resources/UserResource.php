<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'id' => $this->id,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'mobile_number' => $this->mobile_number,
            'password' => $this->password,
            'role' => $this->role,
            'account_number' => $this->account_number,
            'balance' => $this->balance,
            'pin' => $this->pin,
            'updated_at' => $this->updated_at,
            'full_name' => $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name,
        ];
    }
}
