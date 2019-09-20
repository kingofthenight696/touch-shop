<?php

namespace App\Http\Controllers\FrontSide;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $json = Board::with('products')->first();
        return view( 'pages.front-side.index', compact('json'));
    }
}
