<div class="input-field col s12">
  <select id="listDosen" name="listDosen[]" multiple="multiple" <?=empty($selectedDosen) ? 'required' : ''?> ">
    <?php
      $selectedDosen = '';

    while ($lDosen = $arrListDosen->fetch_object()) {
      echo '<option value='.$lDosen->NIP.' '.(($lDosen->NIP == $selectedDosen) ? 'selected' : '').'>'.$lDosen->nama.'</option>';
    }
    ?>
  </select>
</div>
