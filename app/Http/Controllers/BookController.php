<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan semua data buku.
     */
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar semua buku',
            'data' => $books,
        ]);
    }

    /**
     * Menyimpan data buku baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:9999',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book,
        ], 201);
    }

    /**
     * Menampilkan detail satu buku.
     */
    public function show(Book $book)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail buku',
            'data' => $book,
        ]);
    }

    /**
     * Mengupdate data buku.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'publisher' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1000|max:9999',
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diupdate',
            'data' => $book,
        ]);
    }

    /**
     * Menghapus data buku.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus',
        ]);
    }
}
