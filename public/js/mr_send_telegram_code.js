function mr_send_telegram_code() {
  let name = $('input[name=Telegram_Login]').val();
  if(name.length < 3)
  {
    $('#errors').text('Введите корректно свой логин').css('color','red');
  }
  else
  {
    $('#errors').text();
    $.post( "/telegram/send/code", { name: "John"} );
  }
}