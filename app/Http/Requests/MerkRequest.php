<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerkRequest extends FormRequest
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
            'unique' => 'Kode merk sudah terpakai, coba yang lain.'
        ];
    }
    
    public function rules()
    {
        $id = '';
        if(!empty($this->input('id'))){
            $id = ','.$this->input('id');
        }

        return [
            'kodeMerk' => 'required|unique:merk,kodeMerk'.$id,
            'nama' => 'required|min:6'
        ];
    }
}
