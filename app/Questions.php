<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $connection ='mysql2';
    protected $guard = 'alumni';
    protected $table = 'questions';
}
