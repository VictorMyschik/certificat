(function ($) {
  "use strict";
  var mr_users = parseInt($('#mr_users').text());
  var mr_users_unique = parseInt($('#mr_users_unique').text());
  var mr_bot = parseInt($('#mr_bot').text());
  var mr_bot_unique = parseInt($('#mr_bot_unique').text());

  var mr_max = mr_users + mr_bot;


// const brandPrimary = '#20a8d8'
  const brandSuccess = '#4dbd74';
  const brandInfo = '#63c2de';
  const brandDanger = '#f86c6b';

  function convertHex(hex, opacity)
  {
    hex = hex.replace('#', '');
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    const result = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity / 100 + ')';
    return result
  }

  function random(min, max)
  {
    return Math.floor(Math.random() * (max - min + 1) + min)
  }

  var elements = 10;
  var data1 = [];
  var data2 = [];
  var data3 = [];
  var dats = [];
  var mr_date = new Date();
  for (var i = 0; i <= elements; i++)
  {
    mr_date.setDate(mr_date.getDate() - elements + i);
    dats.push(mr_date.toLocaleDateString());
  }
  ////TODO вставить функцию получения массива из последних дней за месяц, по месяцам и годам

  //Traffic Chart
  var ctx = document.getElementById("trafficChart");
  //ctx.height = 200;
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: dats,
      datasets: [
        {
          label: 'My First dataset',
          backgroundColor: convertHex(brandInfo, 10),
          borderColor: brandInfo,
          pointHoverBackgroundColor: '#fff',
          borderWidth: 2,
          data: data1
        },
        {
          label: 'My Second dataset',
          backgroundColor: 'transparent',
          borderColor: brandSuccess,
          pointHoverBackgroundColor: '#fff',
          borderWidth: 2,
          data: data2
        },
        {
          label: 'My Third dataset',
          backgroundColor: 'transparent',
          borderColor: brandDanger,
          pointHoverBackgroundColor: '#fff',
          borderWidth: 1,
          borderDash: [8, 5],
          data: data3
        }
      ]
    },
    options: {
      //   maintainAspectRatio: true,
      //   legend: {
      //     display: false
      // },
      // scales: {
      //     xAxes: [{
      //       display: false,
      //       categoryPercentage: 1,
      //       barPercentage: 0.5
      //     }],
      //     yAxes: [ {
      //         display: false
      //     } ]
      // }


      maintainAspectRatio: true,
      legend: {
        display: true
      },
      responsive: true,
      scales: {
        xAxes: [{
          gridLines: {
            drawOnChartArea: false
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 5,
            stepSize: Math.ceil(250 / 5),
            max: mr_max
          },
          gridLines: {
            display: true
          }
        }]
      },
      elements: {
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3
        }
      }


    }
  });


})(jQuery);