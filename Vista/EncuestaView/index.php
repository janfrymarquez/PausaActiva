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
  <head>


      <link href="../css/styles.css" rel="stylesheet">
      <link rel="icon" href="../img/favicon.ico">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="../css/sweetalert.css">

      <link href="../css/font-awesome.min.css" rel="stylesheet">
      <link href="../css/datepicker3.css" rel="stylesheet">



        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <meta charset="utf-8">
    <title><?php echo $NombreEncuesta; ?></title>
    <script src="../js/jquery.js"></script>

    <script src="../js/jPaginate.js"></script>

   <script src="../js/sweetalert.js"></script>

  </head>
  <body  class="Cuerpo">






  <form id= "formEnviarEncuesta" >


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

        <div  >
        <h4  id="<?php echo $obj->IdEncuestaDetalle; ?>" class="Pregunta" name="Pregunta[]"><?php echo $obj->IdPreguntas.' '.$obj->Pregunta; ?></h3>
        </div>



      <div class="DivOpciones" id="Rep<?php echo $obj->IdEncuestaDetalle; ?>">
        <?php

$Repuesta = explode(',', $obj->Repuesta);
$tipoRepuesta = $obj->TipoRepuesta;
foreach ($Repuesta as $objRepuesta) {
    switch ($tipoRepuesta) {
        case '1':

            echo '<input type="radio" class="Repuesta" required  id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$objRepuesta.'"> '.$objRepuesta.' <br>';

            break;
        case '2':

            echo '<input type="radio" required class="Repuesta"  id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$objRepuesta.'"> '.$objRepuesta.' <br>';

            break;
        case '3':
            echo '<textarea  autocomolete="off" class="Repuesta"  name="comentarios" id="'.$obj->IdEncuestaDetalle.'" class="Respuesta_'.$obj->IdEncuestaDetalle.'" rows="4" cols="60"></textarea>';

            break;
        case '4':

            break;
        case '5':

            $sql = 'SELECT * FROM  tbl_repuesta_imagen';
            $resultado = $base->prepare($sql);
            $resultado->execute();
            $numero_registro = $resultado->rowCount();
            if (0 !== $numero_registro) {
                while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    echo '    <label><input type="radio" class="Repuesta" id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$registro['ImagenDescripcion'].'" /><img class="pequeña" src="../'.$registro['ImagenRuta'].'"></label>';
                }
            } else {
                echo '<option value="">  Tipo de repuesta no disponibles </option>';
            }

            break;
        case '6':
        case '7':
        case '8':

            echo '<input type="radio" required class="Repuesta checkval'.$obj->IdEncuestaDetalle.'" id="'.$obj->IdEncuestaDetalle.'" name="OpcionSelecionada'.$obj->IdEncuestaDetalle.'" value="'.$objRepuesta.'"> '.$objRepuesta.' <br>';

            break;
    }
}
?>
      </div> <!--Campo de Repuesta-->


      </div> <!-- Numero de pregunta-->
<?php
++$contador; endforeach; ?>


</div > <!-- CampoPregunta-->
<div id ="buttonSent" class="BotonEnviar"></div>
<div id ="Paginacion" class="divPaginacion"></div>

</div>  <!-- Conenedor-->




</form>

<script>



$(function(){
    $(".BloquePregunta").jPaginate();

});

function enviarResultado(){

 if(<?php echo $idClientes; ?> !== N_A){
   idcliente = <?php echo $idClientes; ?>;
 }else {
 idcliente = '';
 }
  var resultado=[];
  var IdEncuesta =$('.Cabecera').attr('id');
  resultado.push({

    Id_Pregunta:[],
    RepuestaSelec:[],
    IdEncuesta:IdEncuesta,
    IdCliente: idcliente
});
$.each(resultado, function( index, value){
    $("#formEnviarEncuesta :input.Repuesta:checked").each(function(){
      value.RepuestaSelec.push($(this).val());
      value.Id_Pregunta.push($(this).attr('id'));

      });
    });

  var EncuestaArray = JSON.stringify(resultado);

console.log(EncuestaArray);

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

</script>


  </body>
</html>
