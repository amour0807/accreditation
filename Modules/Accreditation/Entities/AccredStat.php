<?php

namespace Modules\Accreditation\Entities;

use Illuminate\Database\Eloquent\Model;

class AccredStat extends Model
{
    protected $guarded = [];

    public function prgrmAccred()
    {
        return $this->hasMany('Modules\Accreditation\Entities\PrgrmAccred');
    }
}
