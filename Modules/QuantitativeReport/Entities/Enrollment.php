<?php

namespace Modules\QuantitativeReport\Entities;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $guarded = [];
    
    protected $table = 'enrollment';
    public function acadPrgrm()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\AcadPrgrm');
    }
}
