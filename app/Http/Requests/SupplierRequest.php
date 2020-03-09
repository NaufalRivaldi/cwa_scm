<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'email' => 'Format harus berupa email : @mail.com',
            'unique' => 'Kode sudah dipakai pada supplier lain.'
        ];
    }
    
    public function rules()
    {
        $id = '';
        if(!empty($this->input('id'))){
            $id = ','.$this->input('id');
        }

        return [
            'kode' => 'required|unique:supplier,kode'.$id,
            'nama' => 'required',
            'tax' => 'required',
            'alamat' => 'required',
            'wilayahId' => 'required',
            'telp' => 'required|numeric',
            'fax' => 'required',
            'email' => 'required|email',
            'kredit' => 'required',
            'pic' => 'required'
        ];
    }
}
