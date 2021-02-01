@extends('layouts.appAlumni')
@section('content')
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">December 2020 Graduating Students Information and Feedback Form</h5>
                
            </div>
            <div class="modal-body">  
       <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
           @csrf
       </form>   
       <div class="container">
        <small><span class="text-danger">*</span> Required Fields</small>
        <div class="stepwizard" id="stepwizard">
            <div class="setup-panel stepwizard-row">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle ">1</a>
                    <p>Introduction</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
                    <p>Contact Details</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button" id="2"class="btn btn-default btn-circle disabled" >3</a>
                    <p>School and <br>Academic Program</p>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-4" type="button" id="3" class="btn btn-default btn-circle disabled" >4</a>
                  <p>Graduating Student Feedback</p>
              </div>
              <div class="stepwizard-step">
                <a href="#step-5" type="button" id="4"class="btn btn-default btn-circle disabled" >5</a>
                <p></p>
            </div>
            </div>
        </div>
        <form name="myForm" id="myForm" class="form-horizontal" method="POST" action="{{route('addSurvey')}}" onsubmit="return validateForm()">
          {{ csrf_field() }}
            <div class="row setup-content" id="step-1"><br>
                <div class="col-xs-12">
                    <div class="col-md-12">
                          <div class="form-group row">
                              <div class="pricing">
                              <div class="title" style="background-color: gray;">
                                <i class="fa fa-graduation-cap"></i><h2>Congratulation on your upcoming graduation!</h2>
                              </div>
                                <div class="x_content">
  
                           <p>   The University of Baguio maintains an Alumni Database which contains the personal information including the contact details of all graduates. We use these data to disseminate information to the alumni, and for recruitment purposes (if permitted by the alumnus). </p>
                              
                         <p>    Since you will be part of the UB Alumni very soon, may we request you to fill out this form and entrust to us your contact details? Also, we would like to take this opportunity to get your feedback and suggestions. These will help us improve our services, and the delivery of the different academic programs that UB offers.</p>
                              
                          <p>    All feedback will be collated and will be furnished to concerned offices with the names of the respondents treated anonymously.</p>
                              
                            <p>    All data gathered will be processed in accordance with the Data Privacy Policy of the University of Baguio which is accessible at the UB website.  
                          </p>
                                    </div>
                          </div>
                          </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-2"><br>
                    <div class="col-md-12">
                        <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="current-address">Current Address<span class="text-danger">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="current-address" name="currentaddress" class="form-control" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="provincial-address">Provincial Address
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="provincialaddress" name="provincialaddress" class="form-control ">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="provincial-address">Cellphone Number<span class="text-danger">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <input type="number" name="cp" id="cp" class="form-control" required>
                          </div>
                        </div>
                          <div class="form-group row">
                              <label class="col-form-label col-md-3 col-sm-3 label-align" for="provincial-address">Landline Number
                              </label>
                          <div class="col-md-6 col-sm-6 ">
                              <input type="text" name="landline" class="form-control" data-inputmask="'mask' : '(999) 999-9999'">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="provincial-address">Facebook Account
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                            <input type="email" name="fb" class="form-control">
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="provincial-address">LinkedIn Account
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                              <input type="email" name="linkedin" class="form-control">
                          </div>
                        </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
            </div>
            <div class="row setup-content" id="step-3"><br>
                    <div class="col-md-12">
                      <div id="step-3"><br>
                        <div class="form-group row">
                          <label class="col-form-label col-md-2 col-sm-2 label-align" >
                          </label>
                          <div class="col-md-10 col-sm-10 ">
                              <label>Second academic program (If you are finishing another degree / non-degree program aside from the one above)?</label>
                            <textarea rows="2" name="q1" class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="form-group row" id="q12">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="provincial-address">Scholarship / Grant / Aid<span class="text-danger">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 ">
                                <p style="padding: 5px;">
                                    <input type="checkbox" name="q12[]" class="flats" value="None" id="none" onClick="ckChange(this)"/> None
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats" value="Academic Scholar"/> Academic Scholar
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats" value="Employee Dependent"/> Employee Dependent
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats" value="Science High School Graduate / UB High Top Graduate"/> Science High School Graduate / UB High Top Graduate
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats"value="Sibling Disount" /> Sibling Disount
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats" value="Director's Grantee"/> Director's Grantee
                                    <br />
                                    <input type="checkbox" name="q12[]"class="flats" value="Student Assistant"/> Student Assistant <br>
                                    <input type="checkbox" name="q12[]"class="flats" value="Marshall"/> Marshall
                                    <br />
                                    <input type="checkbox" name="q12[]"class="flats" value="University Choir / Dance Troupe / Band"/> University Choir / Dance Troupe / Band
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats" value="ESE Scholarship"/> ESE Scholarship
                                    <br />
                                    <input type="checkbox" name="q12[]" class="flats" value="Athletes"/> Athletes
                                    <br />
                                    <input type="checkbox" name="q12[]"  class="flats" value="Government Scholar"/> Government Scholar
                                    <br />
                                    <input type="checkbox" name="q12[]" value="Others" id="others" onclick="otheranswer()" name="q12[]" value="Others" style=" width:18px; height: 18px;"/> Others
                                    <br />
                                </p>
                                
                        
                        <div id="naturegrp" style="display: none;">
                                    <div class="row col-12">
                                      <div class="col-md-10">
                                        <input type="hidden" class="form-control" value="1" id="total_nature">
                                        <input type="text" class="form-control removeVal" id="txt" name="q12[]">
                                        <span id="spnErrorOthers" class="error text-danger" style="display: none;">*Required Input.</span>
                                        <div id="new_nature"></div>
                                      </div>
                                      <div class="col-md-2"><br>
                                        <a onclick="add()" class=" fa fa-plus-circle" style="font-size: 20px; color:red;"></a>
                                        <a onclick="remove()" class=" fa fa-minus-circle" style="font-size: 20px; color:gray;"></a>
                                      </div>
                                    </div>
                                  </div>
                                  <span id="spnError" class="error text-danger" style="display: none;">*Please select at-least one School.</span>
                          </div>
                        </div>
                  </div>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                    </div>
            </div>
            <div class="row setup-content" id="step-4"><br>
                  <div class="col-md-12">
                    <div id="step-4"><br>
                      <div class="form-horizontal form-label-left">
                          <div class="form-group row">
                            <label class="col-form-label col-md-2 col-sm-2 label-align" >
                            </label>
                            <div class="col-md-10 col-sm-10 ">
                                <label>What educational experience(s) did you like the most during your stay in UB?<span class="text-danger">*</span> </label>
                                  <textarea type="text" name="q2" class="form-control" rows="2"required></textarea>
                            </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-form-label col-md-2 col-sm-2 label-align" >
                              </label>
                              <div class="col-md-10 col-sm-10 ">
                                  <label>What are your suggestions to improve the SUPPORT provided by UB to the students? Support refers to scholarships / grants provided by UB and the services provided by CCSD, OSA, ARC, MIS, Medical / Dental Clinic, Student Accounts, Cashier, Security to students. </label>
                                <textarea name="q3" class="form-control" rows="4" ></textarea>
                              </div>
                            </div>
                          <div class="form-group row" >
                              <label class="col-form-label col-md-2 col-sm-2 label-align" >
                              </label>
                            <div class="col-md-6 col-sm-6" id="q4">
                              <label>Overall, the quality of my academic experience in my program is very good.<span class="text-danger">*</span> </label>
                                  <p style="padding: 5px;">
                                      <input type="radio" class="flats"  name="q4" value="Strongly Agree" /> Strongly Agree
                                      <br />
                                      <input type="radio" class="flats"  name="q4" value="Agree"> Agree
                                      <br />
                                      <input type="radio" class="flats" name="q4"  value="Disagree"/> Disagree
                                      <br />
                                      <input type="radio" class="flats" name="q4"  value="Strongly Disagree"/> Strongly Disagree
                                      <br />
                                  </p>
                            </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-form-label col-md-2 col-sm-2 label-align" >
                              </label>
                              <div class="col-md-10 col-sm-10 ">
                                  <label>What do you believe are the strengths of your academic program? Please cite STRENGTHS in the areas of faculty, instruction or teaching-learning, laboratories, curriculum, OJT, thesis / project / feasibility, ICT resources, etc.)<span class="text-danger">*</span> </label>
                                <textarea type="text" name="q5" class="form-control" row="2" required></textarea>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-form-label col-md-2 col-sm-2 label-align" >
                              </label>
                              <div class="col-md-10 col-sm-10 ">
                                  <label>What are your suggestions to improve the curriculum, and delivery of your academic program (teaching-learning, faculty, laboratories, OJT, thesis / project / feasibility, ICT resources, etc.)?<span class="text-danger">*</span> </label>
                                <textarea type="text" name="q6" class="form-control" row="2" required></textarea>
                              </div>
                          </div>
                        </div>
                    </div>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                  </div>
          </div>
          <div class="row setup-content" id="step-5"><br>
                <div class="col-md-12">
                  <div id="step-5"><br>
                    <div class="form-horizontal form-label-left">
                      
                      <div class="form-group row" id="q7">
                        <label class="col-form-label col-md-2 col-sm-2 label-align" >
                        </label>
                        <div class="col-md-10 col-sm-10 ">
                            <label>During your stay in UB, did you participate in any of the OUTREACH activities organized by your school, a student organization or the university? <span class="text-danger">*</span> </label>
                            <p style="padding: 5px;">
                                <input type="radio" class="flats"  name="q7" value="Yes"/> Yes
                                <br />
                                <input type="radio" class="flats"  name="q7" value="No"/> No
                                <br />
                            </p>
                        </div>
                    </div>
                        <div class="form-group row" id="q8">
                          <label class="col-form-label col-md-2 col-sm-2 label-align" >
                          </label>
                          <div class="col-md-10 col-sm-10 " id="yes" style="display: none;">
                              <label>Please share with us your realizations after participating in the outreach activities.<span class="text-danger">*</span> </label>
                                <textarea type="text" name="q8" class="form-control" row="2" required></textarea>
                          </div>
                        </div>
                        <div class="form-group row" id="q9">
                            <label class="col-form-label col-md-2 col-sm-2 label-align" >
                            </label>
                            <div class="col-md-10 col-sm-10 ">
                                <label>Would you recommend University of Baguio to your siblings, relatives, friends and acquaintances?<span class="text-danger">*</span>  </label>
                                <p style="padding: 5px;">
                                    <input type="radio" class="flats"  name="q9" value="Yes"/> Yes
                                    <br />
                                    <input type="radio" class="flats"  name="q9" value="No"/> No
                                    <br />
                                </p>
                            </div>
                          </div>
                          <div class="form-group row" id="q10">
                            <label class="col-form-label col-md-2 col-sm-2 label-align" >
                            </label>
                            <div class="col-md-10 col-sm-10 ">
                                <label>Would you allow us to share your contact details to companies for employment purposes? <span class="text-danger">*</span>  </label>
                                <p style="padding: 5px;">
                                    <input type="radio" class="flats"  name="q10" value="Yes"/> Yes
                                    <br />
                                    <input type="radio" class="flats"  name="q10" value="No"/> No
                                    <br />
                                </p>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-2 col-sm-2 label-align" >
                            </label>
                          <div class="col-md-10 col-sm-10 ">
                            <label>Which of the following should we use to disseminate to you university programs, activities, and other alumni-related information?</label>
                                <p style="padding: 5px;">
                                    <input type="checkbox" class="flats"  name="q11[]" value="Cellphone Number"/> Cellphone Number
                                    <br />
                                    <input type="checkbox" class="flats"  name="q11[]" value="Email"/> Email
                                    <br />
                                    <input type="checkbox" class="flats" name="q11[]"  value="Messenger"/> Messenger
                                    <br />
                                    <input type="checkbox" class="flats" name="q11[]" id="otherselected" onclick="otherinfo()" value="Others"/> Others
                                    <br />
                                    <input type="text" class="form-control" id="otherinfos" name="q11[]" style="display: none;">
                                </p>
                          </div>
                        </div>
                      </div>
                  </div>
                    <button class="btn btn-success btn-lg pull-right" type="button" id="submitForm">Finish!</button>
                </div>
        </div>
        </form>
        </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if(\Session::has('success'))
