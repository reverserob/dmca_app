<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PrepareNoticeRequest extends Request
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
            'infringing_title' => '',
            'infringing_link' => '',
            'original' => '',
            'infringing_provider' => '',

        ];


       /* return [
            'infringing_title' => 'required',
            'infringing_link' => 'required|url',
            'original' => 'required|url',
            'infringing_provider' => 'required',

        ];
       */
    }
}
