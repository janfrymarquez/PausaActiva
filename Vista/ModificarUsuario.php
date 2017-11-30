<?php

session_start();

if (!isset($_SESSION["userlog"])) {

    header("location:login.php");

}

if (isset($_POST["login"])) {

    date_default_timezone_set('America/Santo_Domingo');

    $mipagina = $_SERVER["PHP_SELF"];

    $usuario         = htmlentities(addslashes($_POST["Usuario"]));
    $password        = htmlentities(addslashes($_POST["Password"]));
    $Nombre          = htmlentities(addslashes($_POST["Nombre"]));
    $Apellido        = htmlentities(addslashes($_POST["Apellido"]));
    $Email           = htmlentities(addslashes($_POST["Email"]));
    $imagen          = $_FILES["imagen"];
    $confirmpassword = htmlentities(addslashes($_POST["confirmpassword"]));
    $Permisos        = $_POST["Permisos"];
    //$UsuarioActual   = $_SESSION["userlog"];
    $UsuarioActual = "Admin";
    $UsuarioActual = 1;
    $FechaCreacion = date('Y/m/d');
    $ID            = 3;

    require "../Controlador/cls_usuario.php";

    $RegistrarUsuario = new Usuario();

    $RegistrarUsuario->RegistrarUser($ID, $usuario, $password, $Email, $Nombre, $Apellido, $imagen, $UsuarioActual, $FechaCreacion);

}
?>






<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
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
		<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">

             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>

				<a class="navbar-brand" href="#"><span>PAUSA ACTIVA </span> </span> Admin</a>

			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">

               <?php

$usar = $_SESSION["userlog"];

echo '<div class="profile-usertitle-name"> ' . "Hola" . '  ' . $usar . ' </div>';
?>
			<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
			<ul class="nav menu">
				<li ><a href="../index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
				<li><a href="charts.php"><em class="fa fa-bar-chart">&nbsp;</em> Estadistica</a></li>
				<li><a href="elements.php"><em class="fa fa-toggle-off">&nbsp;</em> Administrar P Activa </a>



				<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-navicon">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-1">
						<li><a class="active" href="ModificarUsuario.php">
							<span class="fa fa-user-plus">&nbsp;</span> Configurar Usuarios
						</a></li>
						<li><a class="" href="ModificarUsuario.php">
							<span class="fa fa-arrow-right">&nbsp;</span> Configurar Empleados
						</a></li>
						<li><a class="" href="#">
							<span class="fa fa-arrow-right">&nbsp;</span> Departamentos
						</a></li>
					</ul>
				</li>
				<li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
			</ul>
		</div><!--/.sidebar-->

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

			<form    id="myform" name="myform" method="post" action="ModificarUsuario.php" onsubmit="return checkForm(this);">

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
								    <input id="input-image-1" class ="close" name="imagen" type="file" accept="image/*" >
								</div>
								<!-- an example modal dialog to display confirmation of the resized image -->
								<div id="kv-success-modal" class="modal fade form-group col-md-6 ">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h4 class="modal-title">Yippee!</h4>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								      </div>
								      <div id="kv-success-box" class="modal-body">
								      </div>
								    </div>
								  </div>
								</div>





							</div><!-- /.panel-->
						</div><!-- /.col-->
	               	</div><!--/.row-->



	          <div class="row" >
	                <div class="col-lg-12">
						<div class="Panel-Botones">
	                         <div class="Panel-Botones-Guardar col-lg-6 col-lg-offset-9">
	                         	<input type="reset" class="btn btn-danger" value="Reset"  />
	                   				<input type="submit" id="BotonGuardar" class="btn btn-info" name="login" value="Submit"/>

	           			     </div>
						</div>
					</div>
	           	</div>
	        </form>


				<div class="col-sm-12">
					<p class="back-link"><a ">Janfry Marquez </a></p>
				</div>
			</div>
		</div><!-- /.row -->
		</div><!--/.main-->


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
					    url : "../Controlador/comprobarUser.php",
					    type: "POST",
					    data : {username :usuario},


					    success: function(data, textStatus)
					    {


					    	 $("#FormUsuario").addClass("has-success");

					      	if (data == "existe"){

								$("#BotonGuardar").attr("disabled", true);

					      		$("#FormUsuario").addClass("has-error");
					      		document.getElementById("UserNoDisponible").innerHTML =' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El nombre de usuario no esta disponible  </div>'

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
