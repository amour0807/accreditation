<?php

namespace Modules\Accreditation\Entities;

use Illuminate\Database\Eloquent\Model;

class PrgrmAccred extends Model
{
    protected $guarded = [];

    public function acadPrgrm()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\AcadPrgrm');
    }
    public function accredStat()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\AccredStat');
    }
}
