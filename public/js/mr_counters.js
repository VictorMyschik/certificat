function counters()
{
  let users = $('#users');
  let currentNumber = users.text();
  let user_max = users.attr('data-count');

  $({numberValue: currentNumber}).animate({numberValue: user_max}, {
    duration: 3000,
    easing: 'linear',
    step: function ()
    {
      $('#users').text(Math.ceil(this.numberValue));
    }
  });
}