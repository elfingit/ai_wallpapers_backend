<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplePurchaseTransaction
 *
 * @property string $uuid
 * @property string $transaction_id
 * @property string $product_id
 * @property string $type
 * @property string $environment
 * @property string $storefront
 * @property string $storefront_id
 * @property string $currency
 * @property int $price
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereEnvironment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereStorefront($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereStorefrontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplePurchaseTransaction whereUuid($value)
 * @mixin \Eloquent
 */
class ApplePurchaseTransaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $guarded = ['uuid', 'created_at', 'updated_at', 'deleted_at'];
}
