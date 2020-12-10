<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = [];
     protected $table = 'partners';

    public function partner_classifications()
    {
        return $this->hasMany('Modules\Partner\Entities\PartnerClas');
    }
    public function partner_renewal()
    {
        return $this->hasMany('Modules\Partner\Entities\PartnerRenew');
    }
    public function partner_nature()
    {
        return $this->hasMany('Modules\Partner\Entities\PartnerNature');
    }
}
