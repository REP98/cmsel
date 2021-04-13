<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
    	'img',
    	'config',
    	'mail',
    	'style'
    ];

    public function getImgs($assoc_array = false)
    {
    	return json_decode( $this->img, $assoc_array);
    }

    public function getConfig($assoc_array = false)
    {
    	return json_decode( $this->config, $assoc_array);
    }

    public function getMail($assoc_array = false)
    {
    	return json_decode( $this->mail, $assoc_array);
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
