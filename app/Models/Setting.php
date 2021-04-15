<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

   protected $fillable = [
        'image',
        'general',
        'config',
        'pages',
        'menu',
        'mail',
    ];

    protected $casts = [
		'image'   => 'array',
		'general' => 'array',
		'config'  => 'array',
		'pages'   => 'array',
		'menu'    => 'array',
		'mail'    => 'array'
    ];

    // Dependecy
    public function styles() : BelongsTo
    {
    	return $this->belongsTo(Style::class);
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
