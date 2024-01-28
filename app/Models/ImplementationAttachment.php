<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class ImplementationAttachment extends Model
{
    protected $guarded = [];

    public function insident_implementations()
    {
        return $this->hasMany(CaseInsidentImplementation::class, 'implementation_id');
    }

    // public function getCreatedAtAttribute(){
    //     return Carbon::parse($this->attributes['created_at'])->translatedFormat('l, d F Y');
    // }
}
