<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class CaseInsidentLevel extends Model
{
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseInsident::class, 'case_id');
    }

    public function level()
    {
        return $this->belongsTo(InsidentLevel::class, 'level_id');
    }

    // public function getCreatedAtAttribute(){
    //     return Carbon::parse($this->attributes['created_at'])->translatedFormat('l, d F Y');
    // }
}
