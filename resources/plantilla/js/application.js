$(function(){
   // captura de pantalla
   // $(window).resize(function(){
      var anchop = $(window).width();
      console.log(anchop);

      if(anchop<=768){
         $("#contenido-enc").addClass("justify-content-between");
      } else{
         $("#contenido-enc").removeClass("justify-content-between");
      }

      if(anchop<=767){
         $("#logo").addClass("justify-content-between");
         $("#SectionCuerpo").removeClass("d-flex");
         $("#cuerpo-contenido").addClass("w-100");
         $("#pagination").removeClass("justify-content-end");
         $("#pagination").addClass("justify-content-center");
      } else{
         $("#logo").removeClass("justify-content-between");
         $("#pagination").removeClass("justify-content-center");
         $("#pagination").addClass("justify-content-end");
      }

      if(anchop<=575){
         $("#acordion").removeClass("justify-content-center");
         $("#acordion").addClass("align-content-start");
      }else{
         $("#acordion").removeClass("align-content-start");
         $("#acordion").addClass("justify-content-center");
      }

      if(anchop<=544){
         $("#select-opciones").removeClass("mr-1 w-25");
         $("#txtbuscar").removeClass("w-50");
         $("#select-opciones").addClass("w-100");
         $("#txtbuscar").addClass("w-100");
      }else{
         $("#select-opciones").removeClass("w-100");
         $("#txtbuscar").removeClass("w-100");
         $("#select-opciones").addClass("mr-1 w-25");
         $("#txtbuscar").addClass("w-50");
      }
   // });

   // MENU RESPONSIVE
   var boton = $('#btnMenu');
   var fondo = $('#fondoEnlace');

   boton.on('click', function(e){
      fondo.toggleClass('active');
      $('nav').toggleClass('active');
      e.preventDefault();
   });

   fondo.on('click', function(e){
      fondo.toggleClass('active');
      $('nav').toggleClass('active');
      e.preventDefault();
   });

   // COLOR ROJO DE LAS LETRAS EN LA TABLA
   // $("table td:nth-child(4):contains('Inactivo')").parents("tr").css("color","#e4605e");

   $("#btnInicio").click(function(){
      $("#flecha_izq").toggleClass("fa-angle-down");
      $("#inicio").toggleClass("mostrarSub");
   });
   
   $("#btnUbicacion").click(function(){
      $("#flecha").toggleClass("fa-angle-down");
   });
   
   $("#btnfacturacion").click(function(){
      $("#flecha1").toggleClass("fa-angle-down");
   });

   $("#btnCartera").click(function(){
      $("#flecha2").toggleClass("fa-angle-down");
   });
   
   // Tabla ordernar tabla
   // $('#tabla').DataTable();  
   // $("#tabla").tablesorter();
   
   // Funcionamiento del tooltip de bootstrap
   $('[data-toggle="tooltip"]').tooltip();
});

