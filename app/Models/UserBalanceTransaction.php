<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalanceTransaction extends Model
{
    use HasFactory;
    use HasUlids;

    protected $guarded = ['ulid', 'created_at', 'updated_at'];
}
