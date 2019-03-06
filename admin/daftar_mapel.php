<?php

$status = "admin";
$level = "Administrator";

include('../include/function.php');
include_once('../include/sidebar.php');

$arrMapel = getAllRow('mapel');
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('../include/head.php') ?>
    <title></title>
  </head>
  <body>
    <main>
      <div class="row">
        <div class="section col s12 l12">
          <h1 class="judul">Daftar Dosen</h1>
          <table class="responsive-table">
            <?php
            while ($mapel = $arrMapel->fetch_object()) {
              $kode = $mapel->kode;
              $nama = $mapel->nama;
              ?>
              <tbody>

                <tr>
                  <td>
                  <a  href=info_mapel.php?q=<?= $kode ?>>
                    <div class="clicked-list">
                      <?= $nama ?>
                    </div>
                  </a>
                  </td>
                  <td>
                    <div class="center" data-id="<?= $kode ?>" data-class="mapel">
                      <button class="btn waves-effect"  onClick="$(this).TryDelete()">delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            <?php
            }
            ?>
          </table>
        </div>
      </div>
    </main>
    <?php include_once('../include/footer.php'); ?>
  </body>
</html>
