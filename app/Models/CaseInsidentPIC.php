<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInsidentPIC extends Model
{
    use HasFactory;

    protected $table = 'case_insident_pics';
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseInsident::class, 'case_id');
    }
}
