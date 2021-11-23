<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryReimbursement extends Model
{
    use HasFactory;
    protected $table = "histories_reimbursement";
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function reimbursement(){
        return $this->belongsTo('App\Models\Reimbursement');
    }
}
