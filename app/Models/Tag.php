<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
	use SoftDeletes;
    use HasTranslations;

	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public array $translatable = ['title'];
}
