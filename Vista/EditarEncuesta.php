
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
        <li class="active">Editar Encuesta</li>
      </ol>
    </div><!--/.row-->



    <?php
    $Id = $_GET['id'];
    $IdTipoEncuesta = '';
    $SubTipoEncuenta = '';
    $sql = 'SELECT * FROM  tbl_encuesta_cabecera WHERE IdEncuestaCabecera = :Id';
    $resultados = $base->prepare($sql);
    $resultados->execute([':Id' => $Id]);
    $numero_registro = $resultados->rowCount();
    if (0 !== $numero_registro) {
        $registros = $resultados->fetch(PDO::FETCH_ASSOC);
        $IdTipoEncuesta = $registros['TiposEncuesta'];
        $SubTipoEncuenta = $registros['SubTipoEncuenta'];
    }
    $resultados->closeCursor();

    ?>


    <form id= "formEncuesta" >
      <div class="panel panel-default">

        <div class="panel-heading"><input type="text" class="NombreEncuesta col-lg-12" name="NombreEncuesta" id="<?php echo $registros['IdEncuestaCabecera']; ?>"  value =" <?php echo $registros['NombreEncuesta']; ?>">
        </div>

        <div class="BlockTipoEncuesta">
          <div class="form-group col-md-6">
            <label>Tipo de Ecnuesta</label>

            <select class="form-control" name="TipoEncuesta" id="TiposEncuestaID" >


              <?php
              $sql = 'SELECT * FROM tbl_tipo_encuesta WHERE IdTipoEncuesta = :ID LIMIT 1';
              $resultado = $base->prepare($sql);
              $resultado->execute([':ID' => $IdTipoEncuesta]);

              $numero_registro = $resultado->rowCount();

              if (0 !== $numero_registro) {
                  while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                      echo '<option  selected  value="'.$registro['IdTipoEncuesta'].'">'.$registro['DescTipoEncuesta'].'</option>';
                  }
              } else {
                  echo '<option> Tipo de encuesta no disponibles </option>';
              }
              $resultado->closeCursor();

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
              $resultado->closeCursor();
              ?>
            </select>
          </div>


          <div class="form-group col-md-6" id="DivSubTipoEncuenta">
            <label> Sub Tipo de Encuesta </label>
            <select class="form-control" id= "SubTipoEncuenta">

              <?php
              if ('' !== $SubTipoEncuenta) {
                  $sql = 'SELECT * FROM  tbl_sub_encuesta WHERE IdSubTipoEncuesta = :ID LIMIT 1';
                  $resultado = $base->prepare($sql);
                  $resultado->execute([':ID' => $SubTipoEncuenta]);

                  $numero_registro = $resultado->rowCount();

                  if (0 !== $numero_registro) {
                      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option  selected  value="'.$registro['IdSubTipoEncuesta'].'">'.$registro['SubTipoEncuesta'].'</option>';
                      }
                  } else {
                      echo '<option value=""> Tipo de encuesta no disponibles </option>';
                  }
                  $resultado->closeCursor();

                  $sql = 'SELECT * FROM  tbl_sub_encuesta';
                  $resultado = $base->prepare($sql);
                  $resultado->execute();

                  $numero_registro = $resultado->rowCount();

                  if (0 !== $numero_registro) {
                      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="'.$registro['IdSubTipoEncuesta'].'">'.$registro['SubTipoEncuesta'].'</option>';
                      }
                  } else {
                      echo '<option value=""> Tipo de encuesta no disponibles </option>';
                  }
                  $resultado->closeCursor();
                  echo '</select></div>';
              } else {
                  echo '</select></div>';
                  echo '<script>';
                  echo '$("#DivSubTipoEncuenta").hide(); ';
                  echo '</script>';
              }
              ?>

            </div>



            <div class= "PreguntaBlock">

              <?php

              $sql = 'SELECT * FROM  tbl_encuesta_detalle WHERE IdEncuesta = :IdEncuesta ';
              $resultado = $base->prepare($sql);
              $resultado->execute([':IdEncuesta' => $Id]);
              $registros = $resultado->fetchAll(PDO::FETCH_OBJ);
              $contador = 1;
              foreach ($registros as $obj): ?>

              <div class="right" id="row<?php echo $obj->IdEncuestaDetalle; ?>">

                <div class="preguntaCabecera">
                  <div id="<?php echo $contador; ?>" class= "form-group left NumeroPregunta<?php echo $obj->IdEncuestaDetalle; ?>">
                    <h6><?php echo $contador; ?></h6>
                  </div>


                  <div class= "form-group col-md-7">
                    <input type="text"  id="<?php echo $obj->IdEncuestaDetalle; ?>" name="Pregunta[]" value ="<?php echo $obj->Pregunta; ?>"  class="form-control Pregunta span8">
                  </div>

                  <div class ="DivTipoDeRepuesta form-group col-md-3">

                    <select  class="my-select form-control TipoDeRepuesta_<?php echo $obj->IdEncuestaDetalle; ?>"  id="<?php echo $obj->IdEncuestaDetalle; ?>" name="TipoDeRepuesta">
                      <?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :ID LIMIT 1';
                      $resultado = $base->prepare($sql);
                      $resultado->execute([':ID' => $obj->TipoRepuesta]);
                      $numero_registro = $resultado->rowCount();

                      if (0 !== $numero_registro) {
                          while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                              echo '<option selected value="'.$registro['IdConfiRepuesta'].'" data-iconurl="'.$registro['IconoConfiRepuesta'].'">'.$registro['DescripConfiRepuesta'].'</option>';
                          }
                      } else {
                          echo '<option value=""> Tipo de encuesta no disponibles </option>';
                      }
                      $resultado->closeCursor();

                      $sql = 'SELECT * FROM  tbl_conf_repuesta';
                      $resultado = $base->prepare($sql);
                      $resultado->execute();

                      $numero_registro = $resultado->rowCount();

                      if (0 !== $numero_registro) {
                          while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                              echo '<option value="'.$registro['IdConfiRepuesta'].'" data-iconurl="'.$registro['IconoConfiRepuesta'].'">'.$registro['DescripConfiRepuesta'].'</option>';
                          }
                      } else {
                          echo '<option value=""> Tipo de encuesta no disponibles </option>';
                      }
                      $resultado->closeCursor();

                      ?>

                    </select>

                  </div>
                  <div class ="form-group col-md-1"><button type="button" name="remove" id="<?php echo $obj->IdEncuestaDetalle; ?>"  class="btn btn-danger btn_remove"><i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></button></div>
                </div>
                <div class="form-group col-md-11 DivOpciones" id="Rep<?php echo $obj->IdEncuestaDetalle; ?>">
                  <?php
                  $Repuesta = explode(',', $obj->Repuesta);
                  $tipoRepuesta = $obj->TipoRepuesta;
                  foreach ($Repuesta as $objRepuesta) {
                      switch ($tipoRepuesta) {
                      case '1':
                      echo ' <i id="fa fa-square-o" class="fa fa-circle-o fa-lg iconos"'.$obj->IdEncuestaDetalle.'" aria-hidden="true "></i>&nbsp;<input type="text" value="'.$objRepuesta.'" autocomolete="off" name="Opcion2[]" id="'.$obj->IdEncuestaDetalle.'" class="RespComentario Respuesta_'.$obj->IdEncuestaDetalle.'"><br>';

                      break;
                      case '2':

                      echo '<i id="fa fa-square-o" class="fa fa-square-o fa-lg iconos"'.$obj->IdEncuestaDetalle.'" aria-hidden="true "></i>&nbsp;<input type="text" value="'.$objRepuesta.'" autocomolete="off" name="Opcion2[]" id="'.$obj->IdEncuestaDetalle.'" class="RespComentario Respuesta_'.$obj->IdEncuestaDetalle.'"><br>';

                      break;
                      case '3':
                      echo '<textarea  autocomolete="off" name="comentarios" id="'.$obj->IdEncuestaDetalle.'" class="Respuesta_'.$obj->IdEncuestaDetalle.'" rows="4" cols="60"></textarea>';

                      break;
                      case '4':

                      break;
                      case '5':
                      echo '<div id="apDiv1"><table width="100%" border="0"><tr>';
                      $sql = 'SELECT * FROM  tbl_repuesta_imagen';
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
                      echo '</select></tr></table></div>';

                      break;
                      case '6':
                      case '7':
                      case '8':
                      echo '<ul class="fa-ul">';
                      echo '<li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;'.$objRepuesta.'</li></ul>';

                      break;
                    }
                  }
                  ?>
                </div> <!--Campo de Repuesta-->


              </div> <!-- Numero de pregunta-->
              <?php
              ++$contador; endforeach; ?>


            </div> <!--Block de Pregunta-->
            <?php $lastArray = array_pop($registros);
            $lastId = $lastArray->IdEncuestaDetalle;
            ?>





            <button type="button" name="add" id="<?php echo $lastId; ?>" class="btn btn-success add"> Agregar Pregunta </button>
            <button type="button"   id="button" class="btn btn-info pull-right enviarFormBtn" onclick="GuardarEncuesta()">Guardar Cambios</button>



          </div><!--panel default-->




        </form>













        <script>


        function GuardarEncuesta(){

          var result = [];
          var nuevoResultado=[];

          $("#formEncuesta :input.Pregunta").each(function(){

            if ($(this).hasClass('nuevo')){
              var IdInput = $.trim($(this).attr('id'));
              var ValorInput = $.trim($(this).val());
              var TipoResp = $.trim($('.TipoDeRepuesta_'+IdInput+'').val());
              var NombreEncuesta = $.trim($('.NombreEncuesta').val());
              var TiposEncuestaID = $.trim($('#TiposEncuestaID').val());
              var SubTipoEncuenta = $.trim($('#SubTipoEncuenta').val());
              var IdEncuesta = $.trim($('.NombreEncuesta').attr('id'));


              nuevoResultado.push({
                Id_Pregunta:IdInput,

                NombreEcnuesta: NombreEncuesta,
                TiposEncuesta: TiposEncuestaID,
                SubTipoEncuenta: SubTipoEncuenta,
                Pregunta: ValorInput,
                Respuesta: [],
                TipoRespuesta: TipoResp,
                IdEncuesta:IdEncuesta
              });

            }
            else{

              var IdInput = $.trim($(this).attr('id'));
              var ValorInput = $.trim($(this).val());
              var TipoResp = $.trim($('.TipoDeRepuesta_'+IdInput+'').val());
              var NombreEncuesta = $.trim($('.NombreEncuesta').val());
              var TiposEncuestaID = $.trim($('#TiposEncuestaID').val());
              var SubTipoEncuenta = $.trim($('#SubTipoEncuenta').val());
              var IdEncuesta = $.trim($('.NombreEncuesta').attr('id'));

              result.push({
                Id_Pregunta:IdInput,

                NombreEcnuesta: NombreEncuesta,
                TiposEncuesta: TiposEncuestaID,
                SubTipoEncuenta: SubTipoEncuenta,
                Pregunta: ValorInput,
                Respuesta: [],
                TipoRespuesta: TipoResp,
                IdEncuesta: IdEncuesta
              });
            }
          });




          $.each(result, function( index, value){
            $('#formEncuesta :input.Respuesta_'+value.Id_Pregunta+'').each(function(){
              value.Respuesta.push($.trim(
                $(this).val())
              );
            });
          });


          $.each(nuevoResultado, function( index, value){
            $('#formEncuesta :input.Respuesta_'+value.Id_Pregunta+'').each(function(){
              value.Respuesta.push($.trim(
                $(this).val())
              );
            });
          });



          swal({
            title: "Guardar Encuesta",
            text: "Ok para guardar la Encuesta",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
          }, function () {



            $.ajax({
              type: 'POST',
              url: '../Controlador/GuardarEditarEncuesta.php',
              dataType: "text",
              data: { 'DatosActualizar': JSON.stringify(result) },
              success: function(html){
                console.log(html);
                swal("Encuesta Guardada!");
                setTimeout(function () {
                window.location.href = '../index.php';
                }, 1000);

              }

            });

            $.ajax({
              type: 'POST',
              url: '../Controlador/GuardarEditarEncuesta.php',
              dataType: "text",
              data: { 'InsertarDatos': JSON.stringify(nuevoResultado) },
              success: function(html){
                console.log(html);
                //location.reload();
              }

            });
          });

        }

      </script>


      <script>  // Script para agregar nuevas preguntas
      $(document).ready(function(){



        var i=1, j=1, Contador;
        $('.add').click(function(){
          if(i==1){
            i = $(this).attr("id");
            Contador = $('.NumeroPregunta'+i+'').attr("id");
            Contador++;
            i++;
          }


          $('.PreguntaBlock').append('<div id ="row'+i+'"><div class="preguntaCabecera"><div id="'+i+'" class= "form-group left NumeroPregunta nuevo"><h6>'+Contador+'</h6></div> <div class= "form-group col-md-7"><input type="text" id="'+i+'" name="Pregunta[]" placeholder="Introduzca la pregunta aqui" class="form-control Pregunta nuevo" require></div> <div class ="DivTipoDeRepuesta form-group col-md-3"><select  class="my-select form-control nuevo TipoDeRepuesta_'+i+'" id="'+i+'" name="TipoDeRepuesta"><option disabled selected value> --Elija una opcion-- </option><?php $sql = 'SELECT * FROM  tbl_conf_repuesta';
          $resultado = $base->prepare($sql);
          $resultado->execute();
          $numero_registro = $resultado->rowCount();
          if (0 !== $numero_registro) {
              while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                  echo '<option value="'.$registro['IdConfiRepuesta'].'" data-icon="'.$registro['IconoConfiRepuesta'].'">'.$registro['DescripConfiRepuesta'].'</option>';
              }
          } else {
              echo '<option value="">  Tipo de repuesta no disponibles </option>';
          }
          ?></select></div><div class ="form-group col-md-1"><button type="button" name="remove" id="'+i+'"  class="btn btn-danger btn_remove nuevo"><i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></button></div></div><div class="form-group col-md-12 "  class = "DivOpciones Repuesta" id="Rep'+i+'"></div></div>');

          i++;
          Contador++;


        });
        $(document).on('click', '.btn_remove', function(){
          var IdPreguntaEliminar = $(this).attr("id");
if ($(this).hasClass('nuevo')){
  $('#row'+IdPreguntaEliminar+'').remove();
}else {
          swal({
            title: "Esta seguro que desea eliminar la Pregunta?",
            text: "No sera posible recuperar la data porteriomente",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, Borrar la pregunta !",
            closeOnConfirm: false
          },
          function(){

            $.ajax({
              type: 'POST',
              url: '../Controlador/GuardarEditarEncuesta.php',
              data: 'IdPreguntaEliminar=' +IdPreguntaEliminar,


              success: function(html){
                swal("Borrada!", "La pregunta fue borrada.", "success");
                setTimeout(function () {
                  location.reload();
                }, 2500);

              }

            });

          });
        }



        });


        $(document).on('change', '.my-select', function(){

          var resp_id = $(this).attr("id");
          var TipoDeRepuestaID = $(this).val();

          switch (TipoDeRepuestaID) {
            case '1':
            repuesta=' <i id="fa fa-circle-o" class="fa fa-circle-o fa-lg iconos'+resp_id+'" aria-hidden="true "></i>&nbsp;<input type="text" placeholder="Escriba una opcion" autocomolete="off" name="Opcion2[]" id="'+resp_id+'" class="RespComentario nuevo Respuesta_'+resp_id+'"> <span> </span><button type="button" name="addCase2Opcion" id="'+resp_id+'"  class="btn_addOption btn btn-success">+</button>';

            break;
            case '2':

            repuesta = ' <i id="fa fa-square-o" class="fa fa-square-o fa-lg iconos'+resp_id+'" aria-hidden="true "></i>&nbsp;<input type="text" placeholder="Escriba una opcion" autocomolete="off" name="Opcion2[]" id="'+resp_id+'" class="RespComentario nuevo Respuesta_'+resp_id+'"> <span> </span><button type="button" name="addCase2Opcion" id="'+resp_id+'"  class="btn_addOption btn btn-success">+</button>';

            break;
            case '3':
            repuesta= '<textarea  autocomolete="off" name="comentarios" id="'+resp_id+'" class="Respuesta" rows="4" cols="60"></textarea>';
            break;
            case '4':
            repuesta = '<div  onmouseover="showdiv(event,'+resp_id+');"onMouseOut="hiddenDiv()" style="display:table; font-weight: bold;"">Ejemplo:<br> </div><p>Del: <input type="number" value="1"  class=" nuevo Respuesta_'+resp_id+'" name="ValMinimo[]" id="ValMinimo_'+resp_id+'">   Al: <input type="number" value="10" class="Respuesta_'+resp_id+'" name="valMaximo[]" id="valMaximo_'+resp_id+'"></p><div id="flotante"></div><br>';



            break;
            case '5':
            repuesta = '<div class="nuevo" id="apDiv1"><table width="100%" border="0"><tr><?php $sql = 'SELECT * FROM  tbl_repuesta_imagen';
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
            repuesta = '<ul class="fa-ul nuevo"><?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
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
            repuesta = '<ul class="fa-ul nuevo"><?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
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
            repuesta = '<ul class="fa-ul nuevo"><?php $sql = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
            $resultado = $base->prepare($sql);
            $resultado->execute([':Codigo' => 8]);
            $numero_registro = $resultado->rowCount();
            if (0 !== $numero_registro) {
                while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    $RepuestaArray = explode(',', $registro['DescripConfiRepuesta']);

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
        console.log(TiposEncuestaID);

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


});

</script>




</body>

</html>
