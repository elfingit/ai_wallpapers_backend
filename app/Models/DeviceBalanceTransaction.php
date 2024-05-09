<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeviceBalanceTransaction
 *
 * @property string $uuid
 * @property string $device_id
 * @property string $amount
 * @property string|null $notice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction whereNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceBalanceTransaction whereUuid($value)
 * @mixin \Eloquent
 */
class DeviceBalanceTransaction extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'uuid';

    protected $guarded = ['uuid', 'created_at', 'updated_at'];
}
