<script type="text/javascript">
    function add(){
          var new_nature_no = parseInt($('#total_nature').val())+1;
          var new_nature="<input type='text' class='form-control' name='nature[]' id='nature_"+new_nature_no+"'>";
          
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
$("#clasValidate button").click(function(event){
          //VALIDATE DATE
        var startDate = Date.parse($('#fromVal').val());
        var endDate = Date.parse($('#toVal').val());
        
        if (endDate < startDate || endDate == startDate){
        $("#spnErrorDate")[0].style.display = "block";
          event.preventDefault(); 
        }else{
        $("#spnErrorDate")[0].style.display = "none"; }

      var clasn = document.getElementById('classification');
    if ($('#list2').children().length == 0 && clasn.value == "School") {
      $("#spnErrorSchool")[0].style.display = "block";
        event.preventDefault(); 
      }else
      $("#spnErrorSchool")[0].style.display = "none";
      if ($('#lbpselect').children().length == 0 && clasn.value == "Program") {
        $("#spnErrorProgram")[0].style.display = "block";
        event.preventDefault(); 
        }else
        $("#spnErrorProgram")[0].style.display = "none";

        //VALIDATE NATURE
        var checked = $("#formValidate input[type=checkbox]:checked").length;
            var isValid = checked > 0;
            if(isValid == false){
              event.preventDefault(); 
            } $("#spnError")[0].style.display = isValid ? "none" : "block";


});
//FOR LISTBOXES
$(function(){
    $("#button1").click(function(){
        $("#list1 > option:selected").each(function(){
            $(this).remove().appendTo("#list2");
        });
    });
    
    $("#button2").click(function(){
        $("#list2 > option:selected").each(function(){
            $(this).remove().appendTo("#list1");
        });
    });
    $("#btnprogram").click(function(){
        $("#lbprogram > option:selected").each(function(){
            $(this).remove().appendTo("#lbpselect");
        });
    });
    
    $("#btnpselect").click(function(){
        $("#lbpselect > option:selected").each(function(){
            $(this).remove().appendTo("#lbprogram");
        });
        $("#lbpselect option").each(function()
        {
            $(this).val() = "selected";
        });
    });
});

function CheckClas(val){
     var school=document.getElementById('schoolcon');
     var program=document.getElementById('program');
     if(val=='School'){
       school.style.display='block';
       program.style.display='none';
     }else if (val=='Program'){
       program.style.display='block';
       school.style.display='none';
      }else{
        school.style.display='none';
        program.style.display='none';
      }
    }
    function otherNature() {
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

</script>