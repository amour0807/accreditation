<?php

namespace Modules\Accreditation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Questions;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q1 = new Questions();
        $q1->question = 'Second academic program (If you are finishing another degree / non-degree program aside from the one above)?';
        $q1->status = 'Active';
        $q1->save();

        $q2 = new Questions();
        $q2->question = 'What educational experience(s) did you like the most during your stay in UB?';
        $q2->status = 'Active';
        $q2->save();

        $q3 = new Questions();
        $q3->question = 'What are your suggestions to improve the SUPPORT provided by UB to the students? Support refers to scholarships / grants provided by UB and the services provided by CCSD, OSA, ARC, MIS, Medical / Dental Clinic, Student Accounts, Cashier, Security to students.';
        $q3->status = 'Active';
        $q3->save();

        $q4 = new Questions();
        $q4->question = 'Overall, the quality of my academic experience in my program is very good.';
        $q4->status = 'Active';
        $q4->save();

        $q5 = new Questions();
        $q5->question = 'What do you believe are the strengths of your academic program? Please cite STRENGTHS in the areas of faculty, instruction or teaching-learning, laboratories, curriculum, OJT, thesis / project / feasibility, ICT resources, etc.).';
        $q5->status = 'Active';
        $q5->save();

        $q6 = new Questions();
        $q6->question = 'What are your suggestions to improve the curriculum, and delivery of your academic program (teaching-learning, faculty, laboratories, OJT, thesis / project / feasibility, ICT resources, etc.)?';
        $q6->status = 'Active';
        $q6->save();

        $q7 = new Questions();
        $q7->question = 'During your stay in UB, did you participate in any of the OUTREACH activities organized by your school, a student organization or the university? ';
        $q7->status = 'Active';
        $q7->save();

        $q8 = new Questions();
        $q8->question = 'Please share with us your realizations after participating in the outreach activities.';
        $q8->status = 'Active';
        $q8->save();

        $q9 = new Questions();
        $q9->question = 'Would you recommend University of Baguio to your siblings, relatives, friends and acquaintances?';
        $q9->status = 'Active';
        $q9->save();

        $q10 = new Questions();
        $q10->question = 'Would you allow us to share your contact details to companies for employment purposes?';
        $q10->status = 'Active';
        $q10->save();

        $q11 = new Questions();
        $q11->question = 'Which of the following should we use to disseminate to you university programs, activities, and other alumni-related information?';
        $q11->status = 'Active';
        $q11->save();

        $q12 = new Questions();
        $q12->question = 'Scholarship / Grant / Aid';
        $q12->status = 'Active';
        $q12->save();
    }
}
