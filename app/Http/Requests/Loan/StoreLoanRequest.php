<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date|date_format:Y-m-d',
            'return_date' => 'required|date|date_format:Y-m-d'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo user_id é obrigatório',
            'user_id.exists' => 'O id do usuário deve existir na base de dados',
            'book_id.required' => 'O campo book_id é obrigatório',
            'book_id.exists' => 'O id do livro deve existir na base de dados',
            'loan_date.required' => 'O campo data de empréstimo é obrigatório',
            'loan_date.date' => 'O campo data de empréstimo deve ser uma data válida',
            'loan_date.date_format' => 'O campo data de empréstimo deve estar no formato AAAA-MM-DD',
            'return_date.required' => 'O campo data de devolução é obrigatório',
            'return_date.date' => 'O campo data de devolução deve ser uma data válida',
            'return_date.date_format' => 'O campo data de devolução deve estar no formato AAAA-MM-DD',
        ];
        
    }
}
