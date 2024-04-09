<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserBalanceTransaction
 *
 * @property string $ulid
 * @property int $balance_id
 * @property string $amount
 * @property string|null $notice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction whereBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction whereNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalanceTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserBalanceTransaction extends Model
{
    use HasFactory;
    use HasUlids;

    protected $guarded = ['ulid', 'created_at', 'updated_at'];

    protected $primaryKey = 'ulid';
}
