<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\Contracts\HasAbilities;

/**
 * App\Models\UserDeviceToken
 *
 * @property int $id
 * @property mixed $device_uuid
 * @property string $token
 * @property array|null $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\UserDevice|null $userDevice
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereDeviceUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeviceToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserDeviceToken extends Model implements HasAbilities
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'abilities' => 'json'
    ];

    public function userDevice(): BelongsTo
    {
        return $this->belongsTo(UserDevice::class, 'device_uuid', 'uuid');
    }

    public static function findToken($token)
    {
        if (strpos($token, '|') === false) {
            return static::where('token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);
        if ($instance = static::find($id)) {
            return hash_equals($token, hash('sha256', $instance->token)) ? $instance : null;
        }
    }

    public function can($ability): bool
    {
        return in_array($ability, $this->abilities ?? []);
    }

    public function cant($ability)
    {
        return true;
    }
}
