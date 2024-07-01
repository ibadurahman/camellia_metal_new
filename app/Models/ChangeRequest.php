<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workorder()
    {
        return $this->belongsTo(Workorder::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class,'changed_by');
    }
}
