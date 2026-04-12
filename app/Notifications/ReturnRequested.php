<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Reversion;

class ReturnRequested extends Notification
{
    use Queueable;

    protected $reversion;

    public function __construct(Reversion $reversion)
    {
        $this->reversion = $reversion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New return request for: ' . $this->reversion->borrowing->book->title . ' from ' . $this->reversion->borrowing->user->name,
            'url' => route('reversions.index'),
            'icon' => 'fa-undo',
            'color' => 'warning',
        ];
    }
}
