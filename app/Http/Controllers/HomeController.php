<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = Travel::with(['galleries'])->get();
        return view('pages.home', [
            'items' => $items
        ]);
    }
}
