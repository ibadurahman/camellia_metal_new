<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BypassWorkorder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workorder(){
        return $this->belongsTo(Workorder::class, 'workorder_id', 'id');
    }

    public function initiatedBy(){
        return $this->belongsTo(User::class, 'initiated_by', 'id');
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
}
