<!--<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<style>
  body{font-family: Lato;}
</style>
-->

<?php
function build_calendar($month,$year,$dateArray, $q) {
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
     // What is the index value (0-6) of the first day of the
     $target_dir = "../assets/image/";
     // month in question.
     $dayOfWeek = $dateComponents['wday'];
     $key='';
     $keyM='';
     $arrKegiatan = getKegiatanSpesificRow('kegiatan_dosen','kegiatan','id_kegiatan','nip',$q);
     $arrKbm = getKbmSpesificRow('mengampu','mapel','kode','nip',$q);
     if (checkQueryExist($arrKbm)) {
       while($kbm = $arrKbm->fetch_object()){
         $kodeM[] = $kbm->kode;
         $namaM[] = $kbm->nama;
         $fakM[] = $kbm->fakultas;
         $jurM[] = $kbm->jurusan;
         $tempatM[] = $kbm->tempat;
         $hariM[] = $kbm->hari;
         $smtM[] = $kbm->semester;
         $jam1M[] = $kbm->jamawal;
         $jam2M[] = $kbm->jamakhir;
         $tglM[] = $kbm->tanggal;
       }
       $numMengampu = count($kodeM);
       for ($a=0; $a<$numMengampu ; $a++) {
         $jam1[$a] = explode(':',$jam1M[$a]);
         $jam2[$a] = explode(':',$jam2M[$a]);
         $jamawal[$a] = $jam1[$a][0];
         $jamakhir[$a] = $jam2[$a][0];
         $menitawal[$a] = $jam1[$a][1];
         $menitakhir[$a] = $jam2[$a][1];
       }
     }else {
       $numMengampu=0;
     }
     if (checkQueryExist($arrKegiatan)) {
       while ($kegiatan = $arrKegiatan->fetch_object()) {
         $kodeK[] = $kegiatan->id_kegiatan;
         $judul[] = $kegiatan->judul;
         $tanggal[] = $kegiatan->tanggal;
         $waktu[] = $kegiatan->waktu;
         $jenis[] = $kegiatan->jenis;
         $tempat[] = $kegiatan->tempat;
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
     $calendar = "<table class='calendar'>";
     $calendar .= "<caption>$monthName $year</caption>";
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
            if (in_array($date,$tanggal)) {
              $rowKontributor[$key] = getKontributorSpesificRow ('kegiatan_dosen','dosen','nip','id_kegiatan',$kodeK[$key]);
              while ($kontributor[$key] = $rowKontributor[$key]->fetch_object()) {
                $nama_k[$key][] = $kontributor[$key]->nama;
                $nip_k[$key][]  = $kontributor[$key]->nip;
                $foto_k[$key][] = $kontributor[$key]->foto;
              }
              $numKontributor[$key] = count($nip_k[$key]);
            }
          }
          else {
            $key==false;
          }
//          echo "jumlah mengampu = ".$numMengampu;
          if ($numMengampu>0) {
            $keyM = array_search($date, $tglM,true);
//            echo "key mengampu = ".$keyM."\n";
          }
          else {
            $keyM==false;
          }
          if ((($key==false) || ($key==null)) && (($keyM==false) || ($keyM==null))) {
                      if ($date == date("Y-m-d")){
                       $calendar .= "<td class='day today' rel='$date'>
                                    <span class='today-date'>$currentDay</span>
                                    </td>";
                      }else {
                        $calendar .= "<td class='day' rel='$date'><span class='day-date'>$currentDay</span>
                                    </td>";
                      }
            }
            elseif (($key>=0) && (($keyM==false) || ($keyM==null))) {
              if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today open-button' onclick='$(this).openForm();' data-id='".$kodeK[$key]."' rel='$date'>
                              <span class='today-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'row rect-fluid-left rect-fluid-right'>".$judul[$key]."</div>
                              </div>
                             </td>";
//                             <div class= 'center'>\n".$judul[$key]."</div>
                           }else {
                $calendar .= "<td class='day open-button' onclick='$(this).openForm();' data-id='".$kodeK[$key]."' rel='$date'>
                              <span class='day-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'rect-fluid-left rect-fluid-right'>".$judul[$key]."</div>
                              </div>
                             </td>";
                           }
               echo "<div class='form-popup' data-class='pop-up' id='".$kodeK[$key]."'>";
                 echo "<div class='form-container'>";
                            $jenisK[$key] = castJenisKegiatan($jenis[$key]);
                   echo  "<div class='top-right'>jenis : <b>".$jenisK[$key]."</b></div>";
                   echo  "<h2>".$judul[$key]."</h2>";
                   echo   "<div class='row'>";
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                               <label for='cal".$key."'>Tanggal Pelaksanaan</label>
                             </div>";
                             $kalender[$key] = date_create($tanggal[$key]);
                   echo      "<div class='col-75 data-popup'>
                               <div id='cal".$key."'> ".date_format($kalender[$key], 'l, d F Y')."</div>
                               </div>
                           </div>";//close row

                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                               <label for='jam".$key."'>Waktu Pelaksanaan</label>
                             </div>";
                   echo      "<div class='col-75 data-popup'>
                               <div id='jam".$key."'> ".$jam[$key].":".$menit[$key]." WIB </div>
                               </div>
                           </div>"; //ckose row
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                              <label for='tempat".$key."'>Lokasi Kegiatan</label>
                             </div>";
                   echo      "<div class='col-75 data-popup'>
                               <div id='tempat".$key."'>".$tempat[$key]."</div>
                               </div>
                           </div>";
                             for ($n=0; $n<$numKontributor[$key] ; $n++) {
                               $d_foto_k[$key][$n] = $target_dir.$foto_k[$key][$n];
                   echo   "<a href=info_dosen.php?q=".$nip_k[$key][$n].">
                           <div class='row container-divide' style='margin: 0 20px 10px 20px'>";
                   echo      "<div class='foto-container'>
                                 <img src=".$d_foto_k[$key][$n]." alt='foto dosen' border='5px' class='foto-profil' >
                                 <div class='bottom-center'>".$nama_k[$key][$n]."</div>
                               </div>
                             </div>
                         </a>";
                           }

                   echo    "</div>";
                 echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
               echo   "</div></div>";
            }
            elseif (($keyM>=0) && (($key==false) || ($key==null))) {
              if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today open-button' onclick='$(this).openForm();' data-id='".$kodeM[$keyM]."' rel='$date'>
                              <span class='today-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'rect-fluid-left rect-fluid-right'>".$namaM[$keyM]."</div>
                              </div>
                              <div class= 'center' style='display:none;'>\n".$namaM[$keyM]."</div>
                             </td>";
                           }else {
                $calendar .= "<td class='day open-button' onclick='$(this).openForm();' data-id='".$kodeM[$keyM]."' rel='$date'>
                              <span class='day-date'>$currentDay</span>
                              <div class= 'center'>
                                <div class= 'rect-fluid-left rect-fluid-right'>".$namaM[$keyM]."</div>
                              </div>
                              <div class= 'center' style='display: none;'>".$namaM[$keyM]."</div>
                             </td>";
                           }
               echo "<div class='form-popup popup-kanan' data-class='pop-up' id='".$kodeM[$keyM]."'>";
                 echo "<div class='form-container kbm'>";
                   echo  "<div class='top-right'>jenis : <b>KBM</b></div>";
                   echo  "<h2>".$namaM[$keyM]."</h2>";
                   echo   "<div class='row'>";
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                               <label for='cal".$key."'>Tanggal Pelaksanaan</label>
                             </div>";
                             $kalender[$keyM] = date_create($tglM[$keyM]);
                   echo      "<div class='col-75 data-popup'>
                               <div id='cal".$key."'> ".date_format($kalender[$keyM], 'l, d F Y')."</div>
                               </div>
                           </div>";//close row

                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                               <label for='jam".$keyM."'>Waktu</label>
                             </div>";
                   echo      "<div class='col-75 data-popup' id='jam".$keyM."'>
                               <div class='col-50'>
                               <div> ".$jamawal[$keyM].":".$menitawal[$keyM]." WIB </div>
                               </div>
                               <div class='col-50'>
                               <div> ".$jamakhir[$keyM].":".$menitakhir[$keyM]." WIB </div>
                               </div>
                             </div>
                           </div>"; //ckose row
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                              <label for='tempat".$keyM."'>Ruang</label>
                             </div>";
                   echo      "<div class='col-75 data-popup'>
                               <div id='tempat".$keyM."'>".$tempatM[$keyM]."</div>
                               </div>
                           </div>";
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                              <label for='tempat".$keyM."'>Fakultas</label>
                             </div>";
                   echo      "<div class='col-25 data-popup'>
                               <div id='tempat".$keyM."'>".$fakM[$keyM]."</div>
                               </div>
                           </div>";
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                              <label for='tempat".$keyM."'>Fakultas</label>
                             </div>";
                   echo      "<div class='col-25 data-popup'>
                               <div id='tempat".$keyM."'>".$fakM[$keyM]."</div>
                               </div>
                           </div>";

                   echo    "</div>";
                 echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
               echo   "</div></div>";
            }elseif (($keyM>=0) && ($key>=0)) {
              if ($date == date("Y-m-d")){
                $calendar .= "<td class='day today' rel='$date'>
                              <span class='today-date'>$currentDay</span>
                              <div class= 'center split-top open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeM[$keyM]."'>\n".$namaM[$keyM]."</div>
                              <div class= 'center split-bot open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeK[$key]."'>\n".$judul[$key]."</div>
                             </td>";
                           }else {
                $calendar .= "<td class='day' rel='$date'>
                              <span class='day-date'>$currentDay</span>
                              <div class= 'center split-top open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeM[$keyM]."'>\n".$namaM[$keyM]."</div>
                              <div class= 'center split-bot open-button rect-fluid-right rect-fluid-left' onclick='$(this).openForm();' data-id='".$kodeK[$key]."'>\n".$judul[$key]."</div>
                              </td>";
                           }
                           echo "<div class='form-popup popup-kanan' data-class='pop-up' id='".$kodeM[$keyM]."'>";
                             echo "<div class='form-container kbm'>";
                               echo  "<div class='top-right'>jenis : <b>KBM</b></div>";
                               echo  "<h2>".$namaM[$keyM]."</h2>";
                               echo   "<div class='row'>";
                               echo   "<div class='row'>";
                               echo      "<div class='col-25'>
                                           <label for='cal".$key."'>Tanggal Pelaksanaan</label>
                                         </div>";
                                         $kalender[$keyM] = date_create($tglM[$keyM]);
                               echo      "<div class='col-75 data-popup'>
                                           <div id='cal".$key."'> ".date_format($kalender[$keyM], 'l, d F Y')."</div>
                                           </div>
                                       </div>";//close row

                               echo   "<div class='row'>";
                               echo      "<div class='col-25'>
                                           <label for='jam".$keyM."'>Waktu</label>
                                         </div>";
                               echo      "<div class='col-75 data-popup' id='jam".$keyM."'>
                                           <div class='col-50'>
                                           <div> ".$jamawal[$keyM].":".$menitawal[$keyM]." WIB </div>
                                           </div>
                                           <div class='col-50'>
                                           <div> ".$jamawal[$keyM].":".$menitawal[$keyM]." WIB </div>
                                           </div>
                                         </div>
                                       </div>"; //ckose row
                               echo   "<div class='row'>";
                               echo      "<div class='col-25'>
                                          <label for='tempat".$keyM."'>Ruang</label>
                                         </div>";
                               echo      "<div class='col-75 data-popup'>
                                           <div id='tempat".$keyM."'>".$tempatM[$keyM]."</div>
                                           </div>
                                       </div>";
                               echo   "<div class='row'>";
                               echo      "<div class='col-25'>
                                          <label for='tempat".$keyM."'>Fakultas</label>
                                         </div>";
                               echo      "<div class='col-25 data-popup'>
                                           <div id='tempat".$keyM."'>".$fakM[$keyM]."</div>
                                           </div>
                                       </div>";
                               echo   "<div class='row'>";
                               echo      "<div class='col-25'>
                                          <label for='tempat".$keyM."'>Fakultas</label>
                                         </div>";
                               echo      "<div class='col-25 data-popup'>
                                           <div id='tempat".$keyM."'>".$fakM[$keyM]."</div>
                                           </div>
                                       </div>";

                               echo    "</div>";
                             echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
                           echo   "</div></div>";

               echo "<div class='form-popup' data-class='pop-up' id='".$kodeK[$key]."'>";
                 echo "<div class='form-container'>";
                            $jenisK[$key] = castJenisKegiatan($jenis[$key]);
                   echo  "<div class='top-right'>jenis : <b>".$jenisK[$key]."</b></div>";
                   echo  "<h2>".$judul[$key]."</h2>";
                   echo   "<div class='row'>";
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                               <label for='cal".$key."'>Tanggal Pelaksanaan</label>
                             </div>";
                             $kalender[$key] = date_create($tanggal[$key]);
                   echo      "<div class='col-75 data-popup'>
                               <div id='cal".$key."'> ".date_format($kalender[$key], 'l, d F Y')."</div>
                               </div>
                           </div>";//close row

                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                               <label for='jam".$key."'>Waktu Pelaksanaan</label>
                             </div>";
                   echo      "<div class='col-75 data-popup'>
                               <div id='jam".$key."'> ".$jam[$key].":".$menit[$key]." WIB </div>
                               </div>
                           </div>"; //ckose row
                   echo   "<div class='row'>";
                   echo      "<div class='col-25'>
                              <label for='tempat".$key."'>Lokasi Kegiatan</label>
                             </div>";
                   echo      "<div class='col-75 data-popup'>
                               <div id='tempat".$key."'>".$tempat[$key]."</div>
                               </div>
                           </div>";
                             for ($n=0; $n<$numKontributor[$key] ; $n++) {
                               $d_foto_k[$key][$n] = $target_dir.$foto_k[$key][$n];
                   echo   "<a href=info_dosen.php?q=".$nip_k[$key][$n].">
                           <div class='row container-divide' style='margin: 0 20px 10px 20px'>";
                   echo      "<div class='foto-container'>
                                 <img src=".$d_foto_k[$key][$n]." alt='foto dosen' border='5px' class='foto-profil' >
                                 <div class='bottom-center'>".$nama_k[$key][$n]."</div>
                               </div>
                             </div>
                         </a>";
                           }

                   echo    "</div>";
                 echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
               echo   "</div></div>";
            }
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
function build_previousMonth($month,$year,$monthString,$q){

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
 $monthName = $dateObj->format('F');

 return "<div style='width: 33%; display:inline-block;'><a class='btn' href='?q=".$q."&m=" . $prevMonth . "&y=". $prevYear ."'><i class='material-icons fa fa-arrow-left'></i> " . $monthName . "</a></div>";
}
function build_nextMonth($month,$year,$monthString,$q){

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
 $monthName = $dateObj->format('F');

 return "<div style='width: 33%; display:inline-block;'>&nbsp;</div><div style='width: 33%; display:inline-block; text-align:right;'><a class='btn' href='?q=".$q."&m=" . $nextMonth . "&y=". $nextYear ."'>" . $monthName . "   <i class='material-icons fa fa-arrow-right black-text'></i></a></div>";
}
?>
