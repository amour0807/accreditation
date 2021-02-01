<?php

namespace Modules\Accreditation\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Alumni;

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
    public function award()
    {
        return $this->hasMany('Modules\Award\Entities\Award');
    }
    public function enrollment()
    {
        return $this->hasMany('Modules\QuantitativeReport\Entities\Enrollment');
    }
}
