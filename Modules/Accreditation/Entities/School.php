<?php

namespace Modules\Accreditation\Entities;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $guarded = [];

    public function acadPrgrm()
    {
        return $this->hasMany('Modules\Accreditation\Entities\acadPrgrm');
    }
}
