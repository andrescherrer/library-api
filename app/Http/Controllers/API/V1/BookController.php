<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\IndexBookRequest;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(IndexBookRequest $request): BookCollection
    {
        $books = $this->filter($request);

        return new BookCollection($books);
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        DB::transaction(function() use($request) {
            $book = Book::create([
                'title' => $request->get('title'),
                'published_date' => $request->get('published_date'),
            ]);

            $listOfAuthors = $request->get('list_of_authors');

            $book->authors()->sync($listOfAuthors);
        });
        
        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    public function show(Book $book): BookResource
    {
        $book = $book->load('authors');

        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        DB::transaction(function() use($request, $book) {
            $bookTitle = $request->get('title', $book->title);
            $bookPublishedDate = $request->get('published_date', $book->published_date);
            $listOfAuthors = $request->get('list_of_authors');

            $book->update([
                'title' => $bookTitle,
                'published_date' => $bookPublishedDate,
            ]);

            if (isset($listOfAuthors)) 
                $book->authors()->sync($listOfAuthors);
        });

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    private function filter($request)
    {
        return Book::when($request->title, function($query) use ($request) {
            $query->where('title', 'LIKE', "%".$request->title."%");
        })
        ->orderBy('title')
        ->paginate();
    }
}
