<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\User;
use App\Models\PostCategories;
use App\Models\PostTags;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostModel extends Model
{
	use Sluggable, HasFactory;

	public $incrementing = true;

	protected $fillable = [
		'post_type',
		'post_title',
		'post_slug',
		'post_img',
		'status_post',
		'post_categories',
		'post_tags',
		'post_content',
		'post_autor',
		'resumen_post',
		'comment_status'
	];


	public function category(): BelongsToMany
	{
		return $this->belongsToMany(PostCategories::class);
	}

	public function Tags(): BelongsToMany
	{
        
        return $this->belongsToMany(PostTags::class);
    }

	public function PostAutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'post_autor');
    }

	public function sluggable(): array
	{
		return [
			'post_slug' => [
				'source' => 'title',
				'onUpdate' => true
			]
		];
	}
}
