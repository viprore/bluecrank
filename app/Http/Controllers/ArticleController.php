<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller implements Cacheable
{
    /**
     * ArticlesController constructor.
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
        return 'articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug = null)
    {
        $cacheKey = cache_key('articles.index');

        $query = $slug
            ? \App\Tag::whereSlug($slug)->firstOrFail()->articles()
            : new \App\Article;

        $query = $query->orderBy(
            $request->input('sort', 'created_at'),
            $request->input('order', 'desc')
        );

        if ($keyword = request()->input('q')) {
            $raw = 'MATCH(title,content) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }

        $articles = $this->cache($cacheKey, 1, $query, 'paginate', 10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new \App\Article;

        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $user = $request->user();

        $article = $user->articles()->create(
            $request->getPayload()
        );

        if (! $article) {
            flash()->error(
                '등록 중 오류가 발생하였습니다.'
            );
            return back()->withInput();
        }


        // 태그 싱크
        $article->tags()->sync($request->input('tags'));

        // 첨부파일 연결
        $request->getAttachments()->each(function ($attachment) use ($article) {
            $attachment->attachable()->associate($article);
            $attachment->save();
        });

        event(new \App\Events\ArticleEvent($article));
        event(new \App\Events\ModelChanged(['articles']));
        flash()->success(
            '게시글 등록에 성공하였습니다.'
        );

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->view_count += 1;
        $article->save();

        $comments = $article->comments()
            ->with('replies')
            ->withTrashed()
            ->whereNull('parent_id')
            ->latest()->get();

        return view('articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {

        $this->authorize('update', $article);

        $payload = array_merge($request->all(), [
            'notification' => $request->has('notification'),
        ]);

        $article->update($payload);
        $article->tags()->sync($request->input('tags'));

        event(new \App\Events\ModelChanged(['articles']));
        flash()->success('게시글이 수정되었습니다.');

        return redirect(route('articles.show', $article->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();

        event(new \App\Events\ModelChanged(['articles']));

        return response()->json([], 204, [], JSON_PRETTY_PRINT);
    }
}
