<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function getRequestDateAttribute()
    // {
    //     return Carbon::parse($this->attributes['request_date'])->translatedFormat('d F Y');
    // }

    // public function getDueDateAttribute()
    // {
    //     return Carbon::parse($this->attributes['due_date'])->translatedFormat('d F Y');
    // }

    // public function getCreatedAtAttribute()
    // {
    //     return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y h:i');
    // }

    public function institusi()
    {
        return $this->belongsTo('App\Models\Institusi');
    }

    public function divisi()
    {
        return $this->belongsTo('App\Models\Divisi');
    }

    public function request()
    {
        return $this->belongsTo('App\Models\User', 'request_by', 'id');
    }

    public function ga()
    {
        return $this->belongsTo('App\Models\User', 'ga_id', 'id');
    }

    public function leader()
    {
        return $this->belongsTo('App\Models\User', 'leader_id', 'id');
    }

    public function finance()
    {
        return $this->belongsTo('App\Models\User', 'finance_id', 'id');
    }

    public function approval()
    {
        return $this->hasOne('App\Models\Approval');
    }

    public function history(){ 
        return $this->hasMany('App\Models\History'); 
    }
}
