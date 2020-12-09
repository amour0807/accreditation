<?php

namespace Modules\Partner\Entities;

use Illuminate\Database\Eloquent\Model;

class PartnerClassification extends Model
{
    protected $guarded = [];
    protected $table = 'partner_classifications';

    public function partner()
    {
<<<<<<< HEAD
        return $this->belongsToMany('Modules\Partner\Entities\Partner','id');
=======
        return $this->belongsTo('Modules\Partner\Entities\Partner');
>>>>>>> eeeb735244370291262bd2262e98a6d4ad489a41
    }
}
