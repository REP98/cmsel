<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    use Sluggable, HasFactory;

    protected $fillable = [
        'slug',
        'parent_id',
        'title',
        'description',
        'content',
        'page_autor'
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
        return $this->belongsTo(User::class,'page_autor');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }
}
