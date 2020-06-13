<?php
function build_calendar($month,$year, $day) {
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
     // How many days does this month contain?
     $dateComponents = getdate($firstDayOfMonth);
     // What is the name of the month in question?
     $monthName = $dateComponents['month'];
     // What is the index value (0-6) of the first day of the
     $target_dir = "../assets/image/";

     $key='';
     $keyM='';
     if ($month<=9) {
       $month="0".$month;
     }

     // Create the table tag opener and day headers
     $calendar = "<table class='calendar'>";
     $calendar .= "<caption>$day $monthName $year</caption>";

     // Create the rest of the calendar
     $date = $year."-".$month."-".$day;

     for ($currentJam=8; $currentJam <=16 ; $currentJam++) {
       $currentJamRel = str_pad($currentJam, 2, "0", STR_PAD_LEFT);
       $calendar .= "<tr class='table-jam' rel='$currentJamRel'>";
       $calendar .= "<td class='day head-kegiatan'>pukul $currentJamRel</td>";
        echo "jam = ".$currentJamRel;
        echo "rel = ".$currentJam;

        $arrKegiatan = getKegiatanByHour($year, $month, $day, $currentJamRel);
        $arrKbm      = getMengampuByHour($month, $year, $day, $currentJamRel);
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

            $calendar .= "<td class='day'>$namaM[$a]</td>";
          }
        }else {
          echo "mapel ".$currentJamRel." error ,";
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
            $calendar .= "<td class='day'>$judul[$m]</td>";
          }
        }else {
          $numKegiatan=0;
        }
        echo "num kegiatan=".$numKegiatan;

     }


     // Complete the row of the last week in month, if necessary

     $calendar .= "</tr>";
     $calendar .= "</table>";
     return $calendar;
}
function build_previousMonth($month,$year,$day){

  $prevMonth = $month - 1;
 $prevDay = $day - 1;

  if ($prevMonth == 0) {
   $prevMonth = 12;
  }

 if ($prevMonth == 12){
  $prevYear = $year - 1;
 } else {
  $prevYear = $year;
 }

 $dateObj = DateTime::createFromFormat('!m', $prevMonth);
 $monthName = $dateObj->format('F');

 return "<div style='width: 33%; display:inline-block;'><a class='btn' href='?m=" . $prevMonth . "&y=". $prevYear ."&d=". $prevDay ."'><i class='material-icons fa fa-arrow-left'></i> " . $monthName . "</a></div>";
}
function build_nextMonth($month,$year,$day){

  $nextMonth = $month + 1;
 $nextDay = $day + 1;

  if ($nextMonth == 13) {
   $nextMonth = 1;
  }

 if ($nextMonth == 1){
  $nextYear = $year + 1;
 } else {
  $nextYear = $year;
 }

 $dateObj = DateTime::createFromFormat('!m', $nextMonth);
 $monthName = $dateObj->format('F');

 return "<div style='width: 33%; display:inline-block;'>&nbsp;</div><div style='width: 33%; display:inline-block; text-align:right;'><a class='btn' href='?m=" . $nextMonth . "&y=". $nextYear . "&d=". $nextDay ."'>" . $monthName . "   <i class='material-icons fa fa-arrow-right black-text'></i></a></div>";
}
?>
