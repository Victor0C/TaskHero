<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\Interfaces\TasksServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function __construct(private TasksServiceInterface $taskService)
    {
        
    }

    public function index(TaskRequest $request): JsonResponse
    {
        $user = Auth::user();
        $tasks = [];

        if ($request->query('done') == 1) {
            $tasks = $this->taskService->findDone((int)$user->id, $request->query('title', ''), $request->query('desc', ''));
           
        }
        if ($request->query('done') == 0) {
            $tasks = $this->taskService->findNotDone((int)$user->id, $request->query('title', ''), $request->query('desc', ''));
            
        }
        if($request->query('done') =='') {
            $tasks = $this->taskService->findByUser((int)$user->id, $request->query('title', ''), $request->query('desc', ''));
        }
       
        return response()->json($tasks);
    }

    public function store(TaskRequest $request)
    {
        $taskDTO = new Task();
        $taskDTO->fill($request->all());

        $createdTask = $this->taskService->create($taskDTO);

        return response()->json($createdTask, 201);
    }

    public function show(string $id): JsonResponse
    {
        $task = $this->taskService->find((int)$id);
        return response()->json($task);
    }

    public function findAllTasks(TaskRequest $request): JsonResponse
    {
        $tasks = $this->taskService->findAll($request->query('title', ''), $request->query('desc', ''));
        return response()->json($tasks);
    }

    public function update(TaskRequest $request, string $id): JsonResponse
    {
        $taskDTO = new Task();
        $taskDTO->fill($request->all());

        $updatedTask = $this->taskService->update((int)$id, $taskDTO);

        return response()->json($updatedTask);
    }

    public function destroy(string $id)
    {
        $this->taskService->delete((int)$id);

        return response()->json(null, 204);
    }
}