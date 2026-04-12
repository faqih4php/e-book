<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        // View pending borrowing requests
        $borrowings = Borrowing::with(['book', 'user'])
            ->where('status', 'pending')
            ->get();
            
        return view('admins.borrowings.index', compact('borrowings'));
    }

    public function approve(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Borrowing request is not pending.');
        }
        
        $borrowing->update(['status' => 'approved']);

        $borrowing->user->notify(new \App\Notifications\BorrowStatusUpdated($borrowing));

        return redirect()->route('borrowings.index')->with('success', 'Borrowing request approved successfully.');
    }

    public function reject(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Borrowing request is not pending.');
        }

        $borrowing->update(['status' => 'rejected']);
        $borrowing->book->increment('stock');

        $borrowing->user->notify(new \App\Notifications\BorrowStatusUpdated($borrowing));

        return redirect()->route('borrowings.index')->with('success', 'Borrowing request rejected.');
    }
}
