<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
    public function hasRolePermission($permissionID, $roleID)
    {
        $permissions =DB::table('roles_permissions')->where('role_id',$roleID)->where('permission_id',$permissionID)->get();
        if(count($permissions) > 0){
            return true;
        }
        return false;
    }
}
