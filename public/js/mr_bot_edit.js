function mr_edit(id) {
  let mess = prompt('Введите примечание');
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    enctype: 'multipart/form-data',
    type: 'post',
    url: '/admin/hardware/bot/add/' + id+'/'+mess,
    data: {'data': mess},
    contentType: false,
    processData: false,
    success: function (result) {
    }
  });
}