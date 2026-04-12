<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Reversion;

class ReturnStatusUpdated extends Notification
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
        $statusText = $this->reversion->status === 'approved' ? 'approved' : 'rejected';
        $color = $this->reversion->status === 'approved' ? 'success' : 'danger';
        $icon = $this->reversion->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle';

        return [
            'message' => 'Your return request for: ' . $this->reversion->borrowing->book->title . ' has been ' . $statusText,
            'url' => route('user.reversions.index'),
            'icon' => $icon,
            'color' => $color,
        ];
    }
}
