<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'birthdate' => 'required|date|date_format:Y-m-d'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.min' => 'O tamanho mínimo para o campo nome é 3 caracteres',
            'name.max' => 'O tamanho máximo para o campo nome é de 255 caracteres',
            'birthdate.required' => 'O campo data de nascimento é obrigatório',
            'birthdate.date' => 'O campo data de nascimento deve ser uma data válida',
            'birthdate.date_format' => 'O campo data de nascimento deve estar no formato AAAA-MM-DD',
        ];
    }
}
