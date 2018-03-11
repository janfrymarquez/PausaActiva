	<?php
ini_set('session.cookie_lifetime', '3600');
ini_set('session.gc_maxlifetime', '3600');
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
		<title>Crear Clientes</title>




	<style type="text/css" media="screen">
		.No_Disponible{
	    background-color:#FFAAAA;

	    font-weight: bold;
	    color: #999999;
	    font-size:15px;
	}

	</style>
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
						<li class="active">Forms Admin</li>
					</ol>
				</div><!--/.row-->

				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Crear Clientes & Empleados</h1>
					</div>
				</div><!--/.row-->

				<form    id="myform" name="myform" method="post" action="../Controlador/UsuarioControlador.php" enctype="multipart/form-data"  onsubmit="return checkForm(this);">

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Clientes & Empleado</div>
								<div class="panel-body">



										<div  id="UserNoDisponible">  </div>


										<div  class="form-group col-md-6" id="FormCliente">
											<label>Nombre del Cliente</label>

											<input type="text" class= "form-control"  name= "Cliente" id ="txt_cliente"  required />

										</div>
									 <div class="form-group col-md-6" id="FormApellido">
										<label>Apellido</label>
										<input type="text" class= "form-control"  name= "Apellido" id ="Apellido"  required  />
									 </div>

			             <div class="form-group col-md-6" id="FormDireccion">
										<label> Direccion</label>
											<input type="text" class= "form-control" name= "Direccion" id= "Direccion"  required />
									 </div>





									 <div class="form-group col-md-6 " id="FormEmail">
										<label>Correo Electronico</label>
										<input type="email" class= "form-control"  name= "Email" id ="Email" required />
									 </div>

									 <div class="form-group col-md-6"  id="Formtelefono">
										<label>Telefono</label>
										<input type="text" class= "form-control" pattern="^[9|8|7|6]\d{8}$" name= "Telefono" id ="Telefono"   required />
									 </div>

									 <div class="form-group col-md-6"  id="FormTipoCliente">
										 <label>Tipo de cliente</label>
										 <select  class="my-select form-control TipoCliente" Id="TipoCliente">
											 <option disabled selected value> --Elija una opcion-- </option>

											 <?php
                                             $sql = 'SELECT * FROM  tbl_tipo_clientes';
                                             $resultado = $base->prepare($sql);
                                             $resultado->execute();
                                             $numero_registro = $resultado->rowCount();

                                             if (0 !== $numero_registro) {
                                                 while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                                     echo '<option value="'.$registro['IdAreaCliente'].'">'.$registro['TipoCliente'].'</option>';
                                                 }
                                             } else {
                                                 echo '<option value="">  Tipo de repuesta no disponibles </option>';
                                             }
                                             ?>
										 </select>


									 </div>

									 <div class="form-group col-md-6"  id="FormDepartamento">

										<div id="LebelDepartamento"></div>
										<div id="Slectopcitiondepartamento"></div>

									 </div>




                                  <div class ="pull-right ">
                                    <button type="submit" class="btn btn-info  enviarForm">Submit Button</button>
									<button type="reset" class=" btn btn-danger enviarForm" >Reset Button</button>
                            </div>
								</div><!-- /.panel-->


							</div><!-- /.col-->


		               	</div><!--/.row-->


				</div>


		        </form>


					<div class="col-sm-12">
						<p class="back-link"><a>Janfry Marquez </a></p>
					</div>









		<script type="text/javascript">


		$(document).ready(function(){


$('#FormDepartamento').hide();
				$("#TipoCliente").on('change', function(){

					var TipoCliente = $(this).val();


					switch (TipoCliente) {
						case '1':
						$('#Slectopcitiondepartamento').html("<select class='form-control Departamento select2'  id='Departamento'></select>");
						$.ajax({
							type: 'POST',
							url: '../Controlador/UsuarioControlador.php',
							data: 'EmpleadoInterno=' +TipoCliente,
							success: function(html){


								if(html== 'NoDisponible'){
									$('#FormDepartamento').hide();
								}

								else {

									$('#FormDepartamento').show();

									$('#LebelDepartamento').html("<label>Departamento</label>");
									$('#Departamento').html(html);
									$('#Departamento').attr('name', 'EmpleadoInterno');
									$(".select2").select2();4
								}
							}

						});

						break;
						case '2':
						$('#Slectopcitiondepartamento').html("<select class='form-control Departamento select2' multiple  id='Departamento'></select>");
						$.ajax({
							type: 'POST',
							url: '../Controlador/UsuarioControlador.php',
							data: 'EmpleadoExterno=' +TipoCliente,
							success: function(html){


								if(html== 'NoDisponible'){
									$('#FormDepartamento').hide();
								}

								else {

									$('#FormDepartamento').show();

									$('#LebelDepartamento').html("<label>Heladeria</label>");
									$('#Departamento').html(html);
									$(".select2").select2();

								}
							}

						});

						break;
						default:
						$('#FormDepartamento').hide();

					}


				});




		});


		</script>











	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<script type="text/javascript" src="assets/js/highlight.min.js"></script>
		<script type="text/javascript">
		hljs.configure({tabReplace: '    '});
		hljs.initHighlightingOnLoad();
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.0/sweetalert2.js"></script>


	</body>
	</html>
