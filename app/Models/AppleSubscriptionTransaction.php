<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AppleSubscriptionTransaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscriptionTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscriptionTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscriptionTransaction query()
 * @mixin \Eloquent
 */
class AppleSubscriptionTransaction extends Model
{
    use HasFactory;
    use HasUuids;
    protected $guarded = ['uuid', 'created_at', 'updated_at'];

    protected $primaryKey = 'uuid';
}
