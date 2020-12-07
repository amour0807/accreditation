<?php

namespace Modules\BoardExam\Entities;

use Illuminate\Database\Eloquent\Model;

class BoardExam extends Model
{
    protected $guarded = [];
    protected $table = 'board_exam';

/*    public function topnatcher()
    {
        return $this->belongsTo('Modules\BoardExam\Entities\Topnatcher');
    }*/
}
