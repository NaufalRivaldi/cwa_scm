<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CabangRequest extends FormRequest
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
            'numeric' => 'Kolom ini harus diisi dengan nomer'
        ];
    }
    
    public function rules()
    {
        return [
            'nama' => 'required|min:6',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'pic' => 'required'
        ];
    }
}
