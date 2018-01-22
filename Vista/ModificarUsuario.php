	<?php
ini_set('session.cookie_lifetime', '3600');
ini_set('session.gc_maxlifetime', '3600');
session_start();

if (!isset($_SESSION['userlog'])) {
    header('location:login.php');
}

?>






	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		 <link rel="icon" href="img/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Pausa Activa Admin</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">

		<link href="css/styles.css" rel="stylesheet">

		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="assets/css/github.min.css">

		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.0/sweetalert2.min.css">



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
						<h1 class="page-header">Crear Usuarios</h1>
					</div>
				</div><!--/.row-->

				<form    id="myform" name="myform" method="post" action="../Controlador/UsuarioControlador.php" enctype="multipart/form-data"  onsubmit="return checkForm(this);">

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Usuarios</div>
								<div class="panel-body">



										<div  id="UserNoDisponible">  </div>


	                                <div  class="form-group col-md-6" id="FormUsuario">
										<label>Usuario</label>
										<!--<input type="text" class= "form-control"  name= "Usuario" id ="txt_username"   onblur="checkField(this);" onkeyup="javascript:ComprobarUsuario('../Controlador/comprobarUser.php','estadoUser')" required />-->

										<input type="text" class= "form-control"  name= "Usuario" id ="txt_username" onfocusout="ComprobarUsuario()" required />

									 </div>

			                        <div class="form-group col-md-6" id="FormNombre">
										<label> Nombre</label>
											<input type="text" class= "form-control" name= "Nombre" id= "Nombre" onfocusout="Verificar_Nombre()" required />
									 </div>

									 <div class="form-group col-md-6" id="FormApellido">
										<label>Apellido</label>
										<input type="text" class= "form-control"  name= "Apellido" id ="Apellido" onfocusout="Verificar_Apellido()" required  />
									 </div>



									 <div class="form-group col-md-6 " id="FormEmail">
										<label>Correo Electronico</label>
										<input type="email" class= "form-control"  name= "Email" id ="Email" onfocusout="Verificar_Email()"required />
									 </div>

									 <div class="form-group col-md-6"  id="FormPassword">
										<label>Contraseña</label>
										<input type="password" class= "form-control"  name= "Password" id ="Password"  onfocusout="verificar_Password()" required />
									 </div>

									 <div class="form-group col-md-6 " id="FormConfirmPassword">
										<label>Confirmar Contraseña</label>
										<input type="password" class= "form-control"  name= "confirmpassword" id ="ConfirPassword"  onfocusout = "Verificar_confirmPassword()" required />
									 </div>


									 <div class="form-group col-md-6">
										<label>Permisos</label>
											<select class="form-control " name="Permisos" required>
												<option>Pausa Activa</option>
												<option>SuperAdmin</option>
												<option>Consulta</option>
												<option>Admin</option>


												</select>
									 </div>




									<div class="form-group col-md-6">
										<label>Imagen</label>
									    <input id="input-image-1" class ="close"  type="file" name= "imagen" accept="image/*" >
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



		<script src="js/jquery-1.11.1.min.js"></script>

			<script src="js/bootstrap.min.js"></script>
			<!--<script src="js/chart.min.js"></script>
			<script src="js/chart-data.js"></script>-->
			<script src="js/ValidarExistencia.js"></script>
			<!--<script src="js/easypiechart.js"></script>
			<script src="js/easypiechart-data.js"></script>-->
			<script src="js/bootstrap-datepicker.js"></script>
			<script src="js/custom.js"></script>
			<script type="text/javascript" src="assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="dist/bootstrap-clockpicker.min.js"></script>

	<script src="js/piexif.js"></script>
	<script src="js/fileinput.js"></script>


		<script type="text/javascript">


		$(document).ready(function(){
				$(".select2").select2();
		});
		</script>


		<script type="text/javascript">
			//Comprueba si el usuario existe en la db

			function ComprobarUsuario(){

				var usuario = $("#txt_username").val();


				if (usuario.length > 4){

					$.ajax({
						    url : "../Controlador/UsuarioControlador.php",
						    type: "POST",
						    data : {username :usuario},


						    success: function(data, textStatus)
						    {


						    	 $("#FormUsuario").addClass("has-success");

						      	if (data == "existe"){

									$("#BotonGuardar").attr("disabled", true);

						      		$("#FormUsuario").addClass("has-error");
						      		document.getElementById("UserNoDisponible").innerHTML =' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El nombre de usuario no esta disponible  </div>'
	       									 return false;

						      	}else{

						      		$("#txt_username").attr("required", false);
										$("#BotonGuardar").attr("disabled", false);
										$("#FormUsuario").removeClass("has-error");
										$("#FormUsuario").addClass("has-success");
										document.getElementById("UserNoDisponible").innerHTML ='';
						      	}
						    },
						    error: function (jqXHR, textStatus)
						    {
						 		alert("Algo Fallo");
						    }
					});

				}








			}

		</script>

		<script>
	$("#input-image-1").fileinput({
	    uploadUrl: "/site/image-upload",
	    allowedFileExtensions: ["jpg", "png", "gif"],
	    maxImageWidth: 200,
	    maxFileCount: 1,
	    resizeImage: true
	}).on('filepreupload', function() {
	    $('#kv-success-box').html('');
	}).on('fileuploaded', function(event, data) {
	    $('#kv-success-box').append(data.response.link);
	    $('#kv-success-modal').modal('show');
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
