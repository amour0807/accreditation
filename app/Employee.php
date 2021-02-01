<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'hr_report';
     protected $fillable = [
        'semester', 'school_year', 'department', 'no_Tpermanent', 'no_Tprobationary', 'no_Tcontractual', 'no_Tpartime', 'no_NTprobationary', 'no_NTpermanent',
    ];

    public $timestamps = true;
}
