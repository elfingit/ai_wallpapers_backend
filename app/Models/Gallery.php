<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Gallery
 *
 * @property int $id
 * @property string $file_path
 * @property string|null $thumbnail_path
 * @property string $prompt
 * @property string $locale
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $revised_prompt
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery wherePrompt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereRevisedPrompt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereThumbnailPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery withoutTrashed()
 * @property string|null $device_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereDeviceUuid($value)
 * @property string|null $style
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereStyle($value)
 * @property int $view_count
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereViewCount($value)
 * @mixin \Eloquent
 */
class Gallery extends Model
{
	use SoftDeletes;

	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
