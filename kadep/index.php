<?php
session_start();


include('../include/function.php');
include('../include/sidebar.php');

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
            <tbody class="cornered">
            <?php
            while ($dosen = $arrDosen->fetch_object()) {
              $nip = $dosen->nip;
              $namad = $dosen->nama;
              ?>

                <tr>
                  <td class="clickable-row" data-href="info_dosen.php?q=<?= $nip ?>"><?= $namad ?>
                  </td>
                  <td style="width:10%">
                    <a href=lihat_karya.php?q=<?= $nip ?>>
                    <span class="clicked-list center btn waves-effect waves-light">
                      <i class="fa fa-edit fa-2x"> lihat kegiatan</i>
                    </span>
                  </td>
                </a>
                </tr>
            <?php
            }
            ?>
          </tbody>
          </table>
        </div>
      </div>
    </main>
    <?php include_once('../include/footer.php'); ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
    </script>

  </body>
</html>
