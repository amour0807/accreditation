<?php

namespace App;  

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Modules\AlumniDatabase\Entities\Survey;

class Alumni extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $connection ='mysql2';
    protected $guard = 'alumni';
    protected $table = 'users';


    protected $fillable = [
        'id_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'user_role',
        'school_id',
        'program_id',
        'current_address',
        'present_address',
        'cell_num',
        'landline',
        'facebook',
        'linkedin',
        'major',
        'semester',
        'school_year',
        'password',
        'remarks',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function answer()
    {
        return $this->hasMany(Survey::class);
    }
    public function acad_prog()
    {
        return $this->hasOne(AcadPrgrm::class);
    }
    public function school()
    {
        return $this->hasOne(School::class);
    }
    
}
