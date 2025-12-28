<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function bulkStore(Project $project, Request $request)
    {
        try {
            DB::transaction(function () use ($project, $request) {
                foreach ($request->tasks as $taskData) {
                    $task = $project->tasks()->create([
                        'title' => $taskData['title'],
                        'priority' => $taskData['priority'],
                        'status' => 'open',
                    ]);

                    $task->assignees()->sync($taskData['assignees'] ?? []);

                    foreach ($taskData['subtasks'] ?? [] as $subtask) {
                        $task->subtasks()->create($subtask);
                    }

                    TaskCreated::dispatch($task);
                }
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Tasks created successfully'
            ], 201);

        } catch (\Throwable $e) {
            Log::error('Task bulk create failed', [
                'error' => $e->getMessage(),
                'request_id' => $request->header('X-Request-ID')
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create tasks'
            ], 500);
        }
    }
}
