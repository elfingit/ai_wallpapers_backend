<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GooglePurchaseTransaction
 *
 * @property string $uuid
 * @property string $order_id
 * @property int $purchase_state
 * @property int $consumption_state
 * @property int $purchase_type
 * @property int $acknowledgement_state
 * @property string $region_code
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereAcknowledgementState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereConsumptionState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction wherePurchaseState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction wherePurchaseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereRegionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GooglePurchaseTransaction whereUuid($value)
 * @mixin \Eloquent
 */
class GooglePurchaseTransaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $guarded = ['uuid', 'created_at', 'updated_at', 'deleted_at'];
}
