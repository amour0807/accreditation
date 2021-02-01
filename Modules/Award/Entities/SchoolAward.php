<?php

namespace Modules\Award\Entities;

use Illuminate\Database\Eloquent\Model;

class SchoolAward extends Model
{
    protected $guarded = [];
    protected $table = 'school_awards';

    public function school()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\School');
    }
  }
