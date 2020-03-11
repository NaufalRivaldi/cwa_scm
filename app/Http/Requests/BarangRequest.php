<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
            'min' => 'Minimal 4 karakter',
            'unique' => 'Kode barang sudah terpakai, coba yang lain.',
            'numeric' => 'Harus bertipe numeric.'
        ];
    }
    
    public function rules()
    {
        $id = '';
        if(!empty($this->input('id'))){
            $id = ','.$this->input('id');
        }

        return [
            'merkId' => 'required',
            'kodeBarang' => 'required|min:4|unique:barang,kodeBarang'.$id,
            'nama' => 'required',
            'base' => 'required',
            'berat' => 'required|numeric',
            'supplierId' => 'required|array',
            'supplierId.*' => 'required',
            'harga' => 'required|array',
            'harga.*' => 'required',
            'diskon' => 'required|array',
            'diskon.*' => 'required'
        ];
    }
}
