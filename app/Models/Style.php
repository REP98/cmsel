<?php

namespace App\Models;

use App\Models\PostModel;
use App\Models\PagesModel;
use App\Models\Template;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasSlug, HasFactory;

    protected $fillable = [
    	'slug',
    	'name',
    	'css',
    	'js',
    	'config'
    ];

    public function Post(): BelongsToMany
    {
        return $this->belongsToMany(PostModel::class);
    }

    public function Page(): BelongsToMany
    {
        return $this->belongsToMany(PagesModel::class);
    }

    public function Template(): BelongsToMany
    {
        return $this->belongsToMany(Template::class);
    }

    public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::cretate()
			->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}
}
