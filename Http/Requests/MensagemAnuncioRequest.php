<?php

namespace Modules\Anuncio\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MensagemAnuncioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome'=>'required|max:255',
            'email'=>'required|email|max:255',
            'ddd'=>'required|integer',
            'telefone'=>'required|max:255',
            'texto'=>'required|max:500',
        ];
    }
}
