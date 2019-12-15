$(function () {
  $("#search").keyup(function () {
    var search = $("#search").val();
    $.ajax({
      type: "POST",
      url: "/search",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {"search": search},
      cache: false,
      success: function (response) {
        console.log(response);
        let text_out = '';
        for (let key in response) {
          text_out += '<div class="mr-bg-founded padding-horizontal border border-dark mr-border-radius-5 "><a class="mr-color-dark-blue" href="/certificate/' + key + '">' + response[key] + '</div>';
        }
        $("#resSearch").html(text_out);
      }
    });
    return false;
  })
});