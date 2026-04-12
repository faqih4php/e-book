<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $books = Book::query()->when($query, function($q) use ($query) {
            return $q->where('title', 'like', "%{$query}%")
                     ->orWhere('author', 'like', "%{$query}%")
                     ->orWhere('synopsis', 'like', "%{$query}%");
        })->get();

        return view('users.borrowings.index', compact('books', 'query'));
    }

    public function create($book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('users.borrowings.create', compact('book'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
            'notes' => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Book is out of stock.');
        }

        $book->decrement('stock');

        $borrowing = Borrowing::create([
            'book_id' => $request->book_id,
            'user_id' => auth()->id(),
            'borrow_date' => date('Y-m-d', strtotime($request->borrow_date)),
            'return_date' => date('Y-m-d', strtotime($request->return_date)),
            'notes' => $request->notes,
            'status' => 'pending', // Pending admin approval
        ]);

        $admins = \App\Models\User::query()->where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\BorrowRequested($borrowing));

        // Don't update book status to borrowed until admin approves
        return redirect()->route('user.borrowings.index')->with('success', 'Borrowing request submitted successfully. Please wait for admin approval.');
    }
}
