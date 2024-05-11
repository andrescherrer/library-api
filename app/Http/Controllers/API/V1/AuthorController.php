<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function index()
    {
        return Author::with('books')->paginate();
    }

    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create([
            'name' => $request->get('name'),
            'birthdate' => $request->get('birthdate'),
        ]);

        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    public function show(Author $author)
    {
        return $author->load('books');
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $authorName = $request->get('name', $author->name);
        $authorBirthdate = $request->get('birthdate', $author->birthdate);

        $author->update([
            'name' => $authorName,
            'birthdate' => $authorBirthdate,
        ]);
        
        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
