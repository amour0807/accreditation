<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //accreditation module
        $viewAccred = new Permission();
        $viewAccred->permission_name = 'Accreditation';
        $viewAccred->slug = 'view-accred';
        $viewAccred->save();

        $editAccred = new Permission();
        $editAccred->permission_name = 'Accreditation';
        $editAccred->slug = 'edit-accred';
        $editAccred->save();

        $deleteAccred = new Permission();
        $deleteAccred->permission_name = 'Accreditation';
        $deleteAccred->slug = 'delete-accred';
        $deleteAccred->save();

        $createAccred = new Permission();
        $createAccred->permission_name = 'Accreditation';
        $createAccred->slug = 'create-accred';
        $createAccred->save();

        //Student Module
        $viewStudent = new Permission();
        $viewStudent->permission_name = 'Students Award';
        $viewStudent->slug = 'view-student';
        $viewStudent->save();

        $editStudent = new Permission();
        $editStudent->permission_name = 'Students Award';
        $editStudent->slug = 'edit-student';
        $editStudent->save();

        $deleteStudent = new Permission();
        $deleteStudent->permission_name = 'Students Award';
        $deleteStudent->slug = 'delete-student';
        $deleteStudent->save();

        $createStudent = new Permission();
        $createStudent->permission_name = 'Students Award';
        $createStudent->slug = 'create-student';
        $createStudent->save();

        //Institutional Award
        $viewInsAward = new Permission();
        $viewInsAward->permission_name = 'Institutional Award';
        $viewInsAward->slug = 'view-instaward';
        $viewInsAward->save();

        $editInsAward = new Permission();
        $editInsAward->permission_name = 'Institutional Award';
        $editInsAward->slug = 'edit-instaward';
        $editInsAward->save();

        $deleteInstAward = new Permission();
        $deleteInstAward->permission_name = 'Institutional Award';
        $deleteInstAward->slug = 'delete-instaward';
        $deleteInstAward->save();

        $createInstAward = new Permission();
        $createInstAward->permission_name = 'Institutional Award';
        $createInstAward->slug = 'create-instaward';
        $createInstAward->save();

        //BoardExam
        $viewBoard = new Permission();
        $viewBoard->permission_name = 'Board Exam';
        $viewBoard->slug = 'view-board';
        $viewBoard->save();

        $editBoard = new Permission();
        $editBoard->permission_name = 'Board Exam';
        $editBoard->slug = 'edit-board';
        $editBoard->save();

        $deleteBoard = new Permission();
        $deleteBoard->permission_name = 'Board Exam';
        $deleteBoard->slug = 'delete-board';
        $deleteBoard->save();

        $createBoard = new Permission();
        $createBoard->permission_name = 'Board Exam';
        $createBoard->slug = 'create-board';
        $createBoard->save();

        //Partnership
        $viewPartner = new Permission();
        $viewPartner->permission_name = 'Partnership';
        $viewPartner->slug = 'view-partner';
        $viewPartner->save();

        $editPartner = new Permission();
        $editPartner->permission_name = 'Partnership';
        $editPartner->slug = 'edit-partner';
        $editPartner->save();

        $deletePartner = new Permission();
        $deletePartner->permission_name = 'Partnership';
        $deletePartner->slug = 'delete-partner';
        $deletePartner->save();

        $createPartner = new Permission();
        $createPartner->permission_name = 'Partnership';
        $createPartner->slug = 'create-partner';
        $createPartner->save();

        //Schools
        $viewSchool = new Permission();
        $viewSchool->permission_name = 'School / Departments / Offices';
        $viewSchool->slug = 'view-school';
        $viewSchool->save();

        $editSchool = new Permission();
        $editSchool->permission_name = 'School / Departments / Offices';
        $editSchool->slug = 'edit-school';
        $editSchool->save();

        $deleteSchool = new Permission();
        $deleteSchool->permission_name = 'School / Departments / Offices';
        $deleteSchool->slug = 'delete-school';
        $deleteSchool->save();

        $createSchool = new Permission();
        $createSchool->permission_name = 'School / Departments / Offices';
        $createSchool->slug = 'create-school';
        $createSchool->save();

        //School Award
        $viewSchoolAward = new Permission();
        $viewSchoolAward->permission_name = 'School Award';
        $viewSchoolAward->slug = 'view-schoolAward';
        $viewSchoolAward->save();

        $editSchoolAward = new Permission();
        $editSchoolAward->permission_name = 'School Award';
        $editSchoolAward->slug = 'edit-schoolAward';
        $editSchoolAward->save();

        $deleteSchoolAward = new Permission();
        $deleteSchoolAward->permission_name = 'School Award';
        $deleteSchoolAward->slug = 'delete-schoolAward';
        $deleteSchoolAward->save();

        $createSchoolAward = new Permission();
        $createSchoolAward->permission_name = 'School Award';
        $createSchoolAward->slug = 'create-schoolAward';
        $createSchoolAward->save();

        //User 
        $createUser = new Permission();
        $createUser->permission_name = 'User Account';
        $createUser->slug = 'view-user';
        $createUser->save();

        $editUser = new Permission();
        $editUser->permission_name = 'User Account';
        $editUser->slug = 'edit-user';
        $editUser->save();

        $deleteUser = new Permission();
        $deleteUser->permission_name = 'User Account';
        $deleteUser->slug = 'delete-user';
        $deleteUser->save();

        $createUser = new Permission();
        $createUser->permission_name = 'User Account';
        $createUser->slug = 'create-user';
        $createUser->save();
    }
}
