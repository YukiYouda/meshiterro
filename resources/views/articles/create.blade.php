@extends('layouts.main')
@section('titel', '新規登録')
@section('content')
    <div class="col-8 col-offset-2 mx-auto">
        @include('partial.flash')
        @include('partial.errors')
        <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
            <div class="card mb-3">
                @csrf
                <div class="row m-3">
                    <div class="mb-3">
                        <label for="file">ファイルを選択してください</label>
                        <div class="d-flex">
                            <input type="file" name="file[]" id="file" multiple="multiple">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="caption">イメージの説明を入力してください</label>
                        <input type="text" name="caption" id="caption" value="{{ old('caption') }}">
                    </div>
                    <div>
                        <label for="info">その他の説明を入力してください</label>
                        <textarea name="info" id="info" rows="5">{{ old('info') }}</textarea>
                    </div>
                </div>
            </div>
            <input type="submit">
        </form>
    </div>
@endsection
