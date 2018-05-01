<?php

try {
    require '../../Modelo/Conexion.php';

    $Conexion = new Conexion();
    $base = $Conexion->Conexion();

    function eliminarEnlace($tokn)
    {
        $ConexionDb = new Conexion();
        $base = $ConexionDb->Conexion();
        $FechaCreacion = date('Y/m/d');
        $Activo = '0';

        $sqldelete = "UPDATE tbl_token set     FechaModificacion ='${FechaCreacion}',
                                            Activo ='${Activo}'
                                            WHERE token='${tokn}'";

        $resultados = $base->prepare($sqldelete);
        $resultados->execute();
        $resultados->closeCursor();
    }
    function UpdateClienteEvaluar($IdCliente)
    {
        $ConexionDb = new Conexion();
        $base = $ConexionDb->Conexion();
        $estatus = 'Evaluado';
        $sqldelete = "UPDATE tbl_evaluados set    Estatus ='${estatus}'

                                          WHERE IdCliente='${IdCliente}'";

        $resultado = $base->prepare($sqldelete);
        $resultado->execute();
        $resultado->closeCursor();
        
       
    }

    $token = $_GET['token'];
    if (isset($_GET['idCliente'])) {
        $idClientes = $_GET['idCliente'];
    } else {
        $idClientes = 'N_A';
    }

    $activo = 1;

    $sql = 'SELECT * FROM  tbl_token WHERE token = :token';
    $resultados = $base->prepare($sql);
    $resultados->execute([':token' => $token]);
    $numero_registro = $resultados->rowCount();
    if (0 !== $numero_registro) {
        $registros = $resultados->fetch(PDO::FETCH_ASSOC);

        $Id = $registros['IdEncuesta'];
    }
    $resultados->closeCursor();

    $sql = 'SELECT * FROM  tbl_encuesta_cabecera WHERE IdEncuestaCabecera = :Id && Activo = :Activo';
    $resultados = $base->prepare($sql);
    $resultados->execute([':Id' => $Id, ':Activo' => $activo]);
    $numero_registro = $resultados->rowCount();
    if (0 !== $numero_registro) {
        $registros = $resultados->fetch(PDO::FETCH_ASSOC);

        $NombreEncuesta = $registros['NombreEncuesta'];
    }
    $resultados->closeCursor();
} catch (Exception $e) {
}

?>


<!DOCTYPE html>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">


      <link href="../css/styles.css" rel="stylesheet">
      <link rel="icon" href="../img/favicon.ico">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/sweetalert.css">
      <link href="../css/select2.min.css" rel="stylesheet">
      <link href="../css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/datepicker3.css" rel="stylesheet">




    
    <title><?php echo $NombreEncuesta; ?></title>
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
    <script src="../js/jPaginate.js"></script>
   <script src="../js/sweetalert.js"></script>
    <script src="../js/select2.min.js"></script>

  </head>
  <body  class="Cuerpo">

  <form method="post"  id= "formEnviarEncuesta" >


    <div class="Contenedor">
      <?php echo ' <div   id="'.$Id.'"  class="Cabecera"> <h1>  '.$NombreEncuesta.' </h1> </div>';

      ?>
   <div class= "BloquePregunta">
    <?php

$sql = ' SELECT * FROM  tbl_encuesta_detalle WHERE IdEncuesta = :IdEncuesta ';
$resultado = $base->prepare($sql);
$resultado->execute([':IdEncuesta' => $Id]);
$registros = $resultado->fetchAll(PDO::FETCH_OBJ);
$contador = 1;
foreach ($registros as $obj): ?>






      <div  id="row<?php echo $obj->IdEncuestaDetalle; ?>">

        <div class="form_field"><div>
        <h4  id="<?php echo $obj->IdEncuestaDetalle; ?>" class="Preguntas" name="Pregunta[]"><?php echo $obj->IdPreguntas.' '.$obj->Pregunta; ?></h3>
        </div>



      <div class="DivOpciones" id="Rep<?php echo $obj->IdEncuestaDetalle; ?>">
        <?php

$Repuesta = explode(',', $obj->Repuesta);
  $ValorRepuesta = explode(',', $obj->ValorRepuesta);
