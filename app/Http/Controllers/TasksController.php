<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Task;
use App\User;

class TasksController extends Controller
{
    
    public function index()
    {
        $data = [];
        if(\Auth::check()){
            $user = \Auth::user();
            return redirect()->route('users.show', ['id'=>$user->id]);
        }else{
            return view('welcome');
        }
    }

    
    public function create()
    {
        $task = new Task;
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    
    public function store(Request $request)
    {

        $this->validate($request,[
            'content'=> 'required|max:191',
            'status' => 'required|max:191',
            ]);
        
        $request->user()->tasks()->create([
            "content" => $request->content,
            "status"  => $request->status,
            ]);

        return redirect()->back();
    }

    
    public function show($id)
    {
        $task = Task::find($id);
        if(\Auth::id() === $task->user_id){
        return view('tasks.show', [
            'task' => $task
        ]);
    }else{
        return redirect('/');
    }
    }
    
    public function edit($id)
    {
        
        $task =Task::find($id);
        if(\Auth::id() === $task->user_id){
        return view('tasks.edit', [
            'task' => $task
        ]);
    }else{
        return redirect('/');
    }
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
             'content' => 'required|max:191',
             'status' => 'required|max:191',
            ]);
        $task =\App\Task::find($id);
        if(\Auth::id() === $task->user_id){
        
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        return redirect()->route('users.show',['id'=>$task->user_id]);
    }else{
        return redirect('/');
         }
    }

    
    public function destroy($id)
    {
        $task = \App\Task::find($id);
        
        if(\Auth::id() === $task->user_id){
            $task->delete();
        }

        return redirect()->back();
    }
}
