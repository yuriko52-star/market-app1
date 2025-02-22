<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
    public function prepareForValidation()
    {
        $this->merge([
            'price' =>preg_replace('/[^0-9]/', '', $this->price),
        ]);
    }

    public function rules()
    {
        return [
            'name' =>'required',
            'description' => 'required | max:255',
            'img_url' => 'required | mimes:jpeg,png,jpg',
            'category_ids' => 'required',
            'condition_id' => 'required',
            'price' => 'required | numeric | min:0',

        ];
    }
        public function messages()
         {
            return [
            'name.required' =>'商品名を入力してください',
            'description.required' =>'商品説明を入力してください',
            'description.max' => '商品説明は255文字以下で入力してください',
            'img_url.required' =>'商品画像のアップロードをしてください',
            'img_url.mimes' =>'拡張子が.jpegもしくは.pngの画像を選択してください',
            'category_ids.required' =>'商品のカテゴリーを選択してください',
            'condition_id.required' =>'商品の状態を選択してください',
            'price.required' => '商品の価格を入力してください',
            'price.numeric' => '数値型で入力してください',
            'price.min' => '0円以上で入力してください',
            ];
        }
    }

