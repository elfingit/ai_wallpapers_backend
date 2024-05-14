<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SearchQuery
 *
 * @property int $id
 * @property string $device_id
 * @property string $query
 * @property string $locale
 * @property bool $processed
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery query()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereQuery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchQuery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SearchQuery extends Model
{
    use HasFactory;
}
