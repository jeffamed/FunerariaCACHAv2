<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Nombre'=>'required|max:45',
            'Estado'=>'required|max:10'
        ];
    }
}
