<!DOCTYPE html>
<?php

session_start();

if (!isset($_SESSION["userlog"])) {

    header("location:Vista/login.php");

}

?>




<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pausa Activa HB</title>
	<link href="Vista/css/bootstrap.min.css" rel="stylesheet">
	<link href="Vista/css/font-awesome.min.css" rel="stylesheet">
	<link href="Vista/css/datepicker3.css" rel="stylesheet">
	<link href="Vista/css/styles.css" rel="stylesheet">

	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
			<li class="active"><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li><a href="Vista/charts.php"><em class="fa fa-bar-chart">&nbsp;</em> Estadistica</a></li>
			<li><a href="Vista/elements.php"><em class="fa fa-toggle-off">&nbsp;</em> Administrar P Activa </a></li>


<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li><a class="" href="Vista/ModificarUsuario.php">
						<span class="fa fa-user-plus">&nbsp;</span> Configurar Usuarios
					</a></li>
					<li><a class="" href="Vista/ModificarUsuario.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Configurar Empleados
					</a></li>
					<li><a class="" href="#">
						<span class="fa fa-arrow-right">&nbsp;</span> Departamentos
					</a></li>
				</ul>
			</li>



			<li><a href="Vista/logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Estadistica de los usuarios

						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>New Orders</h4>
						<div class="easypiechart" id="easypiechart-blue" data-percent="92" ><span class="percent">92%</span></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Comments</h4>
						<div class="easypiechart" id="easypiechart-orange" data-percent="65" ><span class="percent">65%</span></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>New Users</h4>
						<div class="easypiechart" id="easypiechart-teal" data-percent="56" ><span class="percent">56%</span></div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4>Visitors</h4>
						<div class="easypiechart" id="easypiechart-red" data-percent="40" ><span class="percent">40%</span></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->




		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="Vista/js/jquery-1.11.1.min.js"></script>
	<script src="Vista/js/bootstrap.min.js"></script>
	<script src="Vista/js/chart.min.js"></script>
	<script src="Vista/js/chart-data.js"></script>
	<script src="Vista/js/easypiechart.js"></script>
	<script src="Vista/js/easypiechart-data.js"></script>
	<script src="Vista/js/bootstrap-datepicker.js"></script>
	<script src="Vista/js/custom.js"></script>
	<script>
		window.onload = function () {
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
	responsive: true,
	scaleLineColor: "rgba(0,0,0,.2)",
	scaleGridLineColor: "rgba(0,0,0,.05)",
	scaleFontColor: "#c5c7cc"
	});
};
	</script>

</body>
</html>