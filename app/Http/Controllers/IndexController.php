<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parser;
use App\Models\Dom;

class IndexController extends Controller
{
    public function index() {      
        return view('index');
    }
}
