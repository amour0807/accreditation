<?php

namespace Modules\QuantitativeReport\Entities;

use Illuminate\Database\Eloquent\Model;

class ScholarDiscount extends Model
{
    protected $guarded = [];
     protected $table = 'scholar_discounts';
     public function scholarship()
    {
        return $this->belongsTo('Modules\QuantitativeReport\Entities\Scholarship');
    }
}
