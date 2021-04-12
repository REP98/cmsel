<?php

namespace App\Models;

use DateTimeInterface;

use App\Models\User;
use App\Models\Style;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    use HasSlug, HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        'slug',
        'parent_id',
        'title',
        'description',
        'content',
        'style_id',
        'user_id'
    ];


    public function parent(): BelongsTo
    {
    	return $this->belongsTo(__CLASS__);
    }

    public function children(): HasMany
    {
    	return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    public function PostAutor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(Style::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::cretate()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
