<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting as SettinsModel;

class Setting extends Controller
{

	protected $sm;
	protected $column = [
		'image',
		'general',
		'config',
		'pages',
		'menu',
		'mail',
	];

	public function __construct()
	{
		$this->sm = SettinsModel::First(); // Cambiar para multisite
		if (!is_array($this->sm->general)) {
			throw new Exception("This site has no settings", 1);
		}

		if (!array_key_exists('site_url', $this->sm->general)) {
			throw new Exception("This site has no settings\n Verify URL", 1);
		}

		if (strcmp($this->sm->general['site_url'], url('/')) !== 0) {
			throw new Exception("This site has no settings\n Verify URL", 1);
		}
	}

	public function index(){

		return view('dashboard.settings.index', ['setting' => $this]);
	}

	public function get( $type = null, $key = null)
	{
		if (empty($type)) {
			return $this->sm;
		}
		if (array_search($type, $this->column) === false) {
			return "";
		}

		$valore = $this->sm[$type];

		if (empty($key)) {
			return (object) $valore;
		}

		if (array_key_exists($key, $valore)) {
			return $valore[$key];
		} else if(!array_key_exists($key, $valore)){
			if (stripos( $key, '.' ) !== false) {
				list($key1, $key2) = explode('.', $key);
				if (array_key_exists($key1, $valore)) {
					if (array_key_exists($key2, $valore[$key1])) {
						return $valore[$key1][$key2];
					} else {
						return $valore[$key1];
					}
				}
			}
			return null;
		}

		return (object) $valore;
	}

	private function __setModel($data) {
		$sm = SettinsModel::First();
		foreach ($data as $key => $value) {
			$sm[$key] = $value;
		}
		$sm->save();
		$this->sm = $sm;
	}

	public function set($type, $key, $value)
	{
		if (empty($type)) {
			return false;
		}

		$data = (array) $this->get($type);
		
		if (array_key_exists($key, $data)) {
			if (is_array($data[$key])) {
				$data[$key] = array_merge_recursive($data[$key], $value);
			} else {
				$data[$key] = $value;
			}  
		} else if(stripos( $key, '.' ) !== false) {
			list($key1, $key2) = explode('.', $key);
			$data[$key1][$key2] = $value;
		} else {
			$data[$key] = $value;
		}
		
		$this->__setModel([$type => $data]);

		return $this->sm[$type];
	}

	public function __call($name, $arguments = [])
	{
		if (!empty($name) && array_search($name, $this->column)){
			$method = 'get';
			if (count($arguments) == 2) {
				$method = 'set';
			}
			$arg = [$name]; 
			if (is_array($arguments) && count($arguments) >= 1){
				$arg = array_merge($arg,  $arguments);
			}
			
			return call_user_func_array([__CLASS__, $method], $arg);
		}
	}
}
