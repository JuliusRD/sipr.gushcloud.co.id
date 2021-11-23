<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimbursementDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "reimbursement_detail";
    
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y h:i');
    }
}
