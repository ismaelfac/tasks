<?php

namespace App\Cms\Task;

use App\Cms\BaseRepo\BaseRepo;
use App\Models\Task;

class TaskRepo extends BaseRepo
{
    public function getModel(): Task
    {
        return new Task();
    }

    public function store($request)
    {
    
    }

    public function update($request, $task)
    {
    
    }
}