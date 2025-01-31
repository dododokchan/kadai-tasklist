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
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user(); //認証済みユーザーを取得
            $tasks = $user->tasks()->orderBy('id', 'desc')->paginate(25);
        
                        //タスク一覧取得
                        //$tasks = Task::all();
                        //$tasks = Auth::user()->tasks;
        
                    //$tasks = Task::where('user_id', $task->id)->get;
                        
                        //タスク一覧ビューで表示（View側で呼び出すtasksに、$tasksを渡す）
                        return view('tasks.index', ['tasks' => $tasks, ]);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
        return view('dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     * 新規タスク作成ページ
     */
    public function create()
    {
        $task = new Task; //新規タスクのインスタンス作成
        
        //タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
        
       return view('tasks.index');
    }

    /**
     * Store a newly created resource in storage.
     * 新規タスク作成処理
     */
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        //タスクを作成
        $task = new Task;
        $task->status = $request->status; // ステータスが10文字以上でない場合のみOK
        $task->content = $request->content; //タスクが255文字以上でない場合のみOK
        $task->user_id = \Auth::id();
        $task->save();
        
        //トップページへリダイレクト
        return redirect('/');
        // URL「/」にリダイレクトする = TasksController@indexに処理を飛ばす
    }

    /**
     * Display the specified resource.
     * タスク個別ページ
     */
    public function show($id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //ログインユーザーかつタスク作成者なら、タスク詳細ビュー表示
        if (\Auth::id() == $task->user_id) {
            return view('tasks.show', [
                'task' => $task, ]);
        }
        //ログインしてなかったらリダイレクト
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     * タスク編集ページ
     */
    public function edit($id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //ログインユーザーかつタスク作成者なら、タスク編集ビュー表示
        if (\Auth::id() == $task->user_id) {
            return view('tasks.edit', [
                'task' => $task, ]);
        }
        //ログインしてなかったらリダイレクト
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     * タスク更新処理
     */
    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);
        
        //idでタスクを検索して取得
        //フォームから送られてきたcontentはrequestに入っているので、requestから取り出して登録
        $task = Task::findOrFail($id);
        
        //ログインユーザーかつタスク作成者なら、タスクを更新
        if (\Auth::id() == $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        
        //トップページへリダイレクト
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     * タスク削除処理
     */
    public function destroy($id)
    {
        //idでタスクを検索して取得
        $task = Task::findOrFail($id);

        //タスク削除
        if (\Auth::id() == $task->user_id) {
            $task->delete();
            
        }
        
        //トップページへリダイレクト
        return redirect('/'); 
       
    }
}
