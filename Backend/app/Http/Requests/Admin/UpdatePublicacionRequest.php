<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id' => ['nullable', 'integer', 'exists:eventos,id'],
            'titulo'    => ['sometimes', 'required', 'string', 'max:150'],
            'contenido' => ['sometimes', 'required', 'string'],
            'tipo'      => ['sometimes', 'in:Noticia,Aviso_Staff'],
        ];
    }
}