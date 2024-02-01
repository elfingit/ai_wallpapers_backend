<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBalance extends Model
{
	use SoftDeletes;

	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
