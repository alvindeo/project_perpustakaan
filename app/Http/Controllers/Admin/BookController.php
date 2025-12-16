<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');
        
        // Search
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
        
        $books = $query->paginate(15);
        $categories = Category::all();
        
        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:books',
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable',
            'publication_year' => 'nullable|integer',
            'synopsis' => 'nullable',
            'cover_image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['available'] = $validated['stock'];

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book = Book::create($validated);

        // Generate QR Code using SVG format (no image extension required)
        try {
            $qrCode = QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H')
                ->generate($book->isbn);
            $qrPath = 'qrcodes/books/' . $book->id . '.svg';
            Storage::disk('public')->put($qrPath, $qrCode);
            $book->update(['qr_code' => $qrPath]);
        } catch (\Exception $e) {
            // If QR generation fails, continue without it
            \Log::warning('QR Code generation failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        $book->load('category', 'transactions');
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $book->id,
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable',
            'publication_year' => 'nullable|integer',
            'synopsis' => 'nullable',
            'cover_image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        // Update available count if stock changed
        if ($validated['stock'] != $book->stock) {
            $diff = $validated['stock'] - $book->stock;
            $validated['available'] = max(0, $book->available + $diff);
        }

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->qr_code) {
            Storage::disk('public')->delete($book->qr_code);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }

    public function generateQR(Book $book)
    {
        if ($book->qr_code && Storage::disk('public')->exists($book->qr_code)) {
            $content = Storage::disk('public')->get($book->qr_code);
            $contentType = str_ends_with($book->qr_code, '.svg') ? 'image/svg+xml' : 'image/png';
            return response($content)->header('Content-Type', $contentType);
        }

        $qrCode = QrCode::format('svg')->size(300)->generate($book->isbn);
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}
