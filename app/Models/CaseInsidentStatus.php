<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class CaseInsidentStatus extends Model
{
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseInsident::class, 'case_id');
    }

    public function status()
    {
        return $this->belongsTo(CaseStatus::class, 'status_id');
    }

    // public function getCreatedAtAttribute(){
    //     return Carbon::parse($this->attributes['created_at'])->translatedFormat('l, d F Y');
    // }
}
