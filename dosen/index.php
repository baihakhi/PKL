<?php

session_start();

include_once('../include/function.php');
include_once('../include/sidebar.php');

$target_dir = "../images/";
$gambar = "no_pict23.png";

//--------------read q input

  $row = getSpesificRow('dosen','nip',$username);
  if (checkQueryExist($row)) {
    while ($dosen = $row->fetch_object()) {
      $nama = $dosen->nama;
      $nip = $dosen->nip;
      $ttl = $dosen->TTL;
      $alamat = $dosen->alamat;
      $email = $dosen->email;
      $foto = $dosen->foto;
      $id_lab = $dosen->laboratorium;

      $row_lab = getLabDosen($id_lab);
      while ($lab = $row_lab->fetch_object()) {
        $nama_lab = $lab->nama_lab;
      }
      $rowKarya = getMoreSpesificRow2('karya_dosen','karya_ilmiah','id_karya','nip',$nip);
      if (checkQueryExist($rowKarya)) {
        while ($karya = $rowKarya->fetch_object()) {
          $idKarya[] = $karya->id_karya;
          $judul[] = $karya->judul;
          $tanggal[] = $karya->tanggal;
          $jenis[] = $karya->jenis;
          $dana[] = $karya->dana;
          $pendana[] = $karya->pendana;
          $dokumen[] = $karya->dokumen;
          }
          }
          if (!empty($idKarya)) {
            $numKarya = count($idKarya);
          }else {
            $numKarya = 0;
        }

            if (!empty($foto)){
              $gambar = $foto;
              $target_dir = "../assets/image/";
            }
          }
        }
        else {
          header('Location: index.php');
        }

      $profilPict = $target_dir . $gambar;

      //------------photo calling
        $target_dir = "../assets/image/";

      //-------------parsing TTL
        $TTL = explode(",",$ttl);
        $date = date_create($TTL[1]);
        $city = $TTL[0];

      ?>


      <!DOCTYPE html>
      <html>
        <head>
          <?php include('../include/head.php') ?>
        </head>
        <body>
          <main>
            <div class="row main-border">
              <div class="section col s12 l12">
                <div class="full-bar">
                  <?php
                  if(!empty($img)){
                    $file = $direktori . $img;
                  }
                  else {
                    $img = 'no_pict23.png';
                    $direktori = 'images/';
                    $file = $direktori . $img;
                  } ?>
                  <div class="left-to-center">
                    <div class="center-align">
                      <img src="<?= $profilPict; ?>" alt="foto dosen" border="5px" class="foto-profil" onerror="this.onerror=null;../images/no_pict23.png;">
                    </div>
                  </div>
                  <div class="kanan-align">
                    <a href="lihat_karya.php?q=<?= $nip ?>" class="btn waves-effect" style="width:100%;">lihat jadwal</a>
                  </div>
                  <div class="row">
                    <table class="center" style="max-width:780px;">
                      <tr>
                        <td style="width:20%;">Nama</td>
                        <td class="colon">:</td>
                        <td><?php echo $nama; ?></td>
                      </tr>
                      <tr>
                        <td style="width:20%;">Nomor Induk Pegawai</td>
                        <td class="colon">:</td>
                        <td><?php echo $nip; ?></td>
                      </tr>
                      <tr>
                        <td style="width:20%;">Tempat tanggal lahir</td>
                        <td class="colon">:</td>
                        <td><?php echo $city,", ",date_format($date, "d F Y"); ?></td>
                      </tr>
                      <tr>
                        <td style="width:20%;">Alamat</td>
                        <td class="colon">:</td>
                        <td><?php echo $alamat; ?></td>
                      </tr>
                      <tr>
                        <td style="width:20%;">Email</td>
                        <td class="colon">:</td>
                        <td><?php echo $email; ?></td>
                      </tr>
                      <tr>
                        <td style="width:20%;">Laboratorium</td>
                        <td class="colon">:</td>
                        <td><?php echo $nama_lab; ?></td>
                      </tr>
                    </table>
                    <table class="" name="karim" id="karim" style="max-width:90%; margin:0 10% 0 5% ">
                      <th colspan="5" class="center-align judul">Daftar Karya ilmiah</th>
                      <tbody align="center" class="cornered">
                        <tr>
                          <td class="judul-tabel" style="width: 50%">Judul</td>
                          <td class="judul-tabel">Jenis Karya</td>
                          <td class="judul-tabel">Tanggal</td>
                        </tr>
                        <?php
                        if ($numKarya>0) {
                          for ($i=0; $i<$numKarya ; $i++) {
                            echo "<tr class='open-button' onclick='$(this).openForm();' data-id='".$idKarya[$i]."'>";
                            echo  "<td class=''>".$judul[$i]."</td>";

                            $jenis_karya[$i] = castJenisKarya($jenis[$i]);
                            $pAnggar[$i] = castPendana($pendana[$i]);
                            $rowKontributor[$i] = getKontributorSpesificRow ('karya_dosen','dosen','nip','id_karya',$idKarya[$i]);
                            while ($kontributor[$i] = $rowKontributor[$i]->fetch_object()) {
                              $nama_k[$i][] = $kontributor[$i]->nama;
                              $nip_k[$i][]  = $kontributor[$i]->nip;
                              $foto_k[$i][] = $kontributor[$i]->foto;
                            }
                            $numKontributor[$i] = count($nip_k[$i]);
                            echo  "<td style='text-align: center'>".$jenis_karya[$i]."</td>";
                            $calender[$i] = date_create($tanggal[$i]);
                            echo  "<td style='text-align: center'>".date_format($calender[$i], "d F Y")."</td>";
      //                      echo  "<td style='text-align: right'> Rp.".$dana[$i]."</td>";
                            echo "<tr>";

                            echo "<div class='form-popup' data-class='pop-up' id='".$idKarya[$i]."'>";
                            echo "<div class='form-container'>";
                            echo  "<div class='top-right'>jenis : <b>".$jenis_karya[$i]."</b></div>";
                            echo  "<h2>".$judul[$i]."</h2>";

                            echo   "<div class='row'>";
                            echo     "<a href=".$dokumen[$i]." target='_blank'>
                                      <div class='clicked-list center btn waves-effect waves-light'>
                                        kunjungi laman dokumen
                                      </div>
                                      </a>";
                            echo   "<div class='row'>";
                            echo      "<div class='col-25'>
                                        <label for='cal".$i."'>Tanggal Submit</label>
                                      </div>";
                            echo      "<div class='col-75 data-popup'>
                                        <div id='cal".$i."'> ".date_format($calender[$i], 'l, d F Y')."</div>
                                        </div>
                                    </div>";
                            echo   "<div class='row'>";
                            echo      "<div class='col-25'>
                                       <label for='anggaran".$i."'>Jumlah Anggaran</label>
                                      </div>";
                            echo      "<div class='col-75 data-popup'>
                                        <div id='anggaran".$i."'> Rp.".$dana[$i]."</div>
                                        </div>
                                    </div>";
                            echo   "<div class='row'>";
                            echo      "<div class='col-25'>
                                        <label for='pAnggaran".$i."'>Sumber Anggaran</label>
                                      </div>";
                            echo      "<div class='col-75 data-popup'>
                                        <div id='pAnggaran".$i."'> ".$pAnggar[$i]."</div>
                                        </div>
                                    </div>";
                                      for ($j=0; $j<$numKontributor[$i] ; $j++) {
                                        $d_foto_k[$i][$j] = $target_dir . $foto_k[$i][$j];
                            echo   "<a href=info_dosen.php?q=".$nip_k[$i][$j].">
                                    <div class='row container-divide' style='margin: 0 20px 10px 20px'>";
                            echo      "<div class='foto-container'>
                                          <img src=".$d_foto_k[$i][$j]." alt='foto dosen' border='5px' class='foto-profil' >
                                          <div class='bottom-center'>".$nama_k[$i][$j]."</div>
                                        </div>
                                      </div>
                                      </a>";
                                    }
      /*                      echo      "<div class='col-75'>
                                        <div id='pAnggaran".[$i]."'> Rp.".$pendana[$i]."</div>
                                      </div>";
      */
                            echo    "</div>";
                            echo    "<button type='submit' class='btn cancel' onclick='$(this).closeForm()'>Close</button>";
                            echo   "</div></div>";
                          }
                        }else {
                          echo "<tr>";
                          echo  "<td class='center'>-</td>";
                          echo  "<td class='center'>-</td>";
                          echo  "<td class='center'>-</td>";
                          echo "<tr>";
                        }
                         ?>
                       </tbody>
                    </table>

                  </div>
                </div>
            </div>
          </main>
      <?php include_once('../include/footer.php'); ?>
        </body>
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
        function previewUrl(location) {
              document.getElementById('preview-web').src = location;
          }
        </script>
      </html>
