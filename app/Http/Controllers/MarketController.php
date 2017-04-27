<?php

namespace App\Http\Controllers;

use App\Market;
use Illuminate\Http\Request;

class MarketController extends Controller implements Cacheable
{
    /**
     * MarketController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Specify the tags for caching.
     *
     * @return string
     */
    public function cacheTags()
    {
        return 'markets';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug = null)
    {
        $cacheKey = cache_key('markets.index');

        if(strpos($request->route()->getName(), 'tags')){
            $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->markets()
                : new Market;
        }else{
            $query = $slug ? Market::whereCategory($slug)
                : new Market;
        }
        $query = $query->orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc')
        );


        if ($keyword = request()->input('q')) {
            $raw = 'MATCH(ad_title, brand, model, description) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }

        $markets = $this->cache($cacheKey, 1, $query, 'paginate', 3);

        return view('markets.index', compact('markets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $market = new Market;

        return view('markets.create', compact('market'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        return view('markets.show', compact('market'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy(Market $market)
    {
        //
    }
}
