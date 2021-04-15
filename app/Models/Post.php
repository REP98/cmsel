<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
    	'post_slug',
    	'post_type',
    	'post_title',
    	'post_img',
    	'status_post',
    	'resumen_post', // ó extracto (bajada) 
    	'post_content'
    ];

    protected $casts = [
		'post_img'   => 'array',
		'post_content'   => 'array',
    ];

     // Dependecy
    public function users() : BelongsTo
    {
    	return $this->belongsTo(User::class);
    }

    // Require
    public function styles(): BelongsToMany
    {
    	return $this->belongsToMany(Style::class)->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
    	return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function tags(): BelongsToMany
    {
    	return $this->belongsToMany(Tag::class)->withTimestamps();
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

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
