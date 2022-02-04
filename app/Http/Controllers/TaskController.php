<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
  public function index()
  {
    $userId = Auth::id();
    $tasks = Task::where('user_id', $userId)->with('status')->get();

    return response()->json($tasks);
  }

  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      $this->validate($request, [
        'title' => ['required', 'string', 'max:120'],
        'date_delivery' => ['required', 'date'],
        'order' => ['required'],
        'status_id' => ['required']
      ]);

      $task = $request->user()
        ->tasks()
        ->create($request->only('title', 'date_delivery', 'order', 'status_id'));

      DB::commit();

      return response()->json($task);
    } catch (\Throwable $th) {
      DB::rollBack();
      throw $th;
    }
  }

  public function update(Request $request, $id)
  {
    try {
      DB::beginTransaction();

      $this->validate($request, [
        'title' => ['required', 'string', 'max:120'],
        'date_delivery' => ['required', 'date'],
        'order' => ['required'],
        'status_id' => ['required']
      ]);

      $task = Task::find($id);
      $task->title = $request->title;
      $task->date_delivery = $request->date_delivery;
      $task->order = $request->order;
      $task->status_id = $request->status_id;
      $task->save();

      DB::commit();

      return response()->json(
        [
          'msg' => 'Task updated successfully',
          'task' => $task
        ],
        201
      );
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        'msg' => $th->getMessage()
      ], 500);
    }
  }

  public function sync(Request $request)
  {
    try {
      DB::beginTransaction();

      $this->validate(request(), [
        'movedTask' => ['required', 'string']
      ]);

      $movedTask = explode('-', $request->movedTask);

      request()->user()->tasks()
        ->find($movedTask[2])
        ->update(['status_id' => $movedTask[1], 'order' => $movedTask[3]]);

      $statusTasks = Status::with('tasks')->get();

      DB::commit();

      return response()->json([
        'tasks' => $statusTasks
      ]);
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        'msg' => $th->getMessage()
      ], 500);
    }
  }
}
