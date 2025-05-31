<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Tambahkan logika pencarian jika ada keyword
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('judul', 'like', '%' . $keyword . '%')
                  ->orWhere('penulis', 'like', '%' . $keyword . '%')
                  ->orWhere('penerbit', 'like', '%' . $keyword . '%')
                  ->orWhereHas('category', function ($q) use ($keyword) {
                      $q->where('nama_kategori', 'like', '%' . $keyword . '%');
                  });
        }

        $books = $query->paginate(10);

        // Check user role to determine which view to load
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.books.index', compact('books'));
        } else {
            return view('user.books.index', compact('books'));
        }
    }

    public function create()
    {
        $categories = Category::all();
        // Admin view for creating books
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books',
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'nullable|exists:categories,id',
            'jumlah_halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $book = Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        // Check user role to determine which view to load
        if (Auth::check() && Auth::user()->role === 'admin') {
             return view('admin.books.show', compact('book'));
        } else {
             return view('user.books.show', compact('book'));
        }
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        // Admin view for editing books
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'penulis' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'category_id' => 'nullable|exists:categories,id',
            'jumlah_halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
} 