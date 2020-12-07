<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;

class PartnerRenewal extends Model
{
    protected $guarded = [];
    protected $table = 'partner_renewal';

    public function partner()
    {
        return $this->belongsTo('Modules\Partner\Entities\Partner');
    }
}
