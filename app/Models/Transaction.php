<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['user_id', 'type', 'amount', 'remarks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
