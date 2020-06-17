<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            'user_id' => 'required',
            'tweet_id' => 'required',
            'reply' => 'required|max:280',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'Um usuário é necessário',
            'tweet_id.required' => 'Um tweet é necessário',
            'reply.required'  => 'Escreva algo',
            'reply.max'  => 'O reply pode ter no máximo 140 caracteres',
        ];
    }
}
