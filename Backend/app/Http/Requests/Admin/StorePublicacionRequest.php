<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id' => ['nullable', 'integer', 'exists:eventos,id'],
            'titulo'    => ['required', 'string', 'max:150'],
            'contenido' => ['required', 'string'],
            'tipo'      => ['sometimes', 'in:Noticia,Aviso_Staff'],
        ];
    }
}