<?php

namespace App\Models;

use App\Library\Core\Acl\RulesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserDevice
 *
 * @property string $uuid
 * @property int $user_id
 * @property string $ip_address
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice whereUuid($value)
 * @mixin \Eloquent
 */
class UserDevice extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $keyType = 'string';

    public function tokenCan(string $rule): bool
    {
        $rule = RulesEnum::tryFrom($rule);

        $rules = config('abilities.device', []);

        return in_array($rule, $rules, true);
    }
}
