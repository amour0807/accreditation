<?php

namespace Modules\QuantitativeReport\Entities;

use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    protected $guarded = [];
    
    protected $table = 'graduate';
    public function acadPrgrm()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\AcadPrgrm');
    }
}
