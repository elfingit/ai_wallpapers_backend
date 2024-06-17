<?php

namespace App\Models;

use App\Library\Billing\Enums\MarketTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SubscriptionScheduler
 *
 * @property MarketTypeEnum $market
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler withoutTrashed()
 * @property string $uuid
 * @property string $subscription_uuid
 * @property \Illuminate\Support\Carbon $next_check_date
 * @property \Illuminate\Support\Carbon $last_check_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereLastCheckDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereMarket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereNextCheckDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereSubscriptionUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionScheduler whereUuid($value)
 * @mixin \Eloquent
 */
class SubscriptionScheduler extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = ['uuid', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'market' => MarketTypeEnum::class,
        'next_check_date' => 'datetime',
        'last_check_date' => 'datetime',
    ];
}
