$('#mr-form').submit(function (e)
{
  let $form = $(this);
  let mr_data = $form.serialize();
  let arr = mr_data.split('&');
  for (let name in arr)
  {
    $("input[name=" + arr[name].split('=')[0] + "]").css({"border-color": "",});
    $("#" + arr[name].split('=')[0]).text('').removeClass('margin-l-10');
  }

  $.ajax({
    type: $form.attr('method'),
    url: $form.attr('action'),
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data: mr_data
  }).done(function (response)
    {
      if (response)
      {
        for (let key in response)
        {
          $("input[name=" + key + "]").css({"border-color": "red",});
          $("#" + key).text(response[key]).css({"color": "red",}).addClass('margin-l-10');
        }
      } else
      {

        $("#mr_modal").modal("hide");

        window.location.reload();
      }
    }
  ).fail(function (response)
  {
    console.log(response)
  });
  e.preventDefault();
});
