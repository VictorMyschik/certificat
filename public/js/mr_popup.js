function mr_popup(url, form_size) {
  let body = '<div class="modal-dialog modal-'+form_size+'"><div class="modal-content"><div class="modal-body"></div></div></div>';
  $("#mr_modal").html(body).modal("show").find('.modal-body').load(url);
}