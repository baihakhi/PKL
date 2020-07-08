<?php
function build_calendar($month,$year, $day) {
     $firstDayOfMonth = mktime(0,0,0,$month,$day,$year);
     // How many days does this month contain?
     $dateComponents = getdate($firstDayOfMonth);
     // What is the name of the month in question?
     $monthName = castBulan($dateComponents['month']);
     $dayName = $dateComponents['weekday'];
     $dayName = castHari(readInput($dayName));
     // What is the index value (0-6) of the first day of the
     $target_dir = "../assets/image/";


     if ($month<=9) {
       $month="0".$month;
     }

     // Create the table tag opener and day headers
     echo "<span class='caption'>$dayName , $day $monthName $year</span><div class='row'></div>";
     $calendar = "<table class='calendar'>";
     $calendar .= "";

     // Create the rest of the calendar
     $date = $year."-".$month."-".$day;

     for ($currentJam=8; $currentJam <=16 ; $currentJam++) {
       $currentJamRel = str_pad($currentJam, 2, "0", STR_PAD_LEFT);

       $calendar .= " <tr class='tr-jam' rel='$currentJamRel'>";
       $calendar .= " <td class='table_td_jam head-kegiatan'>";
       $calendar .= "   <div class='td-jam block-fluid'>pukul $currentJamRel</div>";
       $calendar .= " </td>";
        //echo "jam = ".$currentJamRel;
        //echo "rel = ".$currentJam;

        $arrKegiatan = getKegiatanByHour($year, $month, $day, $currentJamRel);
        $arrKbm      = getMengampuByHour($month, $year, $day, $currentJamRel);
      //echo "'".$year."-".$month."-%''";
        if (checkQueryExist($arrKbm)) {
          while($kbm = $arrKbm->fetch_object()){
            $kodeM[$currentJamRel][] = $kbm->kode;
            $namaM[$currentJamRel][] = $kbm->nama;
            $hariM[$currentJamRel][] = $kbm->hari;
            $tempatM[$currentJamRel][] = $kbm->tempat;
            $fakM[$currentJamRel][] = $kbm->fakultas;
            $jur[$currentJamRel][]  = $kbm->jurusan;
            $jam1M[$currentJamRel][] = $kbm->jamawal;
            $jam2M[$currentJamRel][] = $kbm->jamakhir;
            $tglM[$currentJamRel][] = $kbm->tanggal;
            }
            $numMengampu = count($kodeM[$currentJamRel]);
            //echo "kbm succes".$numMengampu.", nama=".$namaM[$currentJamRel][0];
            //print_r($tglM);
            for ($a=0; $a<$numMengampu ; $a++) {
              $jam1[$currentJamRel][$a] = explode(':',$jam1M[$currentJamRel][$a]);
              $jam2[$currentJamRel][$a] = explode(':',$jam2M[$currentJamRel][$a]);
              $jamawal[$currentJamRel][$a] = $jam1[$currentJamRel][$a][0];
              $jamakhir[$currentJamRel][$a] = $jam2[$currentJamRel][$a][0];
              $menitawal[$currentJamRel][$a] = $jam1[$currentJamRel][$a][1];
              $menitakhir[$currentJamRel][$a] = $jam2[$currentJamRel][$a][1];

            $calendar .= "<td class='table_td_jam'>";
            $calendar .= "  <div class='td-jam block-fluid open-button' onclick='$(this).openForm();' data-id='".$kodeM[$currentJamRel][$a]."'>".$namaM[$currentJamRel][$a]."</div>";
            echo "<div class='form-popup popup-kanan' data-class='pop-up' id='".$kodeM[$currentJamRel][$a]."'>";
              echo "<div class='form-container kbm'>";
                echo  "<div class='top-right'>jenis : <b>KBM</b></div>";
                echo  "<h2>".$namaM[$currentJamRel][$a]."</h2>";
                echo   "<div class='row'>";
                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                            <label for='cal".$kodeM[$currentJamRel][$a]."'>Tanggal Pelaksanaan</label>
                          </div>";
                          $kalender[$currentJamRel][$a] = date_create($tglM[$currentJamRel][$a]);
                echo      "<div class='col-75 data-popup'>
                            <div id='cal".$kodeM[$currentJamRel][$a]."'> ".date_format($kalender[$currentJamRel][$a], 'l, d F Y')."</div>
                            </div>
                        </div>";//close row

                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                            <label for='jam".$kodeM[$currentJamRel][$a]."'>Waktu</label>
                          </div>";
                echo      "<div class='col-75 data-popup' id='jam".$kodeM[$currentJamRel][$a]."'>
                            <div class='col-50'>
                            <div> ".$jamawal[$currentJamRel][$a].":".$menitawal[$currentJamRel][$a]." WIB </div>
                            </div>
                            <div class='col-50'>
                            <div> ".$jamakhir[$currentJamRel][$a].":".$menitakhir[$currentJamRel][$a]." WIB </div>
                            </div>
                          </div>
                        </div>"; //ckose row
                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                           <label for='tempat".$kodeM[$currentJamRel][$a]."'>Ruang</label>
                          </div>";
                echo      "<div class='col-75 data-popup'>
                            <div id='tempat".$kodeM[$currentJamRel][$a]."'>".$tempatM[$currentJamRel][$a]."</div>
                            </div>
                        </div>";
                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                           <label for='tempat".$kodeM[$currentJamRel][$a]."'>Fakultas</label>
                          </div>";
                echo      "<div class='col-25 data-popup'>
                            <div id='tempat".$kodeM[$currentJamRel][$a]."'>".$fakM[$currentJamRel][$a]."</div>
                            </div>
                        </div>";
                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                           <label for='jur".$kodeM[$currentJamRel][$a]."'>Departemen</label>
                          </div>";
                echo      "<div class='col-25 data-popup'>
                            <div id='jur".$kodeM[$currentJamRel][$a]."'>".$jur[$currentJamRel][$a]."</div>
                            </div>
                        </div>";

                echo    "</div>";
              echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
            echo   "</div></div>";

          }
          $calendar .= "</td>";
        }else {
          //echo "mapel ".$currentJamRel." error ,";
          $numMengampu=0;
        }
        if (checkQueryExist($arrKegiatan)) {
          $calendar .= "</tr>";
          $calendar .= " <tr class='tr-jam' rel='$currentJamRel'>";
          $calendar .= " <td class='table_td_jam head-kosong'>";
          $calendar .= " </td>";
          while ($kegiatan = $arrKegiatan->fetch_object()) {
            $kodeK[$currentJamRel][] = $kegiatan->id_kegiatan;
            $judul[$currentJamRel][] = $kegiatan->judul;
            $tempatK[$currentJamRel][] = $kegiatan->tempat;
            $tanggalK[$currentJamRel][] = $kegiatan->tanggal;
            $waktuK[$currentJamRel][] = $kegiatan->waktu;
            $jenisK[$currentJamRel][] = $kegiatan->jenis;
          }
          $numKegiatan = count($kodeK);
          for ($m=0; $m<$numKegiatan ; $m++) {

            $pukul[$currentJamRel][$m] = explode(':',$waktuK[$currentJamRel][$m]);
            $jam[$currentJamRel][$m] = $pukul[$currentJamRel][$m][0];
            $menit[$currentJamRel][$m] = $pukul[$currentJamRel][$m][1];

            $rowKontributor[$currentJamRel][$m] = getKontributorSpesificRow ('kegiatan_dosen','dosen','nip','id_kegiatan',$kodeK[$currentJamRel][$m]);
            while ($kontributor[$currentJamRel][$m] = $rowKontributor[$currentJamRel][$m]->fetch_object()) {
              $nama_k[$currentJamRel][$m] [] = $kontributor[$currentJamRel][$m]->nama;
              $nip_k[$currentJamRel][$m][]  = $kontributor[$currentJamRel][$m]->nip;
              $foto_k[$currentJamRel][$m][] = $kontributor[$currentJamRel][$m]->foto;
            }
            $numKontributor[$currentJamRel][$m] = count($nip_k[$currentJamRel][$m]);


            $calendar .= "<td class='table_td_jam'>";
            $calendar .= "<div class='td-jam block-fluid open-button' onclick='$(this).openForm();' data-id='".$kodeK[$currentJamRel][$m]."'>".$judul[$currentJamRel][$m]."</div>";
            echo "<div class='form-popup' data-class='pop-up' id='".$kodeK[$currentJamRel][$m]."'>";
              echo "<div class='form-container'>";
                         $jenisK[$currentJamRel][$m] = castJenisKegiatan($jenisK[$currentJamRel][$m]);
                echo  "<div class='top-right'>jenis : <b>".$jenisK[$currentJamRel][$m]."</b></div>";
                echo  "<h2>".$judul[$currentJamRel][$m]."</h2>";
                echo   "<div class='row'>";
                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                            <label for='cal".$kodeK[$currentJamRel][$m]."'>Tanggal Pelaksanaan</label>
                          </div>";
                          $kalender[$currentJamRel][$m] = date_create($tanggalK[$currentJamRel][$m]);
                echo      "<div class='col-75 data-popup'>
                            <div id='cal".$kodeK[$currentJamRel][$m]."'> ".date_format($kalender[$currentJamRel][$m], 'l, d F Y')."</div>
                            </div>
                        </div>";//close row

                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                            <label for='jam".$kodeK[$currentJamRel][$m]."'>Waktu Pelaksanaan</label>
                          </div>";
                echo      "<div class='col-75 data-popup'>
                            <div id='jam".$kodeK[$currentJamRel][$m]."'> ".$jam[$currentJamRel][$m].":".$menit[$currentJamRel][$m]." WIB </div>
                            </div>
                        </div>"; //ckose row
                echo   "<div class='row'>";
                echo      "<div class='col-25'>
                           <label for='tempat".$kodeK[$currentJamRel][$m]."'>Lokasi Kegiatan</label>
                          </div>";
                echo      "<div class='col-75 data-popup'>
                            <div id='tempat".$kodeK[$currentJamRel][$m]."'>".$tempatK[$currentJamRel][$m]."</div>
                            </div>
                        </div>";
                          for ($n=0; $n<$numKontributor[$currentJamRel][$m] ; $n++) {
                            $d_foto_k[$currentJamRel][$m][$n] = $target_dir.$foto_k[$currentJamRel][$m][$n];
                            echo   "<a href=info_dosen.php?q=".$nip_k[$currentJamRel][$m][$n].">
                                    <div class='row container-divide' style='margin: 0 20px 10px 20px'>";
                            echo      "<div class='foto-container'>
                                          <img src=".$d_foto_k[$currentJamRel][$m][$n]." alt='foto dosen' border='5px' class='foto-profil' >
                                          <div class='bottom-center'>".$nama_k[$currentJamRel][$m][$n]."</div>
                                        </div>
                                      </div>
                                  </a>";
                        }

                echo    "</div>";
              echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
            echo   "</div></div>";

          }
          $calendar .= "</td>";
        }else {
          $numKegiatan=0;
        }
        //echo "num kegiatan=".$numKegiatan;

        $calendar .= "</div>";
        $calendar .= "</tr>";
     }


     // Complete the row of the last week in month, if necessary

     $calendar .= "</table>";
     return $calendar;
}
function build_previousDay($month,$year,$day){

  $prevMonth = $month;
  $prevYear = $year;
  $prevDay = $day - 1;

 if ($prevDay == 0) {
    $prevMonth = $month - 1;

    if ($prevMonth == 0) {
     $prevMonth = 12;
    }

   if ($prevMonth == 12){
    $prevYear = $year - 1;
   }

  $prevDay = cal_days_in_month(CAL_GREGORIAN,$prevMonth,$prevYear);
 }

 $dateObj = DateTime::createFromFormat('!m', $prevMonth);
 $monthName = $dateObj->format('F');
 $monthName = castBulan($monthName);

 return "<div style='width: 13%; display:inline-block; float: left;'><a class='btn' href='?m=" . $prevMonth . "&y=". $prevYear ."&d=". $prevDay ."'><i class='material-icons fa fa-arrow-left'></i> " . $prevDay." ". $monthName . "</a></div>";
}
function build_nextDay($month,$year,$day){

  $nextDay = $day + 1;
  $nextMonth = $month;
  $nextYear = $year;

 $maxDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);

 if ($nextDay == $maxDays+1) {
   $nextMonth = $month+1;

   if ($nextMonth == 13) {
    $nextMonth = 1;
   }

  if ($nextMonth == 1){
   $nextYear = $year + 1;
  }
  $nextDay = 1;
 }

 $dateObj = DateTime::createFromFormat('!m', $nextMonth);
 $monthName = castBulan($dateObj->format('F'));

 return "</div><div style='width: 13%; display:inline-block; float:right;'><a class='btn' href='?m=" . $nextMonth . "&y=". $nextYear . "&d=". $nextDay ."'>" . $nextDay ." ". $monthName . "   <i class='material-icons fa fa-arrow-right black-text'></i></a></div>";
}
?>
