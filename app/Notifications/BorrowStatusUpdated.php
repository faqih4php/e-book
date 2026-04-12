<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Borrowing;

class BorrowStatusUpdated extends Notification
{
    use Queueable;

    protected $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statusText = $this->borrowing->status === 'approved' ? 'approved' : 'rejected';
        $color = $this->borrowing->status === 'approved' ? 'success' : 'danger';
        $icon = $this->borrowing->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle';

        return [
            'message' => 'Your borrow request for: ' . $this->borrowing->book->title . ' has been ' . $statusText,
            'url' => route('user.borrowings.index'),
            'icon' => $icon,
            'color' => $color,
        ];
    }
}
