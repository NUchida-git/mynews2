<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Task;
use App\User;
use App\Category;
use App\Tag;
use App\TaskTags;
// use App\taskHistory;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function add()
    {
        $priorityList = Task::PRIORITY_LIST;
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.task.create', compact('priorityList', 'users', 'categories', 'tags'));
    }

    public function create(Request $request)
    {

        // Varidationを行う
        $this->validate($request, Task::$rules);

        $task = new Task;
        $form = $request->all();
        $tags = $form['task_tags'];

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        unset($form['task_tags']);

        // データベースに保存する
        $user = Auth::user();
        $task->fill($form);
        $task->user_id = $user->id;
        $task->is_complete = 0;
        $task->save();
        $task->tags()->sync($tags);
    
        return redirect('admin/task');
    }

    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $task = Task::find($request->id);
        if (empty($task)) {
            abort(404);    
        }

        $priorityList = Task::PRIORITY_LIST;
        $categories = Category::all();
        $tags = Tag::all();
        $taskTags =TaskTags::where('task_id',$request->id)->pluck('tag_id')->toArray();
        // dd($taskTags);
        return view('admin.task.edit', compact('task', 'priorityList', 'categories', 'tags', 'taskTags'));
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Task::$rules);
        // News Modelからデータを取得する
        $task = Task::find($request->id);
        // 送信されてきたフォームデータを格納する
        $form = $request->all();
        $tags = $form['task_tags'];

        unset($form['_token']);
        unset($form['task_tags']);

        // 該当するデータを上書きして保存する
        $task->fill($form)->save();
        $task->tags()->sync($tags);

        // //編集履歴
        // $task_history = new taskHistory;
        // $task_history->task_id = $task->id;
        // $task_history->edited_at = Carbon::now();
        // $task_history->save();

        return redirect('admin/task');
    }
    
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        $cond_category_id = $request->cond_category_id;
        $user = Auth::user();

        $postQuery = Task::where('is_complete', 0)
                    ->where('user_id', $user->id)
                    ->orderBy('priority','DESC')
                    ->orderBy('deadline_date','ASC');

        if ($cond_name != '') {
            // 検索されたら検索結果を取得する
            $postQuery->where('name', 'like', "%{$cond_name}%");
        }

        if ($cond_category_id != '') {
            // 検索されたら検索結果を取得する
            $postQuery->where('category_id', $cond_category_id);
        }

        $posts = $postQuery->get();
        
        $priorityList = Task::PRIORITY_LIST;
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.task.index', compact('posts', 'cond_name', 'priorityList', 'categories', 'cond_category_id'));
    }

    public function indexComp(Request $request)
    {
        $cond_name = $request->cond_name;
        $user = Auth::user();
        if ($cond_name != '') {
            // 検索されたら検索結果を取得する
            $posts = Task::where('name', $cond_name)
                    ->where('is_complete', 1)
                    ->where('user_id', $user->id)
                    ->orderBy('priority','ASC')
                    ->orderBy('deadline_date','DESC')
                    ->get();
        } else {
            // それ未完了すべてのニュースを取得する
            $posts = Task::where('is_complete', 1)
                    ->where('user_id', $user->id)
                    ->orderBy('priority','ASC')
                    ->orderBy('deadline_date','DESC')
                    ->get();
        }

        $priorityList = Task::PRIORITY_LIST;
        return view('admin.task.indexComp', ['posts' => $posts, 'cond_name' => $cond_name, 'priorityList' => $priorityList]);
    }

    public function delete(Request $request)
    {
        $task = Task::find($request->id);
        // 削除する
        $task->delete();
        return redirect('admin/task/');
    }

    public function complete(Request $request)
    {
        $task = Task::find($request->id);
        $task->is_complete = 1;
        $task->save();
        return redirect('admin/task');
    }

    public function incomplete(Request $request)
    {
        $task = Task::find($request->id);
        $task->is_complete = 0;
        $task->save();
        return redirect('admin/task/completed_list');
    }


}
