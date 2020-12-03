<?php

namespace Modules\Award\Entities;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $guarded = [];
    
    public function acadPrgrm()
    {
        return $this->belongsTo('Modules\Accreditation\Entities\AcadPrgrm');
    }

  }
