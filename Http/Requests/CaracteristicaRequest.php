<?php

namespace Modules\Anuncio\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaracteristicaRequest extends FormRequest
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
            'titulo'=>'required|max:255',
            'tipo'=>'required|in:Privativa,Comum'
        ];
    }

}
