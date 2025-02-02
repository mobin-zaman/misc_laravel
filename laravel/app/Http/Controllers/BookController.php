<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index()
    {
        return BookResource::collection(Book::with('ratings')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = Book::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Book $book)
    {
        if($request->user()->id !== $book->user_id) {
            return response()->json(['error' => 'You can only edit your own books'], 403);
        }

        $book->update($request->only(['title', 'description']));

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response() ->json(null, 204);
    }
}
