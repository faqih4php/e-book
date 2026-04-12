<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('admins.books.base', compact('books'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', "%{$query}%")
                    ->orWhere('author', 'like', "%{$query}%")
                    ->get();

        return view('admins.books.search', compact('books', 'query'));
    }

    public function create()
    {
        return view('admins.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'publication_year' => 'required|date',
            'page' => 'required|integer|min:1',
            'synopsis' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('books', 'public');

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => date('Y', strtotime($request->publication_year)),
            'page' => $request->page,
            'synopsis' => $request->synopsis,
            'stock' => $request->stock,
            'image' => $imagePath,
            'status' => 'available',
        ]);

        return redirect()->route('books.index')->with('success', 'Book successfully created.');
    }

    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admins.books.show', compact('book'));
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        return view('admins.books.edit', compact('book'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'publication_year' => 'required|date',
            'page' => 'required|integer|min:1',
            'synopsis' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book = Book::findOrFail($id);

        $data = [
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => date('Y', strtotime($request->publication_year)),
            'page' => $request->page,
            'synopsis' => $request->synopsis,
            'stock' => $request->stock,
        ];

        if ($request->hasFile('image')) {
            if ($book->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($book->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book successfully updated.');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        
        if ($book->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($book->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($book->image);
        }
        
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book successfully deleted.');
    }
}
