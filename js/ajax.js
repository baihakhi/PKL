$(document).ready(function(){

  $('#import').change(function(){
    $('#form-import').submit();
  });

  var btnDefault = '<button class="btn waves-effect waves-light red" onClick="$(this).TryDelete();"><i class="material-icons">delete</i></button>';
  var btnYes = '<button class="btn waves-effect waves-light yellow" onClick="$(this).DoDelete();" style="margin-right:5px;"><i class="material-icons black-text">check_circle</i></button>';
  var btnNo = '<button class="btn waves-effect waves-light green" onClick="$(this).CancelDelete();"><i class="material-icons black-text">cancel</i></button>';
  $.fn.TryDelete = function() {
    this.parent().html(btnYes+btnNo);
  };
  $.fn.DoDelete = function() {
    var el = this.parent().parent().parent();
    var id = this.parent().attr('data-id');
    var clas = this.parent().attr('data-class');
    $.ajax({
      type: "POST",
      url: "../ajax/delete.php",
      dataType: 'html',
      data: "&id="+id+
       "&class="+clas,
      success: function(msg){
        if (msg == true) {
          el.remove();
          notie.alert('success', 'Data berhasil dihapus', 2);
        }
        else {
          notie.alert('error', 'Data gagal dihapus', 2);
        }
      },

    });
  };
  $.fn.CancelDelete = function() {
    this.parent().append(btnDefault);
  };

});
