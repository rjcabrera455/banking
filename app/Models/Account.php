<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['user_id', 'account_number', 'balance', 'pin'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
