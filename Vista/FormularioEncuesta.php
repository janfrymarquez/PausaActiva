  <?php

  session_start();

  if (!isset($_SESSION['userlog'])) {
      header('location:login.php');
  }

  require '../Modelo/Conexion.php';

  $Conexion = new Conexion();
  $base = $Conexion->Conexion();

  ?>


  <!DOCTYPE html>


  <html>
      <head>
          <meta charset="utf-8">
          <link rel="icon" href="img/favicon.ico">
          <meta name="viewport" content="width=device-width, initial-scale=1">

          <title>Analytic Soluction</title>




      </head>
      <?php
  require 'header.php';
  ?>
      <body>

          <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
              <div class="row">
                  <ol class="breadcrumb">
                      <li><a href="../index.php">
                              <em class="fa fa-home"></em>
                          </a></li>
                      <li class="active">Crear Encuesta</li>
                  </ol>
              </div><!--/.row-->


              <form id= "formEncuesta" >
                <!--  <form id= "formEncuesta"  <action="../Controlador/GuardarEncuesta.php" method="POST">-->
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="panel panel-default">
                              <div class="panel-heading"><input type="text" class="NombreEncuesta col-lg-12" name="NombreEncuesta" id="NombreEncuesta" placeholder="Escriba el nombre de la encuesta aqui" onfocusout = "ComprobaNombreEncuesta()">
                              </div>
                              <div class="panel-body">


                              <div class="form-group col-md-6">
                                      <label>Tipo de Ecnuesta</label>

                                      <select class="form-control" name="TipoEncuesta" id="TiposEncuestaID" >
                                          <option disabled selected value> -- Elija una opcion  -- </option>

                                          <?php
  $sql = 'SELECT * FROM  tbl_tipo_encuesta';
  $resultado = $base->prepare($sql);
  $resultado->execute();

  $numero_registro = $resultado->rowCount();

  if (0 !== $numero_registro) {
      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'.$registro['IdTipoEncuesta'].'">'.$registro['DescTipoEncuesta'].'</option>';
      }
  } else {
      echo '<option value=""> Tipo de encuesta no disponibles </option>';
  }
  ?>

                                      </select>    <br>

                                  </div>


                                  <div class="form-group col-md-6" id="DivSubTipoEncuenta">
                                      <label> Sub Tipo de Encuesta </label>
                                      <select class="form-control" id= "SubTipoEncuenta">
                                          <option disabled selected value> -- Seleciones un tipo de encuesta -- </option>

                                      </select>    <br>
                                  </div>



                                  <div  class = "PreguntaBlock">

                                      <div id="row1">

                                          <div class= "form-group col-md-8">


                                              <input type="text"  id= "1" name="Pregunta[]" placeholder="Introduzca la pregunta aqui" class="form-control Pregunta">

                                          </div>

                                          <div class ="DivTipoDeRepuesta form-group col-md-3">

                                              <select  class="my-select form-control TipoDeRepuesta_1"  id="1" name="TipoDeRepuesta">
                                                  <option disabled selected value> --Elija una opcion-- </option>

                                                  <?php
  $sql = 'SELECT * FROM  tbl_conf_repuesta';
  $resultado = $base->prepare($sql);
  $resultado->execute();
  $numero_registro = $resultado->rowCount();

  if (0 !== $numero_registro) {
      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'.$registro['IdConfiRepuesta'].'" data-img-src="'.$registro['IconoConfiRepuesta'].'">'.$registro['DescripConfiRepuesta'].'</option>';
      }
  } else {
      echo '<option value="">  Tipo de repuesta no disponibles </option>';
  }
  ?>
                                              </select>

                                          </div>

                                          <div class="form-group col-md-12 " id="Rep1"> </div>

                                      </div>


                              </div>

                          </div>

                          <button type="button" name="add" id="add" class="btn btn-success agragarPreguntaBtn"> Agregar Pregunta </button>
                           <button type="button"   id="button" class="btn btn-info pull-right enviarFormBtn" onclick="GuardarEncuesta()">Crear Encuesta</button>

                      </div>

                  </div>
              </form>



              <script src="js/ImageSelect.jquery.js"></script>

              <script>

                function GuardarEncuesta(){

                  var result = [];

                  $("#formEncuesta :input.Pregunta").each(function(){

                    var IdInput = $.trim($(this).attr('id'));// This is the jquery object of the input, do what you will
                    var ValorInput = $.trim($(this).val());// This is the jquery object of the input, do what you will
                    var TipoResp = $.trim($('.TipoDeRepuesta_'+IdInput+'').val());
                    var NombreEncuesta = $.trim($('.NombreEncuesta').val());
                    var TiposEncuestaID = $.trim($('#TiposEncuestaID').val());
                    var SubTipoEncuenta = $.trim($('#SubTipoEncuenta').val());



                   result.push({
                     Id_Pregunta:IdInput,
                     NombreEcnuesta: NombreEncuesta,
                     TiposEncuesta: TiposEncuestaID,
                     SubTipoEncuenta: SubTipoEncuenta,
                     Pregunta: ValorInput,
                     Respuesta: [],
                     TipoRespuesta: TipoResp
                   });
                 });



                 $.each(result, function( index, value){
                   $('#formEncuesta :input.Respuesta_'+value.Id_Pregunta+'').each(function(){

                     value.Respuesta.push($.trim(
                       $(this).val())

                     );

                   });

                 });

                    var DataJson = JSON.stringify(result);

                    swal({
                      title: "Guardar Encuesta",
                      text: "Ok para guardar la EncuestaArray",
                      type: "info",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      showLoaderOnConfirm: true
                    }, function () {

                      setTimeout(function () {
                        swal("Encuesta Guardada!");
                      }, 2300);

                      $.ajax({

                        type: 'POST',
                        url: '../Controlador/GuardarEditarEncuesta.php',
                        data: 'DataJson=' +DataJson,
                        success: function(html){
                          console.log(html);
                          window.location.href = '../index.php';
                        }

                      });

                    });
              }

              </script>


              <script>  // Script para agregar nuevas preguntas
              $(document).ready(function(){
             var i =2, j=1;
                   $('#add').click(function(){



                        $('.PreguntaBlock').append(' <div id ="row'+i+'"> <div   class= "form-group col-md-8"><input type="text" id="'+i+'" name="Pregunta[]" placeholder="Introduzca la pregunta aqui" class="form-control Pregunta"></div> <div class ="DivTipoDeRepuesta form-group col-md-3"><select  class="my-select form-control TipoDeRepuesta_'+i+'" id="'+i+'" name="TipoDeRepuesta"><option disabled selected value> --Elija una opcion-- </option><?php  $sql = 'SELECT * FROM  tbl_conf_repuesta'; $resultado = $base->prepare($sql);
  $resultado->execute();
  $numero_registro = $resultado->rowCount();
  if (0 !== $numero_registro) {
      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
          echo '<option value="'.$registro['IdConfiRepuesta'].'" data-img-src="'.$registro['IconoConfiRepuesta'].'">'.$registro['DescripConfiRepuesta'].'</option>';
      }
  } else {
      echo '<option value="">  Tipo de repuesta no disponibles </option>';
  }
  ?></select></div><div class ="form-group col-md-1"><button type="button" name="remove" id="'+i+'"  class="btn btn-danger btn_remove"><i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></button></div><div class="form-group col-md-12 "  class = "Repuesta" id="Rep'+i+'"> </div> </div>');

             i++;


                         $(".my-select").chosen({width:"100%"});
                   });
                   $(document).on('click', '.btn_remove', function(){
                        var button_id = $(this).attr("id");
                        $('#row'+button_id+'').remove();
                   });


             $(document).on('change', '.my-select', function(){

             var resp_id = $(this).attr("id");
              var TipoDeRepuestaID = $(this).val();

             switch (TipoDeRepuestaID) {
                 case '1':
                 repuesta = ' <i id="fa fa-circle-o" class="fa fa-circle-o fa-lg iconos'+resp_id+'" aria-hidden="true "></i>&nbsp;<input type="text" placeholder="Escriba una opcion" autocomolete="off" name="Opcion2[]" id="'+resp_id+'" class="RespComentario Respuesta_'+resp_id+'"> <span> </span><button type="button" name="addCase2Opcion" id="'+resp_id+'"  class="btn_addOption btn btn-success">+</button>';

                   break;
                 case '2':

                 repuesta = ' <i id="fa fa-square-o" class="fa fa-square-o fa-lg iconos'+resp_id+'" aria-hidden="true "></i>&nbsp;<input type="text" placeholder="Escriba una opcion" autocomolete="off" name="Opcion2[]" id="'+resp_id+'" class="RespComentario Respuesta_'+resp_id+'"> <span> </span><button type="button" name="addCase2Opcion" id="'+resp_id+'"  class="btn_addOption btn btn-success">+</button>';

                     break;
                 case '3':
                      repuesta= '<textarea  autocomolete="off" name="comentarios" id="'+resp_id+'" class="Respuesta" rows="4" cols="60"></textarea>';
                     break;
                 case '4':
                 repuesta = '<div  onmouseover="showdiv(event,'+resp_id+');"onMouseOut="hiddenDiv()" style="display:table; font-weight: bold;"">Ejemplo:<br> </div><p>Del: <input type="number" value="1"  class="Respuesta_'+resp_id+'" name="ValMinimo[]" id="ValMinimo_'+resp_id+'">   Al: <input type="number" value="10" class="Respuesta_'+resp_id+'" name="valMaximo[]" id="valMaximo_'+resp_id+'"></p><div id="flotante"></div><br>';



                     break;
                 case '5':
                     repuesta = '<div id="apDiv1"><table width="100%" border="0"><tr><?php $sql = 'SELECT * FROM  tbl_repuesta_imagen';
  $resultado = $base->prepare($sql);
  $resultado->execute();
  $numero_registro = $resultado->rowCount();
  if (0 !== $numero_registro) {
      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
          echo '<td><img id="ImagenRepuesta" src="'.$registro['ImagenRuta'].'"></td><td width="20"></td>';
      }
  } else {
      echo '<option value="">  Tipo de repuesta no disponibles </option>';
  }
  ?></select></tr></table></div>';
                     break;
                 case '6':
                      repuesta = '<ul class="fa-ul"><?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                      $resultado = $base->prepare($sql);
                      $resultado->execute([':Codigo' => 6]);
                      $numero_registro = $resultado->rowCount();
                      if (0 !== $numero_registro) {
                          while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                              //echo '<td><img id="ImagenRepuesta" src="'.$registro['ImagenRuta'].'"></td><td width="20"></td>';
                              $RepuestaArray = explode(',', $registro['DescripConfiRepuesta']);

                              foreach ($RepuestaArray as $obj) {
                                  echo '<li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;'.$obj.'</li>';
                              }
                          }
                      }?></ul>';
                     break;
                 case  '7':
                 repuesta = '<ul class="fa-ul"><?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                 $resultado = $base->prepare($sql);
                 $resultado->execute([':Codigo' => 7]);
                 $numero_registro = $resultado->rowCount();
                 if (0 !== $numero_registro) {
                     while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                         //echo '<td><img id="ImagenRepuesta" src="'.$registro['ImagenRuta'].'"></td><td width="20"></td>';
                         $RepuestaArray = explode(',', $registro['DescripConfiRepuesta']);

                         foreach ($RepuestaArray as $obj) {
                             echo '<li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;'.$obj.'</li>';
                         }
                     }
                 }?></ul>';

                     break;


                     case  '8':  // O
                     repuesta = '<ul class="fa-ul"><?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                     $resultado = $base->prepare($sql);
                     $resultado->execute([':Codigo' => 8]);
                     $numero_registro = $resultado->rowCount();
                     if (0 !== $numero_registro) {
                         while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                             $RepuestaArray = explode('/', $registro['DescripConfiRepuesta']);

                             foreach ($RepuestaArray as $obj) {
                                 echo '<li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;'.$obj.'</li>';
                             }
                         }
                     }?></ul>';
                     break;



             }

             $('#Rep'+resp_id+'').html(repuesta);

               });

               $(document).on('click', '.btn_addOption', function(){

             var case1_id = $(this).attr("id");

       var icono = $('.iconos'+case1_id+'').attr("id");

  if (icono === "fa fa-circle-o"){
  var opcion = "Opcion1[]";
  }else {
    var opcion= "Opcion2[]";
  }



             j++;
             $('#Rep'+case1_id+'').append(' <div id ="BlocResp'+case1_id+''+"A"+''+j+'"><div id="'+j+'"  class ="case'+case1_id+'  "><i class="'+icono+' fa-lg" aria-hidden="true"></i> <input type="text" autocomolete="off" name="'+opcion+'" placeholder="Escriba una opcion" id="'+case1_id+'" class="RespComentario Respuesta_'+case1_id+'"> <span> </span><button type="button" name="remove" id="'+j+'"  class="btn_removerOption'+case1_id+''+"r"+''+j+' btn btn-danger"><i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></button> </div> </div>');



                         $('.btn_removerOption'+case1_id+''+"r"+''+j+'').hide();


                         $('.case'+case1_id+'').mouseover (function() {

                              var remo_id = $(this).attr("id");

                              $('.btn_removerOption'+case1_id+''+"r"+''+remo_id+'').show();

                                 $('.btn_removerOption'+case1_id+''+"r"+''+remo_id+'').click(function(){

                                     $('#BlocResp'+case1_id+''+"A"+''+remo_id+'').remove();

                                  });
                         });
                                   $('.case'+case1_id+'').mouseleave (function() {

                                       var remo_id = $(this).attr("id");
                                   $('.btn_removerOption'+case1_id+''+"r"+''+remo_id+'').hide();

                                 });


             });


              });   //Fin script para agregar nuevas preguntas
              </script>


              <script>//Script para cargar los suptipos de encuesta


                  $(document).ready(function() {

                  $("#TiposEncuestaID").on('change', function(){

                      var TiposEncuestaID = $(this).val();


                  if (TiposEncuestaID){

                      $.ajax({
                         type: 'POST',
                         url: '../Controlador/EncuestaControlador.php',
                         data: 'TiposEncuestaID=' +TiposEncuestaID,
                         success: function(html){


                               if(html== 'NoDisponible'){
                                $('#DivSubTipoEncuenta').hide();
                               }

                               else {
                                  $('#DivSubTipoEncuenta').show();
                               $('#SubTipoEncuenta').html(html);
                              $('#SubTipoEncuenta').attr('name', 'SubTipoEncuenta');
                               }
                          }

                          });


              }else {
                  $('#SubTipoEncuenta').html('option value=""> --Seleciones un tipo de encuentas-- </option>')
              }

              });

              });


              </script>

              <script>
                  /**
                  * Funcion que muestra el div en la posicion del mouse
                  */
                  function showdiv(event,ID)
                  {

              var ValorMini= $('#ValMinimo_'+ID+'').val();
              var ValorMaxi= $('#valMaximo_'+ID+'').val();

                      document.getElementById('flotante').innerHTML="¿Del "+ValorMini+" al "+ValorMaxi+" que tanto ....?";

                      document.getElementById('flotante').style.display='block';
                      return;
                  }

                  function hiddenDiv()
                  {
                      document.getElementById('flotante').style.display='none';
                  }

              </script>

              <script type="text/javascript">
                      $(document).ready(function(){
              $(".select2").select2();

              $('#DivSubTipoEncuenta').hide();  });

              </script>


              <script>
               $(".my-select").chosen({width:"100%"});
              </script>



      </body>
  </html>
