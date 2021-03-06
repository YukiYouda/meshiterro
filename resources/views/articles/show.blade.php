@extends('layouts.main')
@section('title', '詳細画面')
@section('content')
    @include('partial.flash')
    @include('partial.errors')
    <section>
        <article class="card shadow position-relative">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        @foreach ($article->attachments as $attachment)
                            <div class="mb-2">
                                <img src="{{ Storage::url('articles/' . $attachment->name) }}" width="100%">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <div class="mb-5 font">
                                {{ $article->caption }}
                            </div>
                            <div class="font">
                                {{ $article->info }}
                            </div>
                        </figcaption>
                    </div>
                </div>
            </figure>
            @can('update', $article)
                <a href="{{ route('articles.edit', $article) }}">
                    <i class="fas fa-edit position-absolute top-0 end-0 fs-1"></i>
                </a>
            @endcan
        </article>
    </section>
    @can('delete', $article)
        <form action="{{ route('articles.destroy', $article) }}" method="POST" id="form">
            @csrf
            @method('delete')
        </form>
        <div class="d-grid col-6 mx-auto gap-3 mt-3">
            <input type="submit" value="削除" form="form" class="btn btn-danger btn-lg"
                onclick="if (!confirm('本当に削除してよろしいですか？')) {return false};">
        @endcan
        <a href="{{ route('articles.index') }}" class="btn btn-secondary btn-lg">戻る</a>
    </div>
@endsection
