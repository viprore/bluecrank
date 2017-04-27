<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionRequest;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * OptionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OptionRequest $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(OptionRequest $request, \App\Product $product)
    {
        $option = $product->options()->create($request->all());

        flash($option->color . " - (" . $option->size . ") // " . $option->inventory . "개\n등록완료");

        return response()->json([], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OptionRequest $request
     * @param  \App\Option $option
     * @return \Illuminate\Http\Response
     */
    public function update(OptionRequest $request, \App\Option $option)
    {
        $this->authorize('update', $option);

        $option->update($request->all());

        return response()->json([], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OptionRequest $request
     * @param  $target
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Option $option)
    {
        $this->authorize('delete', $option->product);

        $option->delete();

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }

}
