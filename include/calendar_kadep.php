<!--<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<style>
  body{font-family: Lato;}
</style>
-->

<?php
function build_calendar($month,$year,$dateArray) {
     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);
     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);
     // What is the name of the month in question?
     $monthName = $dateComponents['month'];
     $monthName = castBulan($dateComponents['month']);
     // What is the index value (0-6) of the first day of the
     $target_dir = "../assets/image/";
     // month in question.
     $dayOfWeek = $dateComponents['wday'];
     $key='';
     $keyM='';
     if ($month<=9) {
       $month="0".$month;
     }
     $arrKegiatan = getKegiatanByMonth($year, $month);
     $arrKbm = getMengampuByMonth($month, $year);
     //echo "'".$year."-".$month."-%''";
     if (checkQueryExist($arrKbm)) {
       while($kbm = $arrKbm->fetch_object()){
         $kodeM[] = $kbm->kode;
         $namaM[] = $kbm->nama;
         $hariM[] = $kbm->hari;
         $jam1M[] = $kbm->jamawal;
         $jam2M[] = $kbm->jamakhir;
         $tglM[] = $kbm->tanggal;
       }
       $numMengampu = count($kodeM);
       //echo "kbm succes".$numMengampu.", nama=".$namaM[0];
       //print_r($tglM);
       for ($a=0; $a<$numMengampu ; $a++) {
         $jam1[$a] = explode(':',$jam1M[$a]);
         $jam2[$a] = explode(':',$jam2M[$a]);
         $jamawal[$a] = $jam1[$a][0];
         $jamakhir[$a] = $jam2[$a][0];
         $menitawal[$a] = $jam1[$a][1];
         $menitakhir[$a] = $jam2[$a][1];
       }
     }else {
       //echo "mapel error";
       $numMengampu=0;
     }
     if (checkQueryExist($arrKegiatan)) {
       while ($kegiatan = $arrKegiatan->fetch_object()) {
         $kodeK[] = $kegiatan->id_kegiatan;
         $judul[] = $kegiatan->judul;
         $tanggal[] = $kegiatan->tanggal;
         $waktu[] = $kegiatan->waktu;
       }
       $numKegiatan = count($kodeK);
       for ($m=0; $m<$numKegiatan ; $m++) {
         $pukul[$m] = explode(':',$waktu[$m]);
         $jam[$m] = $pukul[$m][0];
         $menit[$m] = $pukul[$m][1];
       }
     }else {
       $numKegiatan=0;
     }

     // Create the table tag opener and day headers
     echo "<span class='caption'> $monthName $year</span><div class='row'></div>";
     $calendar = "<table class='calendar'>";
     $calendar .= "<tr>";
     foreach($daysOfWeek as $day) {
          $calendar .= "<th class='header'>$day</th>";
     }

     // Create the rest of the calendar
     $currentDay = 1;
     $calendar .= "</tr><tr>";

     if ($dayOfWeek > 0) {
          $calendar .= "<td colspan='$dayOfWeek' class='not-month'>&nbsp;</td>";
     }

     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
     while ($currentDay <= $numberDays) {
          if ($dayOfWeek == 7) {
               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";
          }

          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

          $date = $year."-".$month."-".$currentDayRel;


          if ($numKegiatan>0) {
            $key = array_search($date, $tanggal,true);
            //echo "key kegiatan = ".$key."\n";
          }
          else {
            $key=false;
          }

//          echo "jumlah mengampu = ".$numMengampu;
          if ($numMengampu>0) {
            $keyM = array_search($date, $tglM,true);
          //  echo "key mengampu = ".$keyM."\n";
          }
          else {
            $keyM=false;
          }
          if ((($key===false) || ($key==false)) && (($keyM===false) ||($keyM===false)) ) {
                      if ($date == date("Y-m-d")){
                       $calendar .= "<td class='day today' rel='$date'>
                                    <span class='today-date'>$currentDay</span>
                                    </td>";
                      }else {
                        $calendar .= "<td class='day' rel='$date'><span class='day-date'>$currentDay</span>
                                    </td>";
                      }
            }
            elseif ((($key>=0) && ($key!=false)) && (($keyM===false) || ($keyM==false))) {
              if((strlen($judul[$key]))>12){
                $judul[$key]=str_pad(substr($judul[$key],0,12),15,'.',STR_PAD_RIGHT);
              }

              if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today open-button clickable-row' data-href='lihat_kegiatan_harian.php?m=$month&y=$year&d=$currentDay' data-id='".$kodeK[$key]."' rel='$date'>
                              <span class='today-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'row rect-fluid-left rect-fluid-right'>".$judul[$key]."</div>
                              </div>
                             </td>";
//                             <div class= 'center'>\n".$judul[$key];."</div>
                           }else {
                $calendar .= "<td class='day open-button clickable-row' data-href='lihat_kegiatan_harian.php?m=$month&y=$year&d=$currentDay' data-id='".$kodeK[$key]."' rel='$date'>
                              <span class='day-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'rect-fluid-left rect-fluid-right'>".$judul[$key]."</div>
                              </div>
                             </td>";
                           }
            }
            elseif (($keyM>=0) && (($key===false) || ($key==false))) {
              //echo "<p> cek : key kegiatan =".$key. " + key mapel =".$keyM." dan tanggal= ".$date."</p>";
              if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today open-button clickable-row' data-href='lihat_kegiatan_harian.php?m=$month&y=$year&d=$currentDay'; data-id='".$kodeM[$keyM]."' rel='$date'>
                              <span class='today-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'rect-fluid-left rect-fluid-right'>".substr($namaM[$keyM],0,9)."</div>
                              </div>
                             </td>";
                           }else {
                $calendar .= "<td class='day open-button clickable-row' data-href='lihat_kegiatan_harian.php?m=$month&y=$year&d=$currentDay' data-id='".$kodeM[$keyM]."' rel='$date'>
                              <span class='day-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'rect-fluid-left rect-fluid-right'>".substr($namaM[$keyM],0,9)."</div>
                              </div>
                             </td>";
                           }

            }elseif (($keyM>=0) && ($key>=0)) {
              if((strlen($judul[$key]))>12){
                $judul[$key]=str_pad(substr($judul[$key],0,12),15,'.',STR_PAD_RIGHT);
              }
              if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today open-button clickable-row' data-href='lihat_kegiatan_harian.php?m=$month&y=$year&d=$currentDay' rel='$date'>
                                <span class='today-date'>$currentDay</span>
                                <div class='center'>
                                  <div class= 'center split-top open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeM[$keyM]."'>\n".substr($namaM[$keyM],0,9)."</div>
                                  <div class= 'center split-bot open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeK[$key]."'>\n".$judul[$key]."</div>
                                </div>
                             </td>";
                           }else {
                $calendar .= "<td class='day open-button clickable-row' data-href='lihat_kegiatan_harian.php?m=$month&y=$year&d=$currentDay' rel='$date'>
                                <span class='day-date'>$currentDay</span>
                                <div class='center'>
                                  <div class= 'center split-top open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeM[$keyM]."'>\n".substr($namaM[$keyM],0,9)."</div>
                                  <div class= 'center split-bot open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeK[$key]."'>\n".$judul[$key]."</div>
                                </div>
                              </td>";
                           }

            }
