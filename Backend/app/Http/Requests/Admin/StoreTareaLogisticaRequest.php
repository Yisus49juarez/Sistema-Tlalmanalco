<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareaLogisticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id'   => ['nullable', 'integer', 'exists:eventos,id'],
            'staff_id'    => ['required', 'integer', 'exists:usuarios,id'],
            'titulo'      => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}