<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionRequest extends FormRequest
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
            //
            'workorder_id'      =>['required'],
            'bundle_num'        =>['required','integer'],
            'coil_num'          =>['required','integer'],
            'dies_num'          =>['required'],
            'diameter_ujung'    =>['required'],
            'diameter_tengah'   =>['required'],
            'diameter_ekor'     =>['required'],
            'kelurusan_aktual'  =>['required'],
            'panjang_aktual'    =>['required'],
            'berat_fg'          =>['required'],
            'pcs_per_bundle'    =>['required'],
            'bundle_judgement'  =>['required'],
        ];
    }

    public function messages(){
        return [
            'required'  => 'Kolom :attribute harus diisi.'
        ];
    }
}
