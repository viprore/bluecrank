<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function want(\App\Product $product)
    {
        $user = \Auth::user();



        if ($user->wantProducts()->find($product->id)) {
            $user->wantProducts()->detach($product->id);
            flash('해제');
        } else {
            $user->wantProducts()->attach($product->id);
            flash('등록');
        }

        return response()->json([], 200, [], JSON_PRETTY_PRINT);


    }
}
