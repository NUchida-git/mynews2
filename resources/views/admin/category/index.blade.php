@extends('layouts.category')
@section('title', '登録済みカテゴリー一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>カテゴリー一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\CategoryController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\CategoryController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">カテゴリー</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="30%">カテゴリー</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $category)
                                <tr>
                                    <th>{{ $category->id }}</th>
                                    <td>{{ \Str::limit($category->name, 20) }}</td>

                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\CategoryController@edit', ['id' => $category->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ action('Admin\CategoryController@delete', ['id' => $category->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection