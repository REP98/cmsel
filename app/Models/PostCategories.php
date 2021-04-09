<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\PostModel;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class PostCategories extends Model
{
    use  HasSlug, HasFactory;

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::cretate()
            ->generateSlugsFrom('categories')
            ->saveSlugsTo('slug_cat');
    }

    public function getRouteKeyName()
    {
        return 'slug_cat';
    }
}
