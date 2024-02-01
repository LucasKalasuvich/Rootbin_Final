<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;


class CaseInsidentImplementation extends Model
{
    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseInsident::class, 'case_id');
    }

    public function implementation()
    {
        return $this->belongsTo(ImplementationAttachment::class, 'implementation_id');
    }

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Storage::url($value),
        );
    }
}