/*
            else{
                        if ($date == date("Y-m-d")){
                         $calendar .= "<td class='day today' rel='$date'>
                                      <span class='today-date'>$currentDay</span>
                                      </td>";
                        }else {
                          $calendar .= "<td class='day' rel='$date'><span class='day-date'>$currentDay</span>
                                      </td>";
                        }
              }
              */
          $currentDay++;
          $dayOfWeek++;

     }


     // Complete the row of the last week in month, if necessary
     if ($dayOfWeek != 7) {

          $remainingDays = 7 - $dayOfWeek;
          $calendar .= "<td colspan='$remainingDays' class='not-month'>&nbsp;</td>";
     }

     $calendar .= "</tr>";
     $calendar .= "</table>";
     return $calendar;
}
function build_previousMonth($month,$year,$monthString){

 $prevMonth = $month - 1;

  if ($prevMonth == 0) {
   $prevMonth = 12;
  }

 if ($prevMonth == 12){
  $prevYear = $year - 1;
 } else {
  $prevYear = $year;
 }

 $dateObj = DateTime::createFromFormat('!m', $prevMonth);
 $monthName = castBulan($dateObj->format('F'));

 return "<div style='width: 13%; display:inline-block;  float: left;'><a class='btn' href='?m=" . $prevMonth . "&y=". $prevYear ."'><i class='material-icons fa fa-arrow-left'></i> " . $monthName . "</a></div>";
}
function build_nextMonth($month,$year,$monthString){

 $nextMonth = $month + 1;

  if ($nextMonth == 13) {
   $nextMonth = 1;
  }

 if ($nextMonth == 1){
  $nextYear = $year + 1;
 } else {
  $nextYear = $year;
 }

 $dateObj = DateTime::createFromFormat('!m', $nextMonth);
 $monthName = castBulan($dateObj->format('F'));


 return "</div><div style='width: 13%; display:inline-block;  float:right;'><a class='btn' href='?m=" . $nextMonth . "&y=". $nextYear ."'>" . $monthName . "   <i class='material-icons fa fa-arrow-right black-text'></i></a></div>";
}
?>
