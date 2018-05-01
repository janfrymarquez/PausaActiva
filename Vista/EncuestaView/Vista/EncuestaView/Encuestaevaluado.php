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

<body  class="Cuerpo">

<div class="Contenedor">
<?php


    require '../../Modelo/Conexion.php';

    $Conexion = new Conexion();
    $base = $Conexion->Conexion();
    $token = $_GET['token'];
    $sqlGetEvaluado = 'SELECT * FROM  tbl_evaluados WHERE IdToken = :Token';
		$resultados = $base->prepare($sqlGetEvaluado);
		$resultados->execute([':Token' => $token]);

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
												echo '<td><div class ="EnlaceEvaluado"><a  title="Pulse aqui para llenar la encuesta" href="index.php?token='.$token.'& id='.$idCliente.'" >'.$Estatus.'</a> </div> </td>';
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
												echo '<td><div class ="EnlaceEvaluado"><a  title="Pulse aqui para llenar la encuesta" href="index.php?token='.$token.'& idCliente='.$idCliente.'" >'.$Estatus.'</a> </div> </td>';
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
                ?>
            </div>
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