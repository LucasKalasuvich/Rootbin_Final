<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class CaseInsident extends Model
{
    protected $guarded = [];
    protected $table = 'case_insidents';
    protected $with = [
        'units',
        'staffs',
        'insident_levels.level',
        'insident_statuses.status',
        'insident_implementations.implementation',
        'insident_implementations_file.implementation',
        'insident_pic',
        'insident_corrective_actions'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'case_id');
    }

    public function units()
    {
        return $this->hasMany(CaseRelatedUnit::class, 'case_id');
    }

    public function staffs()
    {
        return $this->hasMany(CaseRelatedStaff::class, 'case_id');
    }

    public function insident_levels()
    {
        return $this->hasMany(CaseInsidentLevel::class, 'case_id');
    }

    public function insident_statuses()
    {
        return $this->hasMany(CaseInsidentStatus::class, 'case_id');
    }

    public function insident_implementations()
    {
        return $this->hasMany(CaseInsidentImplementation::class, 'case_id');
    }

    public function insident_implementations_file()
    {
        return $this->hasMany(CaseInsidentImplementation::class, 'case_id');
    }

    public function insident_pic()
    {
        return $this->hasOne(CaseInsidentPIC::class, 'case_id');
    }

    public function insident_corrective_actions()
    {
        return $this->hasMany(CaseInsidentCorrectiveAction::class, 'case_id');
    }
}
