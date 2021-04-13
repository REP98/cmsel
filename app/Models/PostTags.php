<?php

namespace App\Models;

use App\Models\PostModel;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostTags extends Model
{
    use HasSlug, HasFactory;

    public $incrementing = true;

    protected $fillable = [
        'tag_type',
        'tag',
        'slug_tag',
        'description_tags',
    ];

    public function Post(): BelongsToMany
    {
        return $this->belongsToMany(PostModel::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('tag')
            ->saveSlugsTo('slug_tag');
    }

    public function getRouteKeyName()
    {
        return 'slug_tag';
    }
}
