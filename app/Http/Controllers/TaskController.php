<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_user = Auth::user();
        $tasks =  Auth::user()->tasks()->get();
        $keyword = $request->input('keyword');
        $query = Task::query();

        if(!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%");
            $tasks = $query->get();
        }

        return view('tasks/index', [
            'tasks' => $tasks,
            'keyword' => $keyword,
        ]);
    }


    /**
     * GET /users/{id}/tasks/new
     */
    public function new()
    {
        return view('tasks/new', [
            
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateTask $request)
    {
        $current_user= Auth::user();
        $task = new Task();
        $task->user_id = Auth::id();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        Auth::user()->tasks()->create($request->all());
        return redirect()->route('tasks.index', [
            'id' => $current_user->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function editShow(int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(int $task_id, EditTask $request)
    {
        $task = Task::find($task_id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
