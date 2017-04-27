<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller implements Cacheable
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
        return 'products';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug = null)
    {
        $cacheKey = cache_key('products.index');

        if (strpos($request->route()->getName(), 'tags')) {
            $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->markets()
                : new Product;
        } else {
            $query = $slug ? Product::whereCategory($slug)
                : new Product;
        }
        $query = $query->orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc')
        );

        if (!\Auth::check() || !$request->user()->isAdmin()) {
            $query = $query->whereIn('ad_status', ['판매', '매진']);
        }


        if ($keyword = request()->input('q')) {
            $raw = 'MATCH(ad_title,, ad_short_description, brand, model, description) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }

        $products = $this->cache($cacheKey, 1, $query, 'paginate', 6);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;

        return view('products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $payload = [
            "_token" => $request->input('_token'),
            "ad_title" => $request->input('ad_title'),
            "ad_short_description" => $request->input('ad_short_description'),
            "category" => $request->input('category')[0],
            "price" => $request->input('price'),
            "description" => $request->input('description'),
        ];


        $product = Product::create($payload);

        if (!$product) {
            flash()->error('등록 중 오류가 발생하였습니다.');

            return back()->withInput();
        }

        $product->tags()->sync($request->input('tags'));

        // 첨부파일 연결
        $request->getAttachments()->each(function ($attachment) use ($product) {
            $attachment->attachable()->associate($product);
            $attachment->save();
        });

        event(new \App\Events\ProductEvent($product));
        event(new \App\Events\ModelChanged(['products']));
        flash()->success(
            '상품 등록에 성공하였습니다.'
        );

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->view_count += 1;
        $product->save();

        $product->with('options');

        $comments = $product->comments()
            ->with('replies')
            ->withTrashed()
            ->whereNull('parent_id')
            ->latest()->get();

        return view('products.show', compact('product', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function optionEdit(Product $product)
    {
        $this->authorize('update', $product);

        return view('products.option', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $payload = [
            "_token" => $request->input('_token'),
            "ad_title" => $request->input('ad_title'),
            "ad_short_description" => $request->input('ad_short_description'),
            "category" => $request->input('category')[0],
            "price" => $request->input('price'),
            "description" => $request->input('description'),
        ];

        $product->update($payload);
        $product->tags()->sync($request->input('tags'));

        event(new \App\Events\ModelChanged(['products']));
        flash()->success('수정 완료');

        return redirect(route('products.show', $product->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        event(new \App\Events\ModelChanged(['products']));

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest $request
     * @param  $target
     * @return \Illuminate\Http\Response
     */
    public function optionStore(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest $request
     * @param  $target
     * @return \Illuminate\Http\Response
     */
    public function optionDelete(Request $request)
    {

    }

}
