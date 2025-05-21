<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'img_url' => ['mimes:jpeg,png,jpg', 'required'],
        ];
     }
        public function messages() 
        {
            return [
                'img_url.required' => '画像を入れてください',
                'img_url.mimes' =>'拡張子が.jpegもしくは.pngの画像を選択してください',
            ];
        }
   
}
