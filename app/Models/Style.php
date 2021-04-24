<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Style extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'css',
        'js',
        'show',
        'level',
        'user',
    ];

    // Dependecy
    public function users() : BelongsTo
    {
    	return $this->belongsTo(User::class);
    }
    // Require
    public function settings(): HasMany
    {
    	return $this->hasMany(Setting::class);
    }

    public function templates(): BelongsToMany
    {
    	return $this->belongsToMany(Template::class)->withTimestamps();
    }

    public function pages(): BelongsToMany
    {
    	return $this->belongsToMany(Page::class)->withTimestamps();
    }

    public function posts(): BelongsToMany
    {
    	return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('name')
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
