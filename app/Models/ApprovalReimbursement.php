<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalReimbursement extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = "approval_reimbursement";

    public function reimbursement()
    {
    	return $this->belongsTo('App\Models\Reimbursement');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y h:i');
    }

}
