<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class OpacController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('author', 'like', "%{$request->author}%");
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('opac.search', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load('category');
        
        // Check if book is available
        $isAvailable = $book->isAvailable();
        
        // Get current user's member record if logged in
        $member = auth()->check() && auth('member')->user()->isMember() 
            ? auth('member')->user()->member 
            : null;
        
        // Check if user has active booking for this book
        $hasBooking = $member 
            ? $member->bookings()->where('book_id', $book->id)->where('status', 'pending')->exists()
            : false;

        return view('opac.detail', compact('book', 'isAvailable', 'hasBooking'));
    }
}
