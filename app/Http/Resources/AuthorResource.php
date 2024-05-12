<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'nascimento' => $this->birthdate,
            'livros' =>  $this->books->map(fn ($book) => [
                    'nome' => $book->title,
                    'ano' => $book->published_date,
                ]),            
        ];
    }
}
