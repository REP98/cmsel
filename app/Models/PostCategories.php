<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\PostModel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PostCategories extends Model
{
    use  Sluggable, HasFactory;

    protected $fillable = [
    	'cat_type',
        'categories',
        'slug_cat',
        'description_cat',
        'cat_img',
        'parent_cat'
    ];

    public function parent(): BelongsTo
    {
    	return $this->belongsTo(__CLASS__);
    }

    public function children(): HasMany
    {
    	return $this->hasMany(__CLASS__, 'parent_cat', 'id');
    }

    public function Post(): BelongsToMany
    {
        return $this->belongsToMany(PostModel::class);
    }

    public function sluggable(): array
	{
		return [
			'slug_cat' => [
				'source' => 'title',
				'onUpdate' => true
			]
		];
	}
}
