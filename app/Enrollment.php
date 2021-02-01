<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollment';
     protected $fillable = [
        'school_id','acad_prog_id','semester', 'school_year', 'school', 'program', 'freshmen', 'transfery', 'old',
    ];
}
