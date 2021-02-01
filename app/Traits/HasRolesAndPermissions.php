<?php
namespace App\Traits;

use App\Role;
use App\Permission;
trait HasRolesAndPermissions
{
   /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }
    /**
     * @param mixed ...$roles
     * @return bool
     * In this function, we are passing $roles array and running a for each loop on each role to check if the current user’s roles contain the given role.
     */
    public function hasRole(... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }
    public function hasPermission(... $permissions ) {
        foreach ($permissions as $permission) {
            if ($this->permissions->contains('slug', $permission)) {
                return true;
            }
        }
        return false;
    }
            /**
         * @param $permission
         * @return bool
         */          
        // protected function hasPermission($permission)
        // {
        //     return (bool) $this->permissions->where('slug', $permission->slug)->count();
        // }
        protected function hasRolePermission($permission)
        {
            return (bool) $this->permissions->where('slug', $permission->slug)->count();
        }
        /**
         * @param $permission
         * @return bool
         * The below method will check if the user’s permissions contain the given permission, if yes then it will return true otherwise false.
         * Now, we have one method which will check if a user has the permissions directly or through a role. We will use this method to add a custom blade directive later in this post.
         */
        protected function hasPermissionTo($permission)
        {
            return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
        }

        /**
         * @param $permission
         * @return bool
         * This function checks if the permission’s role is attached to the user or not. Now the hasPermissionTo() the method will check between these two conditions.
         */
        public function hasPermissionThroughRole($permission)
        {
            foreach ($permission->roles as $role){
                if($this->roles->contains($role)) {
                    return true;
                }else{
                    
            return false;
                }
            }
        }
        //Now let’s say we want to attach some permissions to the current user.
        protected function getAllPermissions(array $permissions)
        {
            return Permission::whereIn('slug',$permissions)->get();
        }

        /**
         * @param mixed ...$permissions
         * @return $this
         * The first method is to get all permissions based on an array passed. In the second function, we pass permissions as an array and get all permissions from the database based on the array.
         * Next, we use the permissions() method to call the saveMany() method to save the permissions for the current user.
         */
        public function givePermissionsTo(... $permissions)
        {
            $permissions = $this->getAllPermissions($permissions);
            if($permissions === null) {
                return $this;
            }
            $this->permissions()->saveMany($permissions);
            return $this;
        }
        
        /**
         * @param mixed ...$permissions
         * @return $this
         * To delete permissions for a user, we pass permissions to our deletePermissions() method and remove all attached permissions using the detach() method.
         */
        public function deletePermissions(... $permissions )
        {
            $permissions = $this->getAllPermissions($permissions);
            $this->permissions()->detach($permissions);
            return $this;
        }

        /**
         * @param mixed ...$permissions
         * @return HasRolesAndPermissions
         * The second method actually removes all permissions for a user and then reassign the permissions provided for a user.
         */
        public function refreshPermissions(... $permissions )
        {
            $this->permissions()->detach();
            return $this->givePermissionsTo($permissions);
        }
}