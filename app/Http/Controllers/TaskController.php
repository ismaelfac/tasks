<?php

namespace App\Http\Controllers;

use App\Cms\Task\TaskRepo;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function getRepo(): TaskRepo
    {
        return new TaskRepo();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return jsend_success($this->getRepo()->index());
        } catch (\Exception $e) {
            return jsend_error('Error: '.$e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            return jsend_success($this->getRepo()->store($request));
        } catch (\Exception $e) {
            return jsend_error('Error: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            return jsend_success($this->getRepo()->show($task));
        } catch (\Exception $e) {
            return jsend_error('Error: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'due_date' => 'required|string',
            ]);
            if ($validatedData->fails()) {
                return jsend_fail($validatedData->errors()->all());
            }
            return jsend_success($this->getRepo()->update($request, $task));
        } catch (\Exception $e) {
            return jsend_error('Error: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
