<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware(['auth:sanctum', 'throttle:60,1'])
    ->post('/projects/{project}/tasks/bulk', [TaskController::class, 'bulkStore']);