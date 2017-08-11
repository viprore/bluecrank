<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Item;
use App\Product;
use Illuminate\Http\Request;
use League\HTMLToMarkdown\HtmlConverter;

class ProductController extends Controller implements Cacheable
{
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => ['index', 'show', 'tagsIndex', 'search']]);
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
     * 상품들의 리스트를 보여준다.
     *
     * @param Request $request
     * @param String $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category = null)
    {
        // Category로 물품 제한
        $query = $category ? Product::whereCategory($category)
            : new Product();

        // 중고 여부
        if (str_contains($request->url(), 'olds')) {
            $query = $query->where('is_old', true);
        }else{
            $query = $query->where('is_old', false);
        }

        // 정렬 옵션
        $query = $query->orderBy('category', 'asc');
        $query = $query->orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc')
        );

        // 운영자가 아닐 경우 판매중인 상품만 전시
        if (!\Auth::check() || !$request->user()->isAdmin()) {
            $query = $query->whereIn('ad_status', ['판매', '매진']);
        }

        // 검색 관련 쿼리 및 캐싱
        $cacheKey = cache_key('products.index');
        if ($keyword = request()->input('q')) {
            $raw = 'MATCH(ad_title, ad_short_description) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }
        $products = $query->get();

        // 태그 활용
        $slug = $request->input('slug');
        if (!empty($slug)) {
            $slugs = explode(' ', $slug);
            $sIds = array();
            foreach ($products as $product) {
                $tags = $product->tags->pluck('slug')->all();
                $result = array_intersect($tags, $slugs);

                if (count($result) == count($slugs)) {
                    array_push($sIds, $product->id);
                }
            }
            $query = $query->whereIn('id', $sIds);
        }

        $products = $this->cache($cacheKey, 1, $query, 'paginate', 18);

        return view('products.index', compact('products'));
    }

    /**
     * 최상단 검색 이용시 부분 리스트들과 함께 보여준다
     *
     * @param Request $request
     * @param String $category
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = new Product();

        // 검색 관련 쿼리
        if ($keyword = request()->input('q')) {
            $raw = 'MATCH(ad_title, ad_short_description) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }

        // 운영자가 아닐 경우 판매중인 상품만 전시
        if (!\Auth::check() || !$request->user()->isAdmin()) {
            $query = $query->whereIn('ad_status', ['판매', '매진']);
        }

        $query = $query->orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc')
        );

//        dd($query->where('is_old', false)->get());

        $products = $query->get();

        $old_items = $products->where('is_old', true)->forPage(1, 4);
        $bc_items = $products->where('is_old', false)->forPage(1, 4);


        return view('products.ttsearch', compact('old_items', 'bc_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = new Product;

        return view('products.create', compact('product'));

        /*if (str_contains($request->url(), 'products')) {
            return view('products.create', compact('product'));
        }else{
            return view('olds.create', compact('product'));
        }*/
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
            "ad_status" => $request->input('ad_status'),
            "ad_short_description" => $request->input('ad_short_description'),
            "category" => $request->input('category'),
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

        if (str_contains($request->url(), 'olds')) {
            $product->is_old = true;
            $product->save();
            return redirect(route('olds.edit.option', $product->id));
        }else{
            return redirect(route('products.edit.option', $product->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        $product->view_count += 1;
        $product->save();

        $product->with('options');

        $comments = $product->comments()
            ->with('replies')
            ->withTrashed()
            ->whereNull('parent_id')
            ->latest()->get();

        $sel_item = $request->input('itemId');

        if (!empty($sel_item)) {
            $item = Item::find($sel_item);
            return view('products.show', compact('product', 'comments', 'item'));
        }else{
            return view('products.show', compact('product', 'comments'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
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
    public function optionEdit(Request $request, Product $product)
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
            "ad_status" => $request->input('ad_status'),
            "ad_short_description" => $request->input('ad_short_description'),
            "category" => $request->input('category'),
            "price" => $request->input('price'),
            "description" => $request->input('description'),
        ];

        $product->update($payload);
        $product->tags()->sync($request->input('tags'));

        event(new \App\Events\ModelChanged(['products']));
        flash()->success('수정 완료');


        if ($product->is_old) {
            return redirect(route('olds.edit.option', $product->id));

        }else{
            return redirect(route('products.edit.option', $product->id));
        }
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

    public function tagsIndex()
    {
        return view('tags.index');
    }



}
