@extends('layouts.task')
@section('title', '未完了タスク一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>未完了タスク一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="{{ action('Admin\TaskController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-2">
                <a href="{{ action('Admin\TaskController@indexComp') }}">完了一覧へ</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\TaskController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">カテゴリー</label>
                        <div class="col-md-3">
                            <select class="form-control" name='cond_category_id'>
                                <option value="" > - </option>
                                @foreach($categories as $category)
                                    @if ($category->id == $cond_category_id)
                                        <option value="{{ $category->id }}" selected="true" >{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-2">タスク名</label>
                        <div class="col-md-3">
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
                                <!-- <th width="10%">USER_ID</th> -->
                                <th width="30%">タスク名</th>
                                <th width="20%">カテゴリー</th>
                                <th width="10%">期限日</th>
                                <th width="10%">優先度</th>
                                <th width="10%">タグ</th>
                                <th width="10%">完了</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $task)
                                @foreach($priorityList as $k => $priority_val)
                                    @if ($k == $task->priority)
                                        @if ($task->deadline_date < today())
                                            <tr class="listdata" >
                                        @else
                                            <tr>
                                        @endif
                                                <th>{{ $task->id }}</th>
                                                <!-- <td>{{ \Str::limit($task->user_id, 10) }}</td> -->
                                                <td>{{ \Str::limit($task->name, 250) }}</td>
                                                <td>{{ \Str::limit($task->category->name, 10) }}</td>
                                                <td>{{ $task->deadline_date }}</td>
                                                <td>{{ $priority_val }}</td>
                                                <td>
                                                    @foreach($task->tags as $tag)
                                                        {{ $tag->name }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <form action="{{ action('Admin\TaskController@complete') }}" method="post">
                                                        <div class="form-group row">
                                                            <div class="col-md-2">
                                                                <input type="hidden" name="id" value="{{ $task->id }}">
                                                                {{ csrf_field() }}
                                                                <input type="submit" class="btn btn-primary" value="完了">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ action('Admin\TaskController@edit', ['id' => $task->id]) }}">編集</a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ action('Admin\TaskController@delete', ['id' => $task->id]) }}">削除</a>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection