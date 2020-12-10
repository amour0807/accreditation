<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;

class PartnerNature extends Model
{
    protected $guarded = [];
    protected $table = 'partner_nature';

    public function partner()
    {
        return $this->belongsTo('Modules\Partner\Entities\Partner');
    }
}
