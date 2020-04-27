<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PoRequest extends FormRequest
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
            'date' => 'Harus berformat tanggal!',
            'numeric' => 'Harus berformat numeric!'
        ];
    }
    
    public function rules()
    {
        return [
            'supplierId' => 'required',
            'nomer' => 'required',
            'tglPO' => 'required|date',
            'kredit' => 'required|numeric',
            'metodePembayaran' => 'required',
            'jml' => 'required',
            'cabangId' => 'required',
        ];
    }
}
