<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
// use App\History;
// use Carbon\Carbon;

class CategoryController extends Controller
{
    public function add()
    {
        return view('admin.category.create');
    }
    
    public function create(Request $request)
    {

        // 以下を追記
        // Varidationを行う
        $this->validate($request, Category::$rules);

        $category = new Category;
        $form = $request->all();

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $category->fill($form);
        $category->save();

        return redirect('admin/category');
    }
    
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            // 検索されたら検索結果を取得する
            $posts = Category::where('name', $cond_name)->get();
        } else {
            // それ以外はすべてのニュースを取得する
            $posts = Category::all();
        }
        return view('admin.category.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }

    public function edit(Request $request)
    {
        // News Modelからデータを取得する
        $category = Category::find($request->id);
        if (empty($category)) {
            abort(404);    
        }
        return view('admin.category.edit', ['category_form' => $category]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Category::$rules);
        // News Modelからデータを取得する
        $category = Category::find($request->id);
        // 送信されてきたフォームデータを格納する
        $category_form = $request->all();
        unset($category_form['_token']);

        // 該当するデータを上書きして保存する
        $category->fill($category_form)->save();

        return redirect('admin/category');
    }

    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $category = Category::find($request->id);
        // 削除する
        $category->delete();
        return redirect('admin/category/');
    }
}
