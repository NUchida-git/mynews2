@extends('layouts.task')
@section('title', '完了済タスク一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>完了済タスク一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="{{ action('Admin\TaskController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-3">
                <a href="{{ action('Admin\TaskController@index') }}">未完了一覧へ</a>
            </div>
            <div class="col-md-6">
                <form action="{{ action('Admin\TaskController@indexComp') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タスク名</label>
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
                                <th width="10%">USER_ID</th>
                                <th width="40%">タスク名</th>
                                <th width="10%">期限日</th>
                                <th width="10%">優先度</th>
                                <th width="10%">完了</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $task)
                                @foreach($priorityList as $k => $priority_val)
                                    @if ($k == $task->priority)
                                        <tr>
                                            <th>{{ $task->id }}</th>
                                            <td>{{ \Str::limit($task->user_id, 10) }}</td>
                                            <td>{{ \Str::limit($task->name, 250) }}</td>
                                            <td>{{ $task->deadline_date }}</td>
                                            <td>{{ $priority_val }}</td>
                                            <td>
                                                <form action="{{ action('Admin\TaskController@incomplete') }}" method="post">
                                                    <div class="form-group row">
                                                        <div class="col-md-2">
                                                            <input type="hidden" name="id" value="{{ $task->id }}">
                                                            {{ csrf_field() }}
                                                            <input type="submit" class="btn btn-primary" value="未完了">
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
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