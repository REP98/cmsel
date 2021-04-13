<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\User;
use App\Models\PostCategories;
use App\Models\PostTags;
use App\Models\Style;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostModel extends Model
{
	use HasSlug, HasFactory;

	public $incrementing = true;

	protected $fillable = [
		'post_type',
		'post_title',
		'post_slug',
		'post_img',
		'status_post',
		'post_categorie_id',
		'style_id',
		'post_tag_id',
		'post_content',
		'user_id',
		'resumen_post',
		'comment_id'
	];


	public function category(): BelongsToMany
	{
		return $this->belongsToMany(PostCategories::class);
	}

	public function Tags(): BelongsToMany
	{
        
        return $this->belongsToMany(PostTags::class);
    }

    public function styles(): BelongsToMany
	{
		return $this->belongsToMany(Style::class);
	}

	public function PostAutor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

	public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('post_title')
            ->saveSlugsTo('post_slug');
	}

	public function getRouteKeyName()
	{
		return 'post_slug';
	}
}
