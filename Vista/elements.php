 	<?php
 ini_set ( 'max_execution_time', 300);
session_start();

if(!isset($_SESSION["userlog"])){
	
  header("location:login.php");


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
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="assets/css/github.min.css">
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
			
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

               $usar =$_SESSION["userlog"];

			echo '<div class="profile-usertitle-name"> '."Hola".'  '.$usar.' </div>';
			?>
				<div class="profilsertitle-status"><span class="indicator label-success"></span>Online</div>
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
			<li class="active"><a href="elements.php"><em class="fa fa-toggle-off">&nbsp;</em> Administrar P Activa </a></li>
			<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li><a class="" href="ModificarUsuario.php">
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
				<h1 class="page-header">Administrar Pausa Activa</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Configuraciones</div>
						<div class="panel-body">
						
							
	                        <div class="form-group col-md-6">
								<label>Departamentos</label>
									<select class="form-control select2" multiple name="departamento">
										<option>Tecnologia</option>
										<option>Compra</option>
										<option>Finanza</option>
										<option>Contabilidad </option>
										</select>
							 </div>

							 <div class="form-group col-md-6">
								<label>Dias</label>
									<select class="form-control" name="dias" id="dias">
									<?php
											//Array -> Datos
										foreach ($Datos as $key => $value) {
											echo "<option value='".$key."'>".$value."</option>";
										}

									?>
								</select>
							 </div>


							 <div class="form-group col-md-6">
								<label>Tandas</label>
									<select class="form-control">
										<option>Tanda 1</option>
										<option>Tanda 2</option>
										<option>Tanda 3</option>
									</select>
							 </div>

									<div class="form-group col-md-6">
										<label>Hora de Ejecucion</label>
											<div class="input-group clockpicker">
											    <input type="text" class="form-control" value="18:00">
													<span class="input-group-addon">
												    	<span class="glyphicon glyphicon-time"></span>
										    		</span>
											</div>
									</div>

								<div class="form-group col-md-6">
								    <label>Tipos de ejercicios </label>
									    <select class="form-control">
											<option>Hombros</option>
											<option>Piernas</option>
											<option>Caderas</option>
											<option>Espalda</option>
										</select>
								</div>

								<div class="form-group col-md-6">
									<label> Videos </label>
										<select class="form-control">
											<option>Video 1</option>
											<option>Video 2</option>
											<option>Video 3</option>
											<option>Video 4</option>
										</select>
								</div>          
						
					
							</div><!-- /.panel body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
               	</div><!--/.row-->

                <div class="row">
                	<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">Video Preview</div>
								<div class="panel-video ">
						
						        <div class="video-container ">
									<iframe src="C:\Users\hbjjmarquez\Videos\video.mp2"
							      allowfullscreen="allowfullscreen" width="400" height="340"

							 	    frameborder="0">
									</iframe>
								</div>


								<br/><br/></div> <!-- /.panel body-->
						</div><!-- /.panel-->
					</div><!-- /.col-->
           		</div><!--/.row-->

          <div class="row">
                <div class="col-lg-12">
					<div class="Panel-Botones">
                         <div class="Panel-Botones-Guardar col-lg-6 col-lg-offset-9">
                   				<input type="submit" class="btn btn-info" value="Aceptar">
                   				<button type="button" class="btn btn-danger">Cancelar</button>
           			     </div> 
					</div>
				</div>
           	</div>



			<div class="col-sm-12">
				<p class="back-link"><a ">Janfry Marquez </a></p>
			</div>
		</div>
	</div><!-- /.row -->
	</div><!--/.main-->
<script src="js/jquery-1.11.1.min.js"></script>

	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="dist/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker({
    placement: 'top',
    align: 'left',
    donetext: 'Done'
});
</script>

<script type="text/javascript">
		$(document).ready(function(){
$(".select2").select2();

		});
			
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="assets/js/highlight.min.js"></script>
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>
</body>
</html>
