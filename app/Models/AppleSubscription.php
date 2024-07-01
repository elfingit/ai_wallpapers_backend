<?php

namespace App\Models;

use App\Library\Billing\Enums\AccountTypeEnum;
use App\Library\Billing\Enums\SubscriptionStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AppleSubscription
 *
 * @property string $uuid
 * @property string $subscription_id
 * @property string $product_id
 * @property int $price
 * @property string $currency
 * @property int $start_date
 * @property int $end_date
 * @property string $status
 * @property AccountTypeEnum $account_type
 * @property string|null $account_uuid
 * @property int|null $account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereAccountUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription withoutTrashed()
 * @property string $transaction_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|AppleSubscription whereTransactionUuid($value)
 * @property-read \App\Models\SubscriptionScheduler|null $subscription
 * @property-read \App\Models\SubscriptionScheduler|null $scheduler
 * @property-read \App\Models\UserDevice|null $device
 * @mixin \Eloquent
 */
class AppleSubscription extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $guarded = ['uuid', 'created_at', 'updated_at', 'deleted_at'];

    protected $primaryKey = 'uuid';

    protected $casts = [
        'account_type' => AccountTypeEnum::class,
        'status' => SubscriptionStatusEnum::class
    ];

    public function scheduler(): HasOne
    {
        return $this->hasOne(SubscriptionScheduler::class, 'subscription_uuid', 'uuid');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(UserDevice::class, 'account_uuid', 'uuid')
            ->where('account_type', AccountTypeEnum::DEVICE);
    }
}
