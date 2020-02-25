<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'min' => 'Minimal 6 karakter',
            'mimes' => 'Masukkan tipe file dengan benar!'
        ];
    }
    
    public function rules()
    {
        return [
            'nama' => 'required|min:6',
            'username' => 'required|min:6',
            'ttd' => 'required|mimes:jpeg,jpg,png|max:2048',
            'level' => 'required|numeric'
        ];
    }
}
