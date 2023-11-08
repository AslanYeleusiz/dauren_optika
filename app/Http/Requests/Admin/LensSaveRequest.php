<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LensSaveRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type_id' => 'required',
            'img' => 'required',
            'value' => 'required',
            'dpt' => 'required',
            'price' => 'required',
        ];
    }
}
