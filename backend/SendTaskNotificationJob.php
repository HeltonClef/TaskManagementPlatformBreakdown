<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskNotificationJob implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        // Example: send email / push notification
    }
}
