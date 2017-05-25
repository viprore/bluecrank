<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $review = new Review;
        $review->product_id = $id;

        $product = Product::find($id);
        return view('reviews.create', compact('review'))
            ->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        $user = $request->user();

        $review = $user->reviews()->create($request->all());

        $request->getAttachments()->each(function ($attachment) use ($review) {
            $attachment->attachable()->associate($review);
            $attachment->save();
        });

        // TODO 이벤트 등록하려면 하고
        flash()->success('리뷰가 등록되었습니다.');

        return redirect(route('products.show', $request->input('product_id')));
    }

    /**
     * Display the specified resource.
     *
     * @param  Review $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $this->authorize('update', $review);

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReviewRequest  $request
     * @param  Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);

        $review->update($request->all());

        $request->getAttachments()->each(function ($attachment) use ($review) {
            $attachment->attachable()->associate($review);
            $attachment->save();
        });

        flash()->success('리뷰를 업데이트했습니다');

        return redirect(route('reviews.show', $review->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }
}
