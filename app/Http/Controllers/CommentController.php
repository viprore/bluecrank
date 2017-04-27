<?php

namespace App\Http\Controllers;

use App\Article;
use App\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * CommentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest $request
     * @param  $target
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\CommentRequest $request, $target)
    {
        $comment = $target->comments()->create(array_merge(
            $request->all(),
            ['user_id' => $request->user()->id]
        ));

        event(new \App\Events\CommentEvent($comment));
        flash()->success('작성하신 댓글을 저장했습니다.');

        if (strpos($request->url(), 'articles')) {
            $where = 'articles';
        } else if (strpos($request->url(), 'products')) {
            $where = 'products';
        }

        event(new \App\Events\ModelChanged(['articles']));
        return redirect(
            route($where.'.show', $target->id) . '#comment_' . $comment->id
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CommentRequest $request
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\CommentRequest $request, \App\Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->all());

        event(new \App\Events\ModelChanged(['articles']));
        flash()->success('수정하신 내용을 저장했습니다.');

        if ($comment->commentable_type == \App\Article::class) {
            $where = 'articles';
        } else if ($comment->commentable_type == \App\Product::class) {
            $where = 'products';
        }

        return redirect(
            route($where.'.show', $comment->commentable->id) . '#comment_' . $comment->id
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Comment $comment)
    {
        $this->authorize('update', $comment);

        if ($comment->replies->count() > 0) {
            $comment->delete();
        } else {
            $comment->votes()->delete();
            $comment->forceDelete();
        }

        event(new \App\Events\ModelChanged(['articles']));

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }

    /**
     * Vote up or down for the given comment.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote(Request $request, \App\Comment $comment)
    {
        $this->validate($request, [
            'vote' => 'required|in:up,down',
        ]);

        if ($comment->votes()->whereUserId($request->user()->id)->exists()) {
            return response()->json(['error' => 'already_voted'], 409);
        }

        $up = $request->input('vote') == 'up' ? true : false;

        $comment->votes()->create([
            'user_id'  => $request->user()->id,
            'up'       => $up,
            'down'     => ! $up,
            'voted_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        return response()->json([
            'voted' => $request->input('vote'),
            'value' => $comment->votes()->sum($request->input('vote')),
        ], 201, [], JSON_PRETTY_PRINT);
    }
}
