
  <script type="text/javascript">
  function calculateSum() {

    var sum = 0;
    var fpassed = document.getElementById("fpassed").value;

    $(".ftaker").each(function() {

      if(!isNaN(this.value)) {
        sum += parseFloat(this.value);
      }

    });
    var fpercent = (fpassed/sum)*100;
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#ftotal").html(sum);
    $("#fpercent").html(fpercent.toFixed(2)+"%");


    var total = 0;
    var tpassed = document.getElementById("tpassed").value;
    $(".ttaker").each(function() {

      if(!isNaN(this.value)) {
        total += parseFloat(this.value);
      }

    });
    var tpercent = (tpassed/total)*100;
    var npercent = fpercent+tpercent;
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $("#ttotal").html(total);
    $("#tpercent").html(tpercent.toFixed(2)+"%");
    $("#npercent").html(npercent.toFixed(2)+"%s");
  }
  </script>
