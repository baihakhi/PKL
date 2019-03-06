$(document).ready(function(){

  $('#import').change(function(){
    $('#form-import').submit();
  });

  $.fn.CheckData = function() {
    var el = this.parent();
    var id = this.parent().attr('data-id');
    $.ajax({
      type: "GET",
      url: "../ajax/delete.php",
      dataType: 'html',
      data: "&id="+id,
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
    this.parent().html(btnDefault);
  };

});
