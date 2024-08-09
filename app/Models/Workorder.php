<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Workorder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = true;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function smeltings()
    {
        return $this->hasMany(Smelting::class);
    }

    public function oees()
    {
        return $this->hasMany(Oee::class);
    }

    public function realtimes()
    {
        return $this->hasMany(Realtime::class);
    }

    public function colorData()
    {
        return $this->belongsTo(Color::class, 'color', 'id');
    }

    public function dailyReport()
    {
        return $this->belongsTo(dailyReport::class);
    }

    public function processedBy(){
        return $this->belongsTo(User::class,'processed_by','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    
    public function editedBy(){
        return $this->belongsTo(User::class,'edited_by','id');
    }

    public function changeRequests()
    {
        return $this->hasMany(ChangeRequest::class,'workorder_id','id');
    }

    public function workorderHasTpm(){
        return $this->hasOne(WorkorderHasTpm::class);
    }
}
