<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    //検査するルール
    public function rules(): array
    {
        return [
            'title'=>'required',
            'content'=>'required',
        ];
    }

    //属性
    public function attributes(){
        return [
            'title'=>'タイトル',
            'content'=>'内容',
        ];
    }

    //エラーの場合のメッセージ
    public function messages(){
        return [
            'title.required'=>':attributeを入力してください',
            'content.required'=>':attributeを入力してくだい',
        ];
    }
}
