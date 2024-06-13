<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppleSubscription extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = ['uuid', 'created_at', 'updated_at'];

    protected $primaryKey = 'uuid';
}
