<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Say hello to visitors.
     *
     * @return \Illuminate\Contracts\View\Factory
     */
    public function index() {
        return redirect(route('products.index'));
    }

    public function phpinfo() {
        return view('info');
    }

    public function useinfo() {
        return view('layouts.use');
    }

    public function privateinfo() {
        return view('layouts.private');
    }

}
