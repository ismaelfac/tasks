<?php

namespace App\Cms\Task;

use App\Cms\BaseRepo\BaseRepo;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepo extends BaseRepo
{
    public function getModel(): Task
    {
        return new Task();
    }

    public function index() 
    {
        $isAdmin = Auth::user()->roles()->pluck('name')->first();
        return $this->getModel()->when($isAdmin !== 'SUPERADMIN', function ($query) {
            return $query->where('user_id',  Auth::user()->id)->where('status', true);
        }, function ($query) {
            return $query->where('status', true);
        })->get();
    }

    public function show($task) {
        $isAdmin = Auth::user()->roles()->pluck('name')->first();
        return $this->getModel()->when($isAdmin !== 'SUPERADMIN', function ($query) use ($task) {
            return $query->where('user_id',  Auth::user()->id)->where('id', $task->id)->where('status', true);
        }, function ($query) use ($task) {
            return $query->where('id', $task->id)->where('status', true);
        })->get();
    }

    public function store($request)
    {
        return $this->getModel()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => true,
            'user_id' => is_null(Auth::user()) ? 1 : Auth::user()->id 
        ]);
    }

    public function update($request, $task)
    {
        return $this->getModel()
            ->where('id', $task->id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'status' => is_null($request->active) ? true : $request->active,
                'user_id' => is_null(Auth::user()) ? 1 : Auth::user()->id 
            ]);
    }
}