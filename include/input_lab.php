<div class="input-field col">
  <select id="lab" name="lab" <?=empty($selectedLab) ? 'required' : ''?> >
    <?php
    if(empty($selectedLab)) {
      $selectedLab = '';
      echo '<option selected disabled value="">- Pilih Laboratorium -</option>';
    }

    while ($lab = $arrLab->fetch_object()) {
      echo '<option value='.$lab->id_lab.' '.(($lab->id_lab == $selectedLab) ? 'selected' : '').'>'.$lab->nama_lab.'</option>';
    }
    ?>
  </select>
</div>
