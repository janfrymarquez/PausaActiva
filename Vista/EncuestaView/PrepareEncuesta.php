<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
            <title>
                Preparar Encuesta
            </title>
            <link href="../css/styles.css" rel="stylesheet">
                <link href="../img/favicon.ico" rel="icon">

								<link rel="stylesheet" href="../css/jquery.dataTables.min.css">
														<script src="../js/jquery.min.js"></script>
														<script src="../js/jquery.dataTables.min.js"></script>
                    <meta content="width=device-width, initial-scale=1" name="viewport">
                    </meta>
                </link>
            </link>
        </meta>

<body>





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

    function getEvaluado($id)
    {
        $ConexionDb = new Conexion();
        $base = $ConexionDb->Conexion();

        $sqlGetEvaluado = 'SELECT * FROM  tbl_evaluados WHERE IdToken = :Token';
        $resultados = $base->prepare($sqlGetEvaluado);
        $resultados->execute([':Token' => $id]);

        $numero_registro = $resultados->rowCount(); ?>
<center><div class="Evaluadocontainer">


			<table id="DataTable" class="table display table-striped table-hover" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th></th>
			<th></th>
			</tr>
			</thead>
			<tbody>

				<?php
        if (0 !== $numero_registro) {
            while ($registrosEvaluado = $resultados->fetch(PDO::FETCH_ASSOC)) {
                $TipoCliente = $registrosEvaluado['TipoCliente'];
                $idCliente = $registrosEvaluado['IdCliente'];
                $Estatus = $registrosEvaluado['Estatus'];

                if ('D' === $TipoCliente) {
                    $sqlCliente = 'SELECT * FROM  tbl_clientes WHERE IdDepartamento = :IdClientes';

                    $resultadosCliente = $base->prepare($sqlCliente);
                    $resultadosCliente->execute([':IdClientes' => $idCliente]);
                    $numero_registro = $resultadosCliente->rowCount();
                    if (0 !== $numero_registro) {
                        $registro = $resultadosCliente->fetch(PDO::FETCH_ASSOC);
                        if ('Evaluar' === $Estatus) {
                            echo '<tr>';
                            echo '<td>  <div  class="NombreClienteEvaludo">'.$registro['NombreCliente'].' '.$registro['ApellidoCliente'].' </div></td>';
                            echo '<td><div class ="EnlaceEvaluado"><a  title="Pulse aqui para llenar la encuesta" href="index.php?token='.$id.'& id='.$idCliente.'" >'.$Estatus.'</a> </div> </td>';
                            echo '</tr>';
                        } else {
                            echo '<tr>';
                            echo '<td>  <div  class="NombreClienteEvaludo">'.$registro['NombreCliente'].' '.$registro['ApellidoCliente'].' </div></td>';
                            echo '<td><div class ="EnlaceEvaluado">'.$Estatus.' </div> </td>';
                            echo '</tr>';
                        }
                        $resultadosCliente->closeCursor();
                    }
                }

                if ('U' === $TipoCliente) {
                    $sqlCliente = 'SELECT * FROM  tbl_clientes WHERE IdClientes = :IdClientes';

                    $resultadosCliente = $base->prepare($sqlCliente);
                    $resultadosCliente->execute([':IdClientes' => $idCliente]);
                    $numero_registro = $resultadosCliente->rowCount();
                    if (0 !== $numero_registro) {
                        $registro = $resultadosCliente->fetch(PDO::FETCH_ASSOC);

                        if ('Evaluar' === $Estatus) {
                            echo '<tr>';
                            echo '<td>  <div  class="NombreClienteEvaludo">'.$registro['NombreCliente'].' '.$registro['ApellidoCliente'].' </div></td>';
                            echo '<td><div class ="EnlaceEvaluado"><a  title="Pulse aqui para llenar la encuesta" href="index.php?token='.$id.'& idCliente='.$idCliente.'" >'.$Estatus.'</a> </div> </td>';
                            echo '</tr>';
                        } else {
                            echo '<tr>';
                            echo '<td>  <div  class="NombreClienteEvaludo">'.$registro['NombreCliente'].' '.$registro['ApellidoCliente'].' </div></td>';
                            echo '<td><div class ="EnlaceEvaluado">'.$Estatus.' </div> </td>';
                            echo '</tr>';
                        }
                        $resultadosCliente->closeCursor();
                    }
                }
            }

            echo '</tbody></table></center> </div>';
        }
        $resultados->closeCursor();
    }

    $token = $_GET['token'];
    $IdTipoEncuesta = '';
    $SubTipoEncuenta = '';
    $activo = 1;
    $sql = 'SELECT * FROM  tbl_token WHERE token = :token';
    $resultados = $base->prepare($sql);
    $resultados->execute([':token' => $token]);
    $numero_registro = $resultados->rowCount();

    if (0 !== $numero_registro) {
        $registros = $resultados->fetch(PDO::FETCH_ASSOC);
        $Encuestaactiva = $registros['Activo'];
        $Id = $registros['IdEncuesta'];
        $FechaExpiracion = $registros['FechaEspiracion'];
        $permiso = $registros['Permiso'];
        $Evaluador = $registros['Evaluador'];
        $ClienteOpcion = $registros['ClienteOpcion'];
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
    date_default_timezone_set('America/Santo_Domingo');

    if ('1' === $Encuestaactiva) {
        switch ($permiso) {
                case '1':

                    if ('CE' === $ClienteOpcion) {
                        getEvaluado($token);
                    } elseif ('TU' === $ClienteOpcion) {
                                            header('Location:index.php?token='.$token.'');
                                        }

                  //eliminarEnlace($token);

                    break;
                case '2':
                    header('Location:../login.php');

                    break;
                case '3':
                    if ('0000-00-00' !== $FechaExpiracion) {
                        $FechaActual = date('Y-m-d');

                        if ($FechaExpiracion <= $FechaActual) {
                            eliminarEnlace($token);
                            header('Location:../charts.php');
                        }
                    }

                    break;
                case '4':
                    if ($FechaExpiracion !== 0000 - 00 - 00) {
                        $FechaActual = date('Y-m-d');

                        if ($FechaExpiracion <= $FechaActual) {
                            eliminarEnlace($token);
                            header('Location:EncuestaExpirada.php?name='.$NombreEncuesta.'  & tipo=ha expirado,');
                        }
                    }

                    break;
                case '5':

                    eliminarEnlace($token);

                    break;
                default:
                    // code...
                    break;
            }
    } else {
        header('Location:EncuestaExpirada.php?name='.$NombreEncuesta.'  & tipo=está desabilitada,');
    }
} catch (Exception $e) {
}
    ?>

		<script src="../js/dataTables.responsive.min.js">

		</script>

		<script>
		var t = $('#DataTable').DataTable();
		$('#DataTable_filter').addClass('search-box');

		</script>



                  </div>
</head>

</body>
</html>
