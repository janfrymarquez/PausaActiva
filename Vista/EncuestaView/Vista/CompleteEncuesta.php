<?php
session_start();
if (isset($_SESSION['userlog'])) {
    $fechaGuardada = $_SESSION['ultimoAcceso'];
    $idUsuario = $_SESSION['IdUsuarioActual'];
    $permiso = $_SESSION['Permiso'];
    $emailCliente = $_SESSION['email'];

    switch ($_SESSION['Permiso']) {
        case '2':
            header('Location:charts.php');

            break;
        case '4':

            break;
        case '1':

            break;
        default:
            header('Location:../index.php');

            break;
    }

    $ahora = date('Y-n-j H:i:s');
    if ('SI' !== $_SESSION['autentificado']) {
        header('Location:login.php');

        return false;
    }
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));
    if ($tiempo_transcurrido >= 1200) {
        //1200 milisegundos = 1200/60 = 20 Minutos...
        session_destroy();
        header('Location:login.php');

        return false;
    }
    $_SESSION['ultimoAcceso'] = $ahora;
} else {
    header('Location:login.php');

    return false;
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
  <link rel="stylesheet" href="css/responsive.dataTables.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Completar Encuesta</title>

</head>

<body>
  <?php
require 'header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#">
        <em class="fa fa-home"></em>
      </a></li>
      <li class="active"> Completar Encuesta</li>
    </ol>
  </div><!--/.row-->

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"></h1>
    </div>
  </div><!--/.row-->
  <center><div class="EncuestaComplecontainer">





<?php
$sql = 'SELECT * FROM  tbl_token WHERE Evaluador = :usuarioId';
$resultados = $base->prepare($sql);
$resultados->execute([':usuarioId' => $emailCliente]);
$numero_registro = $resultados->rowCount();

if (0 !== $numero_registro) {
    ?>

  <table id="DataTable" class="table display table-striped table-hover" cellspacing="0" width="100%">
  <thead>
  <tr>
  <th></th>
  <th></th>
  </tr>
  </thead>
  <tbody>
    <?php

    while ($registros = $resultados->fetch(PDO::FETCH_ASSOC)) {
        $token = $registros['token'];
        $IdEncuesta = $registros['IdEncuesta'];
        $Estatus = $registros['Activo'];
        $sqlEncuesta = 'SELECT * FROM  tbl_encuesta_cabecera WHERE IdEncuestaCabecera = :idEncuesta && Activo = :Activo';
        $resultadosEncuesta = $base->prepare($sqlEncuesta);
        $resultadosEncuesta->execute([':idEncuesta' => $IdEncuesta, ':Activo' => 1]);

        $numero_registro = $resultadosEncuesta->rowCount(); ?>


        <?php
        if (0 !== $numero_registro) {
            while ($registrosEncusta = $resultadosEncuesta->fetch(PDO::FETCH_ASSOC)) {
                if ('1' === $Estatus) {
                    echo '<tr>';
                    echo '<td>  <div  class="NombreClienteEvaludo">'.$registrosEncusta['NombreEncuesta'].' </div></td>';
                    echo '<td><button class ="btn btn-primary "><a class="btnCompletarEncusta" title="Pulse aqui para llenar la encuesta" href="EncuestaView/PrepareEncuesta.php?token='.$token.'" >Completar</a> </button> </td>';
                    echo '</tr>';
                } else {
                    echo '<tr>';
                    echo '<td>  <div  class="NombreClienteEvaludo">'.$registrosEncusta['NombreEncuesta'].'  </div></td>';
                    echo '<td><div class ="EnlaceEvaluado">Completada </div> </td>';
                    echo '</tr>';
                }
                $resultadosEncuesta->closeCursor();
            }
        }
    }

    echo '</tbody></table></center> </div>';
    $resultados->closeCursor();
} else {
    echo '<div class="NoEncuestaActive"> No tiene encuesta activa, Favor consuslte con el administrador </div>';
}

?>



<script>
var t = $('#DataTable').DataTable();
$('#DataTable_filter').addClass('search-box');

</script>


</body>

</html>
