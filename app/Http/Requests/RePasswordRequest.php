<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RePasswordRequest extends FormRequest
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
    public function messages(){
        return [
            'required' => 'Kolom ini tidak boleh kosong!',
            'same' => 'Password tidak sama!'
        ];
    }

    public function rules()
    {
        return [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword'
        ];
    }
}