$tipoRepuesta = $obj->TipoRepuesta;
$x = 0;
foreach ($Repuesta as $objRepuesta) {
    switch ($tipoRepuesta) {
        case '1':

            echo '<input type="radio" class="Respuesta required RepuestaRadio" required  id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$objRepuesta.'"> '.$objRepuesta.' <br>';

            break;
        case '2':

            echo '<input type="checkbox" required class="CampoCheck required"  id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$objRepuesta.'"> '.$objRepuesta.' <br>';

            break;
        case '3':
            echo '<textarea  autocomolete="off"  placeholder="Escribe aqui tu comentario "  name="comentarios" id="'.$obj->IdEncuestaDetalle.'"  class=" Respuesta required inputRepuesta" ></textarea>';

            break;
            case '4':
          echo '<input type="number" placeholder="Introduce un numero entre 1 y 10" class=" Respuesta required inputRepuesta" id="'.$obj->IdEncuestaDetalle.'" name="cantidad" min="1" max="10"><br>';

            break;
        case '5':

            $sql = 'SELECT * FROM  tbl_repuesta_imagen';
            $resultado = $base->prepare($sql);
            $resultado->execute();
            $numero_registro = $resultado->rowCount();
            if (0 !== $numero_registro) {
                while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo '    <label><input type="radio" class="Respuesta valorRepuesta required RepuestaRadio" id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$registro['ImagenDescripcion'].'/'.$registro['ValorImagen'].'" /><img class="pequeña" src="../'.$registro['ImagenRuta'].'"></label>';
                }
            } else {
                echo '<option value="">  Tipo de repuesta no disponibles </option>';
            }

            break;
        case '6':
        case '7':
        case '8':

            echo '<input type="radio" required class="Respuesta RepuestaRadio valorRepuesta required checkval'.$obj->IdEncuestaDetalle.'" id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$objRepuesta.'/'.$ValorRepuesta[$x].'"> '.$objRepuesta.' <br>';
++$x;

            break;
            case '9':
            echo ' <input type="text"  id="'.$obj->IdEncuestaDetalle.'"  placeholder="Escribe aqui"  required class="Respuesta required  inputRepuesta RepuestaInput"></input> </br>';

            break;
            case '10':
            echo '<select class="Respuesta required ClienteSelect inputRepuesta" id="'.$obj->IdEncuestaDetalle.'"> <option  selected disabled  value=" ">Seleciona un cliente</option>';

$sql = 'SELECT * FROM  tbl_clientes WHERE Activo = :activo';
$resultado = $base->prepare($sql);
$resultado->execute([':activo' => 1]);

while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
    echo '<option  value="'.$registro['IdClientes'].'">'.$registro['NombreCliente'].'</option>';
}
echo '</select>';

break;
    }
}
?>
      </div> <!--Campo de Repuesta-->
<div class="error_message_holder"></div>
    </div>
      </div> <!-- Numero de pregunta-->
<?php
++$contador; endforeach; ?>


</div > <!-- CampoPregunta-->



</br><button type="submit" name="add" id ="buttonSent"  class="btn btn-success add"> Enviar encuesta</button>

</div>  <!-- Conenedor-->




</form>

<script>





/*
$(function(){
    $(".BloquePregunta").jPaginate();

});

*/

function toTop() {
window.scrollTo(0, 0)
}

$(document).ready(function() {

     var boton = $('.go-top-btn');

     $(window).on('scroll', function() {
         var scrollTop = $(window).scrollTop();


         if (scrollTop >= 500) {
             boton.addClass('visible');
         } else {
             boton.removeClass('visible');
         }
     });



  $(".ClienteSelect").select2({
      width: 'resolve',
      placeholder: 'Seleciones una opcion'
  });



            $('#formEnviarEncuesta').validate({
                  errorPlacement: function(error, element) {
                        error.html('Esta campo es requerido');
                           if(element.closest('.form_field').find('label.error').length == 0){
                               error.insertBefore( element.closest('.form_field').find('.error_message_holder') );
                        }
              },

          submitHandler: function(form){

            if('<?php echo $idClientes; ?>' !== 'N_A'){
              idcliente = <?php echo $idClientes; ?>;
            }else {
              idcliente = '';
            }
            var resultado=[];
            var IdEncuesta =$('.Cabecera').attr('id');
            var token = '<?php echo $token; ?>' ;
            resultado.push({

              Id_Pregunta:[],
              RepuestaSelec:[],
              IdEncuesta:IdEncuesta,
              valorRepuesta:[],
              IdCliente: idcliente,
              token:token,

            });
            $.each(resultado, function( index, value){
              $("#formEnviarEncuesta :input.Respuesta").each(function(){
                if($(this).hasClass('RepuestaRadio') && this.checked){

                  if ($(this).hasClass('valorRepuesta')){
                  $repuestaCompleta = $(this).val().split('/');
                  value.RepuestaSelec.push($repuestaCompleta[0]);
                  value.valorRepuesta.push($repuestaCompleta[1]);
                    value.Id_Pregunta.push($(this).attr('id'));

                }else{

                  value.valorRepuesta.push(' ');
                  value.RepuestaSelec.push($(this).val());
                  value.Id_Pregunta.push($(this).attr('id'));
                }

              }

              if ($(this).hasClass('CampoCheck') && this.checked){

                value.valorRepuesta.push(' ');
                value.RepuestaSelec.push($(this).val());
                value.Id_Pregunta.push($(this).attr('id'));

              }
              if ($(this).hasClass('inputRepuesta')){
                value.valorRepuesta.push(' ');
                value.RepuestaSelec.push($(this).val());
                value.Id_Pregunta.push($(this).attr('id'));

              }

              });




            });

            var EncuestaArray = JSON.stringify(resultado);

            console.log(resultado);

                $.ajax({
                type: 'POST',
                url: '../../Controlador/GuardarEditarEncuesta.php',
                dataType: "text",
                data: { 'EncuestaArray': JSON.stringify(resultado) },
                success: function(html){
                swal("Gracias!", "Gracias por preferirnos!", "success");
                $('.sa-confirm-button-container').click(function(){

                <?php   UpdateClienteEvaluar($idClientes); ?>
                setTimeout(function()
                {
                location.href ="EncuestaFinalizar.php";

                  }, 100);

              })

              }

                });
              }
          });

});
</script>


  </body>

  <footer>
  <a class="go-top-btn" value="Top" onClick=toTop()></a>
  </footer>
</html>
