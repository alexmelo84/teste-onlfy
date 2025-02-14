<?php

namespace App\Jobs;

use App\Interface\NotificationInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotification implements ShouldQueue
{
    use Queueable;

    /**
     * @var NotificationInterface
     */
    protected NotificationInterface $notification;

    /**
     * @var array
     */
    protected array $data;

    /**
     * Create a new job instance.
     * 
     * @param NotificationInterface $notification
     * @param array $data
     */
    public function __construct(
        NotificationInterface $notification,
        array $data
    ) {
        $this->notification = $notification;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->notification->notify($this->data);
    }
}