<script>
Swal.fire({
  title: 'Thank You for sharing your feedback!',
  text: "All feedback will be summarized and will be furnished to concerned offices with the names of the respondents treated anonymously.",
  icon: 'success',
  showCancelButton: false,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ok',
  allowOutsideClick: false,
}).then((result) => {
  if (result.isConfirmed) {
    document.getElementById('logout-form').submit();
  }
})
</script>
  @elseif(\Session::has('error'))
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: "<a>Back</a>"
  }) 
  </script>
  @endif
<script>
    $(document).ready(function(){
        $('#myModal').modal({backdrop: 'static', keyboard: false}) 
        $("#myModal").modal('show');

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            nextNum = $('a[href="#' + curStepBtn + '"]'),
            curInputs = curStep.find("input[type='text'],input[type='number'],textarea"),
            isValid = true;

        $(curInputs).removeClass("has-error");
        $('#q4').removeClass("has-error");
        $('#q12').removeClass("has-error");
        $('#q7').removeClass("has-error");
        $('#q10').removeClass("has-error");
        $('#q12').removeClass("has-error");

        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).addClass("has-error");
            }
         }
         if(curStepBtn == 'step-3'){
            if($('input[name="q12[]"]:checked').length <= 0){
              isValid = false;
              $('#q12').addClass("has-error");
          }
         }
         if (curStepBtn == 'step-4' ) {
          if($('input[name=q4]:checked').length <= 0){
            isValid = false;
            $('#q4').addClass("has-error");
          }
      }
      var result = curStepBtn.split('step-');
        if (isValid){
            nextStepWizard.removeAttr('disabled').trigger('click');
            $('#'+result[1]).removeClass('disabled').trigger('click');
        }else{
          $('#'+result[1]).addClass('disabled').trigger('click');
        }
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
    
    $('input[name="q7"]').click(function () {
        var yes = document.getElementById("yes");
        if ($(this).attr("value") == "Yes") {
          yes.style.display = "block";
        }
        if ($(this).attr("value") == "No") {
          yes.style.display = "none";

        }
    });
    });
    function otheranswer() {
      var checkBox = document.getElementById("others");
      // Get the output text
      var grp = document.getElementById("naturegrp");

      // If the checkbox is checked, display the output text
      if (checkBox.checked == true){
        grp.style.display = "block";
      } else {
        grp.style.display = "none";
      }
    }
    
    function otherinfo() {
      var checkBox = document.getElementById("otherselected");
      // Get the output text
      var grp = document.getElementById("otherinfos");

      // If the checkbox is checked, display the output text
      if (checkBox.checked == true){
        grp.style.display = "block";
      } else {
        grp.style.display = "none";
      }
    }
    function add(){
          var new_nature_no = parseInt($('#total_nature').val())+1;
          var new_nature="<input type='text' class='form-control' name='q12[]' id='nature_"+new_nature_no+"'>";
          
          $('#new_nature').append(new_nature);
          $('#total_nature').val(new_nature_no);
        }
    function remove(){
          var last_nature_no = $('#total_nature').val();
          if(last_nature_no>1){
            $('#nature_'+last_nature_no).remove();
            $('#total_nature').val(last_nature_no-1);
          }
    }
    function validateForm() { 
      var isValid = true;
      var a = document.forms["myForm"]["currentaddress"].value;
      var b = document.forms["myForm"]["cp"].value;
      var c = document.forms["myForm"]["q2"].value;
      var d = document.forms["myForm"]["q5"].value;
      var e = document.forms["myForm"]["q6"].value;
      var f = document.forms["myForm"]["q8"].value;

      if (a == "" && b == "" && c == "" && d == "" && e == "") {
        Swal.fire({
          icon: 'error',
          title: 'Incomplete Data...',
          text: 'Please Fill out all * required Fields!'
        }) 
        return false;
      }
      if($('input[name=q7]:checked').length <= 0 || $('input[name=q9]:checked').length <= 0 || $('input[name=q10]:checked').length <= 0){
        if($('input[name=q7]:checked').length <= 0)
            $('#q7').addClass("has-error");
        if($('input[name=q9]:checked').length <= 0)
            $('#q9').addClass("has-error");
        if($('input[name=q10]:checked').length <= 0)
            $('#q10').addClass("has-error");

              if ($('input[name="q7"]').attr("value") == "Yes") {
                if(f == "")
                  $('#q8').addClass("has-error");
                else
                $('#q8').removeClass("has-error");
              }
        return false;
        }
}
$("#submitForm").on('click',function(event){
        Swal.fire({
        title: 'Are you sure?',
        text: "You cannot edit your answer upon saving!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
         $("#myForm").submit();
        }else{
          event.preventDefault();
        }
      })
    });

    function ckChange(ckType){
    var ckName = document.getElementsByName(ckType.name);
    var checked = document.getElementById(ckType.id);

    if (checked.checked) {
      for(var i=0; i < ckName.length; i++){
        if(ckName[i].id != 'none'){
          
      ckName[i].checked = false;
        }
          if(!ckName[i].checked){
              ckName[i].disabled = true;
          }else{
              ckName[i].disabled = false;
          }
          
      } 
    }
    else {
      for(var i=0; i < ckName.length; i++){
        ckName[i].disabled = false;
      } 
    }    
    $('#none').removeAttr('disabled');
    
    var grp = document.getElementById("naturegrp");
    grp.style.display = "none";
    $('.removeVal').val('');
}
</script>
@endsection