<?php

$status = "admin";
$level = "Administrator";

include('../include/function.php');
include_once('../include/sidebar.php');

$arrDosen = getAllRow('dosen');
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
            while ($dosen = $arrDosen->fetch_object()) {
              $nip = $dosen->NIP;
              $nama = $dosen->nama;
              ?>
              <tbody>

                <tr>
                  <td>
                  <a  href=info_dosen.php?q=<?= $nip ?>>
                    <div class="clicked-list">
                      <?= $nama ?>
                    </div>
                  </a>
                  </td>
                  <td>
                  <a href=edit_dosen.php?q=<?= $nip ?>>
                    <div class="clicked-list center">
                      edit
                    </div>
                  </a>
                  </td>
                  <td>
                    <div class="center" data-id="<?= $nip ?>" data-class="dosen">
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
