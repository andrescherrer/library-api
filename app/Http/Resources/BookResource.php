<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'titulo' => $this->title,
            'data_publicacao' => $this->published_date,
            'autores' => $this->authors->map(fn ($author) => [
                'nome' => $author->name,
                'nascimento' => $author->birthdate,
            ]),            
        ];
    }
}
