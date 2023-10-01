<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DowntimeReason extends Model
{
    use HasFactory;

    protected $guarder = [];

    public function downtimeCategory()
    {
        return $this->belongsTo(DowntimeCategory::class, 'dt_category_id', 'id');
    }
}
