<?php

namespace App\Http\Controllers\AdminSide;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $board = Board::with([
            'products' => function ($query){
                return $query->orderBy('id', 'desc');
            }
        ])->first();

        return view('pages.admin-side.dashboard', compact('board'));
    }
}
