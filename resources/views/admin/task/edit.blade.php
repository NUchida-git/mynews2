@extends('layouts.admin')
@section('title', 'タスクの編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>タスク編集</h2>
                <form action="{{ action('Admin\TaskController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="name">タスク名</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="name" rows="20">{{ $task_form->name }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">期限日</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="deadline_date" value="{{ $task_form->deadline_date }}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">優先度</label>
                        <div class="col-md-10">
                            <!--<input type="text" class="form-control" name="priority" value="ç" >-->
                            <select name='priority'>
                                @foreach($priorityList as $k => $v)
                                    @if ($k == $task_form->priority)
                                        <option value="{{ $k }}" selected="true" >{{ $v }}</option>
                                    @else
                                        <option value="{{ $k }}" >{{ $v }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2">カテゴリー</label>
                        <div class="col-md-10">
                            <select name='category_id'>
                                @foreach($categories as $category)
                                    @if ($category->id == $task_form->category_id)
                                        <option value="{{ $category->id }}" selected="true" >{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $task_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
                <!--<div class="row mt-5">-->
                <!--    <div class="col-md-4 mx-auto">-->
                <!--        <h2>編集履歴</h2>-->
                <!--        <ul class="list-group">-->
                <!--            @if ($task_form->taskHistories != NULL)-->
                <!--                @foreach ($task_form->taskHistories as $taskhistory)-->
                <!--                    <li class="list-group-item">{{ $taskhistory->edited_at }}</li>-->
                <!--                @endforeach-->
                <!--            @endif-->
                <!--        </ul>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </div>
@endsection