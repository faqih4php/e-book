<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;

class HomeController extends Controller
{
    public function dashboardAdmin()
    {
        $userCount = User::query()->count();
        $bookCount = Book::query()->count();
        $availableBooks = Book::query()->where('status', 'available')->count();
        $borrowedBooks = Book::query()->where('status', 'borrowed')->count();

        return view('admins.dashboard', compact('userCount', 'bookCount', 'availableBooks', 'borrowedBooks'));
    }

    public function dashboardUser()
    {
        $books = Book::all();
        $borrowings = \App\Models\Borrowing::query()->where('user_id', auth()->id())->get();
        return view('users.dashboard', compact('books', 'borrowings'));
    }
}
