<?php

namespace App\Models;


use App\Models\PostModel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostTags extends Model
{
    use Sluggable, HasFactory;

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

    public function sluggable(): array
	{
		return [
			'slug_tag' => [
				'source' => 'title',
				'onUpdate' => true
			]
		];
	}
}
