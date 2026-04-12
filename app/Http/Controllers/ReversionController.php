<?php

namespace App\Http\Controllers;

use App\Models\Reversion;
use Illuminate\Http\Request;

class ReversionController extends Controller
{
    public function index()
    {
        // View pending reversion requests
        $reversions = Reversion::with(['borrowing.book', 'borrowing.user'])
            ->where('status', 'pending')
            ->get();
            
        return view('admins.reversions.index', compact('reversions'));
    }

    public function approveReturn(Request $request, $borrowing_id)
    {
        $reversion = Reversion::where('borrowing_id', $borrowing_id)
            ->where('status', 'pending')
            ->firstOrFail();

        $reversion->update(['status' => 'approved']);
        
        // Update borrowing record if needed, but the main thing is the book status
        $reversion->borrowing->book->update(['status' => 'available']);

        $reversion->borrowing->user->notify(new \App\Notifications\ReturnStatusUpdated($reversion));

        return redirect()->route('reversions.index')->with('success', 'Return request approved. Book is now available.');
    }

    public function rejectReturn(Request $request, $borrowing_id)
    {
        $reversion = Reversion::where('borrowing_id', $borrowing_id)
            ->where('status', 'pending')
            ->firstOrFail();

        $reversion->update(['status' => 'rejected']);

        $reversion->borrowing->user->notify(new \App\Notifications\ReturnStatusUpdated($reversion));

        return redirect()->route('reversions.index')->with('success', 'Return request rejected.');
    }
}
