<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function workorder()
    {
        return $this->belongsTo(Workorder::class);
    }

    public function smelting()
    {
        return $this->belongsTo(Smelting::class);
    }

}
