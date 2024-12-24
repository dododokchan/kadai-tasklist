<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task; //Modelは App\Models 直下に生成・配置される。Model名はTask

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //タスク一覧取得
        $tasks = Task::all();
        
        //タスク一覧ビューで表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;
        
        //タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //タスクを作成
        $task = new Task;
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクト
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク詳細ビューで表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク編集ビューで表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);
        //タスクを更新
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクト
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);
        //タスク削除
        $task->delete();
        
        //トップページへリダイレクト
        return redirect('/');
    }
}
