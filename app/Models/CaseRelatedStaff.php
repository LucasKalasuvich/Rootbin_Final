<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class CaseRelatedStaff extends Model
{
    protected $guarded = [];

    protected $table = 'case_related_staff';

    public function case()
    {
        return $this->belongsTo(CaseInsident::class, 'case_id');
    }

    // public function getCreatedAtAttribute(){
    //     return Carbon::parse($this->attributes['created_at'])->translatedFormat('l, d F Y');
    // }
}
