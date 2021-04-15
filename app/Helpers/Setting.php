<?php 

use App\Http\Controllers\Setting;

if (!function_exists('settings')) {
	function settings($type = null, $key = null, $value = null) {
		$s = new Setting;
		if (empty($value)) {
			return  $s->get($type, $key, $value);
		}
		return $s->set($type, $key, $value);
	}
}