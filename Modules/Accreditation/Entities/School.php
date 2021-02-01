<?php

namespace Modules\Accreditation\Entities;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded = [];

    public function acadPrgrm()
    {
        return $this->hasMany('Modules\Accreditation\Entities\AcadPrgrm');
    }
    public function schoolAward()
    {
        return $this->hasMany('Modules\Award\Entities\SchoolAward');
    }
    public function alumni()
    {
        return $this->belongsTo('App\Alumni');
    }
}
