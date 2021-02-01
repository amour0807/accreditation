<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = [];
     protected $table = 'partners';

    public function partner_classifications()
    {
<<<<<<< HEAD
        return $this->belongsToMany('Modules\Partner\Entities\PartnerClas', 'id');
=======
        return $this->hasMany('Modules\Partner\Entities\PartnerClas');
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
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
