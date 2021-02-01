<?php

namespace Modules\AlumniDatabase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Alumni;
use Modules\Accreditation\Entities\AcadPrgrm;
use Modules\Accreditation\Entities\School;
use Modules\AlumniDatabase\Entities\Survey;
use Illuminate\Support\Facades\{Hash};
use Yajra\Datatables\Datatables;
use DB;

class SurveyController extends Controller
{
    public function addSurvey(Request $request)
    {   
        $q12 = $request->q12;
        $valq12 = implode(", ",$q12);
      
        $q11 = $request->q11;
        $valq11 = implode(", ",$q11);
        
        $graduateID = auth()->guard('alumni')->user()->id;
        
        $graduate = Alumni::find($graduateID);
        $graduate->current_address = $request->currentaddress;
        $graduate->present_address = $request->provincialaddress;
        $graduate->cell_num = $request->cp;
        $graduate->landline = $request->landline;
        $graduate->facebook = $request->fb;
        $graduate->linkedin = $request->linkedin;
        $graduate->remarks = 'Done';
        $graduate->save();

        $userID = $graduate->id;
        $questions = array( "q1" => $request->q1,
                "q2" => $request->q2,
                "q3" => $request->q3,
                "q4" => $request->q4,
                "q5" => $request->q5,
                "q6" => $request->q6,
                "q7" => $request->q7,
                "q8" => $request->q8,
                "q9" => $request->q9,
                "q10" => $request->q10,
                "q11" => $valq11,
                "q12" => $valq12,

            );

        foreach($questions as $qnumber => $qanswer){
            $str = ltrim($qnumber, 'q');
            if($qanswer != ""){
                $survey = new Survey;
                $survey->alumni_id = $graduateID;
                $survey->question_id = $str;
                $survey->answer = $qanswer;
                $survey->save();
            }
        }
    
        if (!$graduate->save()) {
            return back()->with('error', '');
        } else {
            return back()->with('success', '');
        }
    }
}
