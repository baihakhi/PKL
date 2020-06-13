$(document).ready(function(){

  $('#import').change(function(){
    $('#form-import').submit();
  });
//===========DELETE FUNTION
  var btnDefault = '<button class="btn btn-danger clicked-list" onClick="$(this).TryDelete();"><i class="fa fa-trash-o fa-2x"> hapus</i></button>';
  var btnDefaultIkon = '<button class="btn btn-danger clicked-list" style="width:fit-content" onClick="$(this).TryDelete2();"><i class="fa fa-trash-o fa-2x"></i></button>';
  var btnYes = '<button class="clicked-list btn btn-danger" onClick="$(this).DoDelete();" style="margin-right:5px;width:fit-content;"><i class="material-icons fa fa-check-square-o black-text cancel"></i></button>';
  var btnNo = '<button class="clicked-list btn waves-effect btn-warning" onClick="$(this).CancelDelete();" style="width:fit-content;"><i class="material-icons fa fa-times-circle black-text"></i></button>';
  var btnNo2 = '<button class="clicked-list btn waves-effect btn-warning" onClick="$(this).CancelDelete2();" style="width:fit-content;"><i class="material-icons fa fa-times-circle black-text"></i></button>';

  $.fn.TryDelete = function() {
    this.parent().html(btnYes+btnNo);
  };

  $.fn.TryDelete2 = function() {
    this.parent().html(btnYes+btnNo2);
  };

  $.fn.DoDelete = function() {
    var el = this.parent().parent().parent();
    var id = this.parent().attr('data-id');
    var clas = this.parent().attr('data-class');
    if (clas == 'mapel') {
      var parentId = this.parents("tr").attr("Id");
      var subClas  = "mengampu";
      $.ajax({
        type: "POST",
        url: "../ajax/delete.php",
        dataType: 'html',
        data: "&id="+parentId+
         "&class="+subClas,
        success: function(msg){
          if (msg == true) {
          }
          else {
          }
        },

      });
    }
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
    this.parent().html(btnDefault);
  };

  $.fn.CancelDelete2 = function() {
    this.parent().html(btnDefaultIkon);
  };

//===========EDIT DOSEN FUNTION
var btnEditYes = '<button class="clicked-list btn waves-effect" onClick="$(this).DoEdit();" style="width:fit-content;"><i class="material-icons fa fa-check black-text cancel"></i></button>';
var btnEditNo  = '<button class="clicked-list btn waves-effect btn-warning" onClick="$(this).CancelEdit();" style="width:fit-content;"><i class="material-icons fa fa-close black-text"></i></button>';
var btnEdit    = '<button class="clicked-list btn btn-warning mini btn clicked-list waves-effect waves-light" onClick="$(this).TryEdit();" style="width:fit-content"><i class="fa fa-edit fa-2x"></i></button>';

$.fn.TryEdit = function() {
  var parentId = this.parents("tr").attr("Id");
  $('select[name='+parentId+']')[0].selectize.enable();
  $('select[name='+parentId+']')[1].selectize.enable();
  this.parent().html(btnEditYes+btnEditNo);
  //$("#extra").append( "<strong>" + parentId + "</strong>" );
};

$.fn.CancelEdit = function() {
  var parentId = this.parents("tr").attr("Id");
  $('select[name='+parentId+']')[0].selectize.disable();
  $('select[name='+parentId+']')[1].selectize.disable();
  this.parent().html(btnEdit);
};

$.fn.DoEdit = function() {
  var parentId = this.parents("tr").attr("Id");
  var valueEl = this.parents("tr").find("select");
  var nip  = Array.prototype.map.call(valueEl, function(node) {
    var out = node.value;
    return out;
  });

  $.ajax({
    type: "POST",
    url: "../ajax/edit_data_table.php",
    dataType: 'html',
    data: "&id="+parentId+
      "&nip1="+nip[0]+
     "&nip2="+nip[1],
    success: function(msg){
      if (msg == true) {
        notie.alert('success', 'Data berhasil di-ubah', 1);
      }
      else {
        notie.alert('error', 'Data gagal di-ubah', 2);
      }
      console.log(msg);
    },

  });

    //$("#extra").append( "<strong>" + nip[0] + parentId + nip[1] +"</strong>" );
    //console.log(valueEl);
  $('select[name='+parentId+']')[0].selectize.disable();
  $('select[name='+parentId+']')[1].selectize.disable();
  this.parent().html(btnEdit);
};

});
