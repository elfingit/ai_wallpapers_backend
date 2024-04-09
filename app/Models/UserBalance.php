<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserBalance
 *
 * @property int $id
 * @property string $balance
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBalance withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserBalanceTransaction> $transactions
 * @property-read int|null $transactions_count
 * @mixin \Eloquent
 */
class UserBalance extends Model
{
	use SoftDeletes;

	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(UserBalanceTransaction::class, 'balance_id', 'id');
    }
}
