
<div class="bg-modal" id="bg-modal">
  <div class="modal-contents">
    <div class="closeX">+</div>
      <table class="responsive-table">
        <?php
        $arrKegiatan = getKegiatan($kodeKegiatan);
        //$arrKegiatan = getSpesificKegiatan($kodeKegiatan);
        while ($kegiatan = $arrKegiatan->fetch_object()) {
          $id = $kegiatan->id_kegiatan;
          $judul = $kegiatan->judul;
          $tempat = $kegiatan->tempat;
          $waktu = $kegiatan->waktu;
          ?>
          <tbody>

            <tr>
              <a  href=info_kegiatan.php?q=<?= $id ?>>
              <td>
                <div class="clicked-list">
                  <?= $judul ?>
                </div>
              </td>
              <td>
                <div class="clicked-list center">
                  <?= $tempat ?>
                </div>
              </td>
              <td>
                <div class="clicked-list center">
                  <?= $waktu ?>
                </div>
              </td>
            </a>
            </tr>
          </tbody>
        <?php
        }
        ?>
      </table>
      <div class="kanan-align" style="margin-right:13%">
        <button type="submit" class="btn waves-effect waves-light red-btn" name="konfirmasi">BUKAN</button>
      </div>
    </div>
</div>
<?php
  if(isset($_POST['konfirmasi'])){
    if (tambahKegiatan($array1) && tambahKegiatanDosen($array2)) {
      $notif = 1;
//        header('Location: info_dosen.php?q='$nip)
    }else {
      $notif = 2;
    }
  }else {
    $notif = 4;
  }
 ?>
