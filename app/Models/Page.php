<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
    	'slug',
    	'title',
    	'description',
    	'content',
    	'parent_id'
    ];

    protected $casts = [
		'description'   => 'array',
    ];

    // InterRelationship
    public function parent(): BelongsTo
    {
    	return $this->belongsTo(__CLASS__);
    }

    public function children(): HasMany
    {
    	return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

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

    public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('title')
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
