<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Book $book)
    {
        $books = $book->newQuery();
        if ($request->isMethod('post')) {
            if ($request->input('title')) $books->where('title', $request->input('title'));
            if ($request->input('author_id')) $books->where('author_id', $request->input('author_id'));
            if ($request->input('is_borrowed')) $books->where('is_borrowed', ($request->input('is_borrowed') - 1));
        }
        return response()->json($books->orderBy('created_at', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'author_id' => 'required|gt:0',
        ]);

        Book::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book, $id)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'author_id' => 'required|gt:0',
        ]);

        $book = $book->findOrFail($id);
        $book->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book, $id)
    {
        return $book->findOrFail($id)->delete();
    }


    /**
     * Change the specified resource in storage.
     *
     * @param  \App\Models\Book  $book
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Book $book, $id)
    {
        $book = $book->findOrFail($id);
        $book->update(['is_borrowed' => !$book->is_borrowed]);
    }
}
