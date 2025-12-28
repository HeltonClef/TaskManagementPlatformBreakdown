<?php

namespace App\Events;

use App\Models\Task;

class TaskCreated
{
    public function __construct(public Task $task) {}
}
