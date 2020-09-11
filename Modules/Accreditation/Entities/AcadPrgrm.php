<?php

namespace Modules\Accreditation\Entities;

use Illuminate\Database\Eloquent\Model;

class AcadPrgrm extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\School');
    }
    public function prgrmAccred()
    {
        return $this->hasMany('Modules\Accreditation\Entities\PrgrmAccred');
    }
}
