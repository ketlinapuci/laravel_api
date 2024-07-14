<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('priority')
            ->handleSort(request()->query('sort_by') ?? 'time')
            ->get();

        return TaskResource::collection($tasks);    }

//SINCE WE'RE BUILDING API WE DON'T NEED TO DEFINE THE CREATE METHOD SO WE GET RID OF IT

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //Call task model & save incoming request by calling create method & pass the request
        //Create will return the model instance
        $task = Task::create($request->validated());
        $task->load('priority');
        return TaskResource::make($task);

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return TaskResource::make($task);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
