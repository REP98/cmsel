<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
    	'slug',
    	'tag_type',
    	'tag',
    	'description',
    	'image'
    ];

    protected $casts = [
		'image'       => 'array',
    ];

    public function posts(): BelongsToMany
    {
    	return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom(['tag_type', 'tag'])
            ->saveSlugsTo('slug');
	}

 	public function getRouteKeyName()
	{
		return 'slug';
	}

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
