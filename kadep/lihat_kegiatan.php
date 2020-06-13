<?php
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

session_start();


include('../include/function.php');
include('../include/calendar_kadep.php');
include_once('../include/sidebar.php');


$target_dir = "../images/";
$gambar = "no_pict23.png";

//--------------call calendar
//$dateComponents = date_create("2020-1-1");
//--------------read q input
if (isset($_GET['m'])){
  $month = $_GET['m'];
  $year = $_GET['y'];
  $firstDayOfMon = mktime(0,0,0,$month,1,$year);
  $dateComponents = getdate($firstDayOfMon);
  $monthString = $dateComponents['month'];
}else{
      $dateComponents = getdate();
      $monthString = $dateComponents['month'];
      $month = $dateComponents['mon'];
      $year = $dateComponents['year'];
}
    $m='';



?>

<!DOCTYPE html>

<html>
  <head>
    <?php include('../include/head.php') ?>
    <title></title>

  </head>
  <body>
    <main>
      <div class="row main-border">
        <div class="section col s12 l12">
          <div class="full-bar">
            <div id='dp'>
              <?php
               echo build_previousMonth($month, $year, $monthString);
               echo build_nextMonth($month,$year,$monthString);
               echo build_calendar($month,$year,$dateComponents);
               ?>
            </div>
            </div>
          </div>
        </div>
      </div>
    </main>

<?php include_once('../include/footer.php'); ?>
<script>
$(document).ready(function(){
  $('#import').change(function(){
    $('#form-import').submit();
  });
  $.fn.openForm = function() {
    var idk = this.attr('data-id');
    $(".form-popup").css("display","none");
    document.getElementById(idk).style.display = "block";
  };
  $.fn.closeForm = function() {
    var idk = this.parent().parent().attr('id');
    document.getElementById(idk).style.display = "none";
  };
});
</script>
  </body>
</html>
