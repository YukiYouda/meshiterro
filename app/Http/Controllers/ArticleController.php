<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Attachment;
use App\Http\Requests\ArticleRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $article = new Article();
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $files = $request->file('file');

        DB::beginTransaction();

        try {
            $article->save();

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $path = Storage::putFile('articles', $file);

                $attachment = new Attachment;
                $attachment->article_id = $article->id;
                $attachment->org_name = $file_name;
                $attachment->name = basename($path);

                $attachment->save();
            }

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return back()
                ->withErrors($e->getMessage());
        }

        return redirect()
            ->route('articles.index')
            ->with(['flash_message' => '登録が完了しました']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());

        try {
            $article->save();
        } catch (\Exception $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $attachments = $article->attachments;
        $article->delete();

        foreach ($attachments as $attachment) {
            Storage::delete('articles/' . $attachment->name);
        }

        return redirect()
            ->route('articles.index')
            ->with(['flash_message' => '投稿を削除しました']);
    }
}
