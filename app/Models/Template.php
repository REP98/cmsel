<?php

namespace App\Models;

use App\Models\User;
use App\Models\Style;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
		'name',
		'shotcode',
		'position',
		'content',
		'ids',
		'type_id',
		'config',
		'slug',
		'style_id',
		'user_id'
	];

    public function styles(): BelongsToMany
	{
		return $this->belongsToMany(Style::class);
	}

	public function Autor(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
