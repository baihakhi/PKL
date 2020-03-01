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

                <tr class="clickable-row" data-href="info_dosen.php?q=<?= $nip ?>">
                  <td><?= $namad ?>
                  </td>
                  <td style="width:10%">
                    <a href=edit_dosen.php?q=<?= $nip ?>>
                    <span class="clicked-list center btn waves-effect waves-light">
                      <i class="fa fa-edit fa-2x"> edit</i>
                    </span>
                  </td>
                  <td style="width:15%">
                    <span class="center" data-id="<?= $nip ?>" data-class="dosen">
                      <button class="btn btn-danger clicked-list" onClick="$(this).TryDelete();"><i class="fa fa-trash-o fa-2x"> delete</i></button>
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
