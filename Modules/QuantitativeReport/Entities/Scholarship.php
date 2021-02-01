<?php


namespace Modules\QuantitativeReport\Entities;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $table = 'scholars';
     protected $fillable = [
        'name', 'category', 'company',
    ];

    public $timestamps = true;
    public function scholarshipDiscount()
    {
        return $this->hasMany('Modules\QuantitativeReport\Entities\ScholarDiscount');
    }
}
