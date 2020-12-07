<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;

class PartnerClassification extends Model
{
    protected $guarded = [];
    protected $table = 'partner_classifications';

    public function partner()
    {
        return $this->belongsTo('Modules\Partner\Entities\Partner');
    }
}
