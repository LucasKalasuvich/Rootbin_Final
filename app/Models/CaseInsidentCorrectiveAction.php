<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseInsidentCorrectiveAction extends Model
{
    use HasFactory;
    protected $table = 'case_insident_corrective_actions';
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseInsident::class, 'case_id');
    }

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Storage::url($value),
        );
    }
}
