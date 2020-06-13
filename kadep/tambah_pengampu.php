<?php

session_start();

include_once('../include/function.php');
include_once('../include/sidebar.php');

$arrLab = getAllRow('laboratorium');
$arrListDosen = getAllRow('dosen');
$arrListMapel = getAllRow('mapel');
$today = getdate();
$year = $today['year'];

while ($lDosen = $arrListDosen->fetch_object()) {
  $dosenID[] = $lDosen->nip;
  $dosenName[] = $lDosen->nama;
}
$numDosen = count($dosenID);
//echo "jumlah dosen ".$numDosen."</br>";
//print_r($dosenID);

if(isset($_POST['tambah'])){

  //================KAMUS-MATKUL
  $array = array();
  $kodeMP = readInput($_POST['kode']);

  array_push($array,!empty($_POST['kode']) ? $kodeMP : '');
  array_push($array,!empty($_POST['nama']) ? readInput($_POST['nama']) : '');
  array_push($array,!empty($_POST['fakultas']) ? readInput($_POST['fakultas']) : '');
  array_push($array,!empty($_POST['jurusan']) ? readInput($_POST['jurusan']) : '');
  array_push($array,!empty($_POST['tempat']) ? readInput($_POST['tempat']) : '');
  array_push($array,!empty($_POST['hari']) ? readInput($_POST['hari']) : '');
  array_push($array,!empty($_POST['smt']) ? $smt : '');

  if (in_array('',$array)) {
    $notif = 3;
  }
  else {
    if (!checkMapelExist($kodeMP)) {
      if (tambahMapel($array)) {
        $notif = 1;
//        header('Location: info_dosen.php?q='$nip)
      }
      else {
        $notif = 2;
      }
    }
    else {
      $notif = 4;
    }
  }


}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php include_once('../include/head.php'); ?>
  </head>
  <body>

    <main>
      <div class="row">
        <div class="main-border">
          <div class="section col s12 m12 l12">
            <h5 class="judul center-align">Daftar Pengampu Mata Kuliah</h5>

            <div class="row">
              <p class="" id="extra">
              </p>
              <form class="form-horizontal col s12" method="post" enctype="multipart/form-data">

                <table class="center"  style="max-width:100%">
                  <tbody class="cornered">
                  <?php
                  while ($ListMapel = $arrListMapel->fetch_object()) {
                    $kode = $ListMapel->kode;
                    $namaMapel = $ListMapel->nama;
                    $rowPengampu = getPengampu($kode);
                    if (checkQueryExist($rowPengampu)) {
                      while ($pengampu = $rowPengampu->fetch_object()) {
                        $nama[] = $pengampu->nama;
                        $nip[] = $pengampu->nip;
                      }
                    }else {
                        $nip[] = '';
                      }
                      //print_r($nama);
                    ?>

                      <tr id="<?=$kode ?>" class="mapel">
                        <td class="clickable-row" data-href="info_mapel.php?q=<?= $kode ?>" ><?= $namaMapel ?></td>
                        <td class="flexing" >
                          <div style="width:50%">
                            <select class="listDosen" name="<?=$kode ?>">
                              <?php
                              if(in_array('',$nip)) {
                                echo '<option selected disabled value="">- Pilih Laboratorium -</option>';
                              }
                                for ($j=0; $j < $numDosen; $j++) {
                                echo '<option value='.$dosenID[$j].' '.(($dosenID[$j] == $nip[1]) ? 'selected' : '').'>'.$dosenName[$j].'</option>';
                                }
                               ?>
                            </select>

                          </div>

                          <div style="width:50%">
                            <select class="listDosen" name="<?=$kode ?>">
                              <?php
                              if(in_array('',$nip)) {
                                echo '<option selected disabled value="">- Pilih Dosen -</option>';
                              }
                                for ($j=0; $j < $numDosen; $j++) {
                                echo '<option value='.$dosenID[$j].' '.(($dosenID[$j] == $nip[0]) ? 'selected' : '').'>'.$dosenName[$j].'</option>';
                                }
                               ?>
                            </select>
                          </div>


                        </td>

                        <td class="" style="width:10%" class="<?=$kode ?>">
                          <span class="" data-id="<?= $kode ?>" data-class="mapel">
                            <button class="clicked-list btn btn-warning mini-btn waves-effect waves-light" onClick="$(this).TryEdit();" style="width:fit-content">
                              <i class="fa fa-edit fa-2x"></i>
                            </button>
                          </span>
                        </td>
                        <td class="" style="width:10%" >
                          <span class="" data-id="<?= $kode ?>" data-class='mapel'>
                            <button class="btn btn-danger mini-btn clicked-list" onClick="$(this).TryDelete2();" style="width:fit-content">
                              <i class="fa fa-trash-o fa-2x"></i>
                            </button>
                          </span>
                        </td>
                      </a>
                      </tr>
                  <?php
                  unset($nip);unset($nama);
                  }
                  ?>
                </tbody>
                </table>
              </form>
            </div>

          </div>
        </div>
      </div>

    </main>

    <?php include_once('../include/footer.php'); ?>
    <script>
    $(document).ready(function(){
      $('.listDosen').selectize();

      var i,j,mapelId;
      var allMapel = document.querySelectorAll(".mapel");
      mapelId = Array.prototype.map.call(allMapel, function(node) {
        var out = node.id;
        return out;
      });
      //console.log(allMapel);
      //$("#extra").append( "<strong>"+mapelId+"</strong>" );
      for (var j = 0; j < allMapel.length; j++) {
        $('select[name='+mapelId[j]+']')[0].selectize.disable();
        $('select[name='+mapelId[j]+']')[1].selectize.disable();
      }
    });

    function capslock() {
      var str = document.getElementById("kode").value;
      var res = str.toUpperCase();
      document.getElementById("kode").innerHTML= res;
    }

    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    });

</script>


    <?php
    if (isset($notif)) {
      switch ($notif) {
        case 1:
          echo showAlert($notif,'Nilai berhasil ditambahkan '.$errPict);
          break;
        case 2:
          echo showAlert($notif,'Data dosen sudah ada'.$errPict);
          break;
        case 3:
          echo showAlert($notif,'Terdapat data kosong pada formulir '.$errPict);
          break;
        case 4:
          echo showAlert($notif,'Terjadi kesalahan saat proses input  '.$errPict);
          break;
      }
    }
    ?>

  </body>
</html>
