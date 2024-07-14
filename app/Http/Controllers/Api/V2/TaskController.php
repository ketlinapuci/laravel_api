<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return all tasks that belong to current user signed in
        $userTasks = auth()->user()
            ->tasks()
            ->handleSort(request()->query('sort_by') ?? 'time')
            ->with('priority')
            ->get();

        return TaskResource::collection($userTasks);
    }

//SINCE WE'RE BUILDING API WE DON'T NEED TO DEFINE THE CREATE METHOD SO WE GET RID OF IT

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //when creating a new task we need to associate the task with the current user
        $task = $request->user()->tasks()->create($request->validated());
        $task->load('priority');
        return TaskResource::make($task);

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('priority');

        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        $task->load('priority');

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
