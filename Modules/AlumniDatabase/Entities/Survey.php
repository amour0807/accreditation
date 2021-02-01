<?php

namespace Modules\AlumniDatabase\Entities;
use App\Alumni;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];
    protected $connection ='mysql2';
    protected $table = 'answers';
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
    ];
    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }
    
}
