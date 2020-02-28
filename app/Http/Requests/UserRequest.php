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
            'mimes' => 'Masukkan tipe file dengan benar!',
            'unique' => 'Username sudah terpakai, coba yang lain.'
        ];
    }
    
    public function rules()
    {
        $id = '';
        if(!empty($this->input('id'))){
            $id = ','.$this->input('id');
        }
        return [
            'nama' => 'required|min:6',
            'username' => 'required|min:6|unique:user,username'.$id,
            'ttd' => 'mimes:jpeg,jpg,png|max:2048',
            'level' => 'required|numeric'
        ];
    }
}
