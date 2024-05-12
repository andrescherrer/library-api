<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\IndexAuthorRequest;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function index(IndexAuthorRequest $request): AuthorCollection
    {                
        $authors = $this->filter($request);

        return new AuthorCollection($authors);
    }

    public function store(StoreAuthorRequest $request)
    {
        Author::create([
            'name' => $request->get('name'),
            'birthdate' => $request->get('birthdate'),
        ]);

        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    public function show(Author $author): AuthorResource
    {
        $author = $author->load('books');
        
        return new AuthorResource($author);
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

    private function filter($request)
    {
        return Author::when($request->name, function($query) use ($request) {
            $query->where('name', 'LIKE', "%".$request->name."%");
        })
        ->orderBy('name')
        ->paginate();
    }
}
