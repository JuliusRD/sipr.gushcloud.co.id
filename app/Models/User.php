<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'institusi_id',
        'divisi_id',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y h:i');
    }

    public function leader()
    {
        return $this->belongsTo('App\Models\User', 'leader_id');
    }

    public function employee()
    {
        return $this->hasMany('App\Models\User', 'leader_id');
    }

    public function institusi(){
        return $this->belongsTo('App\Models\Institusi');
    }

    public function divisi(){
        return $this->belongsTo('App\Models\Divisi');
    }

    public function purchase(){ 
        return $this->hasMany('App\Models\Purchase'); 
    }

    public function history(){ 
        return $this->hasMany('App\Models\History'); 
    }
}
