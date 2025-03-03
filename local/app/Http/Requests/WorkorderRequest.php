<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WorkorderRequest extends FormRequest
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
        $rule_wo_unique = Rule::unique('workorders','wo_number');
        if($this->method() != 'POST'){
            $rule_wo_unique->ignore($this->request->get('workorder_id'));
        }

        return [
            //
            'wo_number'             =>['required',$rule_wo_unique],
            'bb_supplier'           =>['required'],
            'bb_grade'              =>['required'],
            'bb_diameter'           =>['required','numeric'],
            'bb_qty_pcs'            =>['required','numeric'],
            'bb_qty_coil'           =>['required','numeric'],
            'bb_qty_bundle'         =>['required','numeric'],
            'fg_customer'           =>['required'],
            'straightness_standard' =>['required'],
            'fg_size_1'             =>['required','numeric'],
            'fg_size_2'             =>['required','numeric'],
            'tolerance_minus'       =>['required','numeric'],
            'tolerance_plus'       =>['required','numeric'],
            'length_tolerance_minus' =>['required'],
            'length_tolerance_plus' =>['required'],
            'fg_reduction_rate'     =>['required','numeric'],
            'fg_shape'              =>['required'],
            'fg_qty_kg'             =>['required','numeric'],
            'fg_qty_pcs'            =>['required','numeric'], 
            'color'                 =>['required','numeric'],
            'machine_id'            =>['required'],
            'label_remarks'         =>['max: 20']
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Kolom :attribute harus diisi.',
            'numeric'   => 'Isian harus berupa angka.'
        ];
    }
}
