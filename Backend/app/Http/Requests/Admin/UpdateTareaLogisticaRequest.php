<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaLogisticaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id'   => ['nullable', 'integer', 'exists:eventos,id'],
            'staff_id'    => ['sometimes', 'required', 'integer', 'exists:usuarios,id'],
            'titulo'      => ['sometimes', 'required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'estatus'     => ['sometimes', 'required', 'in:Pendiente,En_Progreso,Completada'],
        ];
    }
}