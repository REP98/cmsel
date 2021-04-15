<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Template extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
    	'slug',
    	'name',
    	'shotcode',
    	'content',
    	'type'
    ];

    // Dependecy
    public function users() : BelongsTo
    {
    	return $this->belongsTo(User::class);
    }

    // Require
    public function styles(): BelongsToMany
    {
    	return $this->belongsToMany(Setting::class)->withTimestamps();
    }

    public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom(['type', 'name'])
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
