<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EditorFileUpload extends Controller
{
   public function editor(Request $Request)
   {
   		debug($Request);
   		return response()->json(['img'=>'img/f4.jpg']);
   }
}
