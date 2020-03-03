<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerusahaanRequest extends FormRequest
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
            'numeric' => 'Format harus numeric',
            'email' => 'Format harus berupa email : @mail.com'
        ];
    }
    
    public function rules()
    {
        return [
            'nama' => 'required|min:6',
            'alamat' => 'required',
            'telp' => 'required|numeric|min:6',
            'fax' => 'required|numeric',
            'email' => 'required|email',
            'pic' => 'required',
            'logo' => 'required|mimes:jpeg,jpg,png|max:2048',
            'cap' => 'required|mimes:jpeg,jpg,png|max:2048'
        ];
    }
}
