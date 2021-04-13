<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting as SettinsModel;

class Setting extends Controller
{

	protected $sm;
	protected $fild;

	public function __construct()
	{
		$this->sm = SettinsModel::First();
		$this->parseJson();
	}

    public function get( $type = null, $key = null)
    {
    	if (empty($type)) {
    		return $this->fild;
    	}

    	if (!array_key_exists($type, $this->fild)) {
    		return $this->fild;
    	}

    	$valore = (array) $this->fild[$type];
       
    	if (empty($key)) {
    		return $valore;
    	}

    	if (array_key_exists($key, $valore)) {
    		return $valore[$key];
    	}
        
    	if (stripos( $key, '.' ) !== false) {
    		list($key1, $key2) = explode($key);

    		if (array_key_exists($key1, $valore)) {
    			if (array_key_exists($key2, $valore[$key1])) {
    				return $valore[$key1][$key2];
    			} else {
    				return $valore[$key1];
    			}
    		}
    	}

    	return (object) $valore;
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
    	} else {
    		$data[$key] = $value;
    	}

    	$this->fild[$type] = (object) $data;

    	foreach ($this->fild as $key => $value) {
    		if (array_search($key, ['created_at', 'updated_at', 'id']) === false) {
    			$this->sm[$key] = json_encode($value);
    		}
    	}
    	$this->sm->save();
    	$this->parseJson();
    	return $this->fild;

    }

    public function getImgs($key = null)
    {
    	return $this->get('img', $key);
    }

    public function getConfig($key = null)
    {
    	return $this->get('config', $key);
    }

    public function getMail($key = null)
    {
    	return $this->get('mail', $key);
    }

    public function getStyle($key = null)
    {
    	return $this->get('style', $key);
    }

    public function setImg($type, $url)
    {
    	return $this->set('img', $type, $url);
    }

    public function setConfig($type, $obj)
    {
    	return $this->set('config', $type, $obj);
    }

    public function setMail($type, $obj)
    {
    	return $this->set('mail', $type, $obj);
    }

    public function setStyle($type, $obj)
    {
    	return $this->set('style', $type, $obj);
    }

    protected function parseJson()
    {
    	$sm = $this->sm;
    	foreach ($sm->toArray() as $key => $value) {
    		$this->fild[$key] = array_search($key, ['created_at', 'updated_at', 'id']) === false ? 
    				json_decode( $value, false ) : 
    				$value;
    	}
    }
}
