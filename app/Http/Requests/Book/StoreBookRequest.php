<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'published_date' =>'required|date|date_format:Y-m-d',
            'list_of_authors' =>'required|array',
            'list_of_authors.*' =>'exists:authors,id'
        ];        
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O campo título é obrigatório',
            'title.min' => 'O tamanho mínimo para o campo título é de 3 caracteres',
            'title.max' => 'O tamanho máximo para o campo título é de 255 caracteres',
            'published_date.required' => 'O campo data de publicação é obrigatório',
            'published_date.date' => 'O campo data de publicação deve ser uma data válida',
            'published_date.date_format' => 'O campo data de publicação deve estar no formato AAAA-MM-DD',
            'list_of_authors.required' => 'O campo lista de autores é obrigatório',
            'list_of_authors.*.exists' => 'Os autores devem existir na base de dados'
        ];
    }
}
