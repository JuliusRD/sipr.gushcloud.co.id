<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){ 
        return $this->hasMany('App\Models\User'); 
    }

    public function institusi(){
        return $this->belongsTo('App\Models\Institusi');
    }

    public function purchase(){ 
        return $this->hasMany('App\Models\Purchase'); 
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y h:i');
    }
}
