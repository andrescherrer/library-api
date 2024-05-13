<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'min:3|max:255',
            'published_date' =>'date|date_format:Y-m-d',
            'list_of_authors' =>'array',
            'list_of_authors.*' =>'exists:authors,id'
        ];        
    }

    public function messages(): array
    {
        return [            
            'title.min' => 'O tamanho mínimo para o campo título é de 3 caracteres',
            'title.max' => 'O tamanho máximo para o campo título é de 255 caracteres',
            'published_date.date' => 'O campo data de publicação deve ser uma data válida',
            'published_date.date_format' => 'O campo data de publicação deve estar no formato AAAA-MM-DD',
            'list_of_authors.array' => 'A lista de autores deve ser um array de inteiros válidos',
            'list_of_authors.*.exists' => 'Os autores devem existir na base de dados'
        ];
    }
}
