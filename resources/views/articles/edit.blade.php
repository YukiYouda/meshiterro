@extends('layouts.app')
@section('title', '編集画面')
@section('content')
    <h1>詳細編集</h1>
    @include('partial.flash')
    @include('partial.errors')
    <section>
        <article class="card shadow">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $article->image_url }}" width="100%">
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <form action="{{ route('articles.update', $article) }}" method="post" id="form">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="caption" class="form-label">イメージの説明を入力してください</label>
                                    <input type="text" name="caption" id="caption" class="form-control" value="{{ old('caption', $article->caption) }}">
                                </div>
                                <div>
                                    <label for="info" class="form-label">その他情報を入力してください</label>
                                    <textarea name="info" id="info" rows="5" class="form-control">{{ old('info', $article->info) }}</textarea>
                                </div>
                            </form>
                        </figcaption>
                    </div>
                </div>
            </figure>
        </article>
        <div class="d-grid gap-3 col-6 mx-auto mt-2">
            <input type="submit" value="更新" form="form" class="btn btn-success btn-lg">
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">戻る</a>
        </div>
    </section>
@endsection
