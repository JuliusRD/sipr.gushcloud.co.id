<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{

    use HasFactory;
    protected $guarded = [];
    protected $table = "reimbursement";

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

    public function leader()
    {
        return $this->belongsTo('App\Models\User', 'leader_id', 'id');
    }

    public function approval()
    {
        return $this->hasOne('App\Models\ApprovalReimbursement');
    }

    public function history(){ 
        return $this->hasMany('App\Models\HistoryReimbursement'); 
    }
}
