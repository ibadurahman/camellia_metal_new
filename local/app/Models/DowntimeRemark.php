<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DowntimeRemark extends Model
{
    use HasFactory;

    protected $fillable = [
        'downtime_id',
        'downtime_category',
        'downtime_reason',
        'remarks'
    ];

    public function Downtime()
    {
        return $this->belongsTo(Downtime::class);
    }
}
