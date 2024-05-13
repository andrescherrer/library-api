<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'data empréstimo' => $this->loan_date,
            'data retorno' => $this->return_date,
            'user_id' => $this->user_id,
            'usuario' => $this->user->name,
            'book_id' => $this->book_id,
            'book' => $this->book->title,            
        ];
    }
}
