<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Borrowing;

class BorrowRequested extends Notification
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
        return [
            'message' => 'New borrow request for: ' . $this->borrowing->book->title . ' from ' . $this->borrowing->user->name,
            'url' => route('borrowings.index'),
            'icon' => 'fa-book-open',
            'color' => 'primary',
        ];
    }
}
