  //Barra del Ventas
  // ctx.fillStyle = 'green';
  // ctx.fillRect = (0, 0, 400, 200);
   var ctx = document.getElementById('Ventas').getContext('2d');
   var charVentas = new Chart(ctx, {
    type: 'bar',
    data:{
       labels: ['Red','Blue','Yellow','Green','Purple','Orange'],
       datasets:[{
         label: 'Servicios más Comprado',
          data:[12,19,3,5,9,11],
          backgroundColor: [
             'rgb(255,99,132)',
             'rgb(54,162,235)',
             'rgb(255,206,86)',
             'rgb(75,192,192)',
             'rgb(153,102,255)',
             'rgb(255,159,64)'
          ],
          borderColor:[
             'rgba(255,99,132,.9)',
             'rgba(54,162,235,.9)',
             'rgba(255,206,86,.9)',
             'rgba(75,192,192,.9)',
            ' rgba(153,102,255,.9)',
             'rgba(255,159,64,.9)'
            ],
          borderWidth: 1
       }]
      },
    options:{
      responsive: true,
      maintainAspectRatio: true,
      // scales: {
      //    yAxes:[{
      //       ticks:{
      //          beginAtZero: true
      //       }
      //    }],
      //    xAxes:[{
      //       ticks:{
      //          beginAtZero: true
      //       }
      //    }]
      // }
    }
});

   //piechart
   var ctx = document.getElementById('Vendedores').getContext('2d');
   var charVentas = new Chart(ctx, {
  type: 'pie',
  data:{
     labels: ['Dovie Schumm','Tyrell Pollich','Stan Crooks Jr.','Gwendolyn Toy','Elisha Considine'],
     datasets:[{
        label: 'Servicios más Comprado',
        data:[12,19,5,9,11],
        backgroundColor: [
           'rgb(255,99,132)',
           'rgb(54,162,235)',
           'rgb(75,192,192)',
           'rgb(153,102,255)',
           'rgb(255,159,64)'
        ],
        borderColor:[
           'rgba(255,100,132,1)',
           'rgba(54,170,235,1)',
           'rgba(75,200,192,1)',
           ' rgba(153,110,255,1)',
           'rgba(255,170,64,1)'
        ],
      //   borderWidth: 1
     }]
  },
  options:{
     responsive: true,
     maintainAspectRatio: true,
   //   scales:{
   //    yAxes: [{
   //       ticks: {
   //          beginAtZero: true
   //       }
   //    }],
   //    xAxes: [{
   //       ticks: {
   //          beginAtZero: true
   //       }
   //    }]
   //   },
     title:{
        display: true,
        position: 'bottom',
        text: 'Contratos Efectivos del Mes'
     }
  }
});
        // lineas Servicios
        
var ctx = document.getElementById('Servicios').getContext('2d');
var chart = new Chart(ctx, {
   type: 'line',
   data :{
      labels: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio'],
      datasets: [{
         label: 'Ventas del año',
         backgroundColor: '#d62b2be7',
         borderColor: 'rgb(255,99,132)',
         data: [25,46,90,60,45,80,30]
      }]
   },
   options: {
      responsive: true,
      maintainAspectRatio: true,
      // scales: {
      //    yAxes:[{
      //       ticks:{
      //          beginAtZero: true
      //       }
      //    }],
      //    xAxes:[{
      //       ticks:{
      //          beginAtZero: true
      //       }
      //    }]
      // },
      animation: {
         easing: 'easeInCirc',
         // Onprogress: function(animation) {
         //    progress.value = animation.animationObject.currentStep /  animation.animationObject.numSteps;
         // }
      }
   }
});