<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $table = 'awards';
     protected $fillable = [
        'last_name', 'first_name', 'acad_prgram_id', 'scope', 'category', 'classification', 'award', 'title_competitions', 'award_giving_body', 'date_awarded', 'venue',
    ];

    public $timestamps = true;
}
