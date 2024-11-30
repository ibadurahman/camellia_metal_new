<?php

namespace App\Http\Resources\ApiWorkorder;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkorderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'workorder_id'      => $this->id,
            'wo_number'         => $this->wo_number,
            'supplier'          => $this->bb_supplier,
            'grade'             => $this->bb_grade,
            'diameter'          => $this->bb_diameter,
            'qty'               => $this->bb_qty_pcs,
            'coil_qty'          => $this->bb_qty_coil,
            'bundle_qty'        => $this->bb_qty_bundle,
            'customer'          => $this->fg_customer,
            'straightness_std'  => $this->straightness_standard,
            'fg_diameter'       => $this->fg_size_1,
            'fg_length'         => $this->fg_size_2,
            'tolerance'         => $this->tolerance_plus.",".$this->tolerance_minus,
            'length_tolerance'  => $this->length_tolerance_plus.",".$this->length_tolerance_minus,
            'reduction_rate'    => $this->fg_reduction_rate,
            'shape'             => $this->fg_shape,
            'fg_weight'         => $this->fg_qty_kg,
            'fg_qty'            => $this->fg_qty_pcs,
            'wo_status'         => $this->status_wo,
            'processed_by'      => $this->processedBy?->name,
            'process_start'     => $this->process_start,
            'process_end'       => $this->process_end,
            'chamfer'           => $this->chamfer,
            'color'             => $this->colorData?->name,
            'machine'           => $this->machine?->name,
            'created_by'        => $this->createdBy?->name,
            'created_at'        => $this->created_at,
            'edited_by'         => $this->editedBy?->name,
            'edited_at'         => $this->updated_at,
            'remarks'           => $this->remarks,
        ];
    }
}
