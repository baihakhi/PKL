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
          <table class="center"  style="max-width:100%">
            <?php
            while ($dosen = $arrDosen->fetch_object()) {
              $nip = $dosen->nip;
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
                  <td style="width:10%">
                  <a href=edit_dosen.php?q=<?= $nip ?>>
                    <div class="clicked-list center btn waves-effect waves-light">
                      <i class="fa fa-edit fa-2x"> edit</i>
                    </div>
                  </a>
                  </td>
                  <td style="width:10%">
                    <div class="center" data-id="<?= $nip ?>" data-class="dosen">
                      <button class="btn waves-effect waves-light red" onClick="$(this).TryDelete();"><i class="fa fa-trash-o fa-2x"> delete</i></button>
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
