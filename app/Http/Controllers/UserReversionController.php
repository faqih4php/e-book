<?php

namespace App\Http\Controllers;

use App\Models\Reversion;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReturnRequested;

class UserReversionController extends Controller
{
    public function index()
    {
        // View user's borrowed books that haven't been returned yet
        // Check if there's no reversion yet or status of borrowing is not yet completely returned
        $borrowings = Borrowing::query()->where('user_id', auth()->id())
            ->where('status', 'approved')
            // fugnsi untuk mengecek
            ->where(function($query) {
                $query->whereDoesntHave('reversion')
                    ->orWhereHas('reversion', function($q) {
                        $q->where('status', 'rejected');
                    });
            })
            ->with(['book', 'reversion'])
            ->get();

        return view('users.reversions.index', compact('borrowings'));
    }

    public function store(Request $request, $borrowing_id)
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $borrowing = Borrowing::where('user_id', auth()->id())->findOrFail($borrowing_id);
        
        if ($borrowing->status !== 'approved') {
            return redirect()->back()->with('error', 'You cannot return a book that is not approved.');
        }

        // Create reversion request
        $reversion = Reversion::create([
            'borrowing_id' => $borrowing->id,
            'notes' => $request->notes,
        ]);

        $admins = \App\Models\User::query()->where('role', 'admin')->get();
        Notification::send($admins, new ReturnRequested($reversion));

        return redirect()->route('user.reversions.index')->with('success', 'Return request submitted. Please wait for admin to verify.');
    }
}
