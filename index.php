  <?php
  ini_set('session.cookie_lifetime', '3600');
  ini_set('session.gc_maxlifetime', '3600');
  session_start();
  $idUsuario = $_SESSION['IdUsuarioActual'];
  if (!isset($_SESSION['userlog'])) {
      header('location:Vista/login.php');
  }

  require 'Modelo/Conexion.php';

  $Conexion = new Conexion();
  $base = $Conexion->Conexion();

  ?>



  <html>
  <head>
  	<meta charset="utf-8">
  	 <link rel="icon" href="Vista/img/favicon.ico">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Analytic Soluction</title>
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

                      <a class="navbar-brand" href="#"><span>Encuesta </span> </span> Analytic Soluction</a>

                  </div>
              </div><!-- /.container-fluid -->
          </nav>
          <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
              <div class="profile-sidebar">
                  <div class="profile-userpic">
                      <img src="Vista/img/<?php echo $_SESSION['profileimg']; ?> " class="img-responsive" alt="">
                  </div>
                  <div class="profile-usertitle">

                      <?php
  $usar = $_SESSION['userlog'];

  echo '<div class="profile-usertitle-name"> '.'Hola'.'  '.$usar.' </div>';
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


  			<li ><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>

  			<li><a href="Vista/FormularioEncuesta.php"><em class="glyphicon glyphicon-folder-open">&nbsp;</em> Crear Encuesta </a></li>


  <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                          <em class="glyphicon glyphicon-cog">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                      </a>
                      <ul class="children collapse" id="sub-item-1">
                          <li><a class="" href="Vista/ModificarUsuario.php">
                                  <span class="fa fa-user-plus">&nbsp;</span>Usuarios
                              </a></li>
                          <li><a class="" href="Vista/ModificarUsuario.php">
                                  <span class="glyphicon glyphicon-usd">&nbsp;</span>Clientes
                              </a></li>
                          <li><a class="" href="#">
                                  <span class="glyphicon glyphicon-shopping-cart">&nbsp;</span>Vendedores
                              </a></li>
                          <li><a class="" href="#">
                                  <span class="glyphicon glyphicon-eye-open">&nbsp;</span>Supervidores
                              </a></li>
                          <li><a class="" href="#">
                                  <span class="fa fa-line-chart">&nbsp;</span>Encuesta
                              </a></li>
                      </ul>
                  </li>

  <li><a href="Vista/charts.php"><em class="fa fa-bar-chart">&nbsp;</em> Reportes</a></li>

  			<li><a href="Vista/logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
  		</ul>
  	</div><!--/.sidebar-->

  	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  		<div class="row">
  			<ol class="breadcrumb">
  				<li><a href="index.php">
  					<em class="fa fa-home"></em>
  				</a></li>
  				<li class="active">Dashboard</li>
  			</ol>
  		</div><!--/.row-->

<br>
      <div class="row">
          <div class="col-lg-12 Filtro">
          <div class="form-group col-md-3 pull-right">
<label for="select">Filtrar por:</label><select id="filtro" name="fetchby" class="form-control" >
      <option  value="FechaCreacion">Fecha</option>
      <option selected value="NombreEncuesta">Nombre</option>


  </select>

          </div>



          </div>
    </div>

    <div id="EncuestaOpciones">
          <ul class="ulMenu">

          </ul>
    </div>

<div class="Encuesta">
  <div class="Div_Encuesta">
<section class="encuesta-list">
  <?php
  $fecha = '';
  $sql = 'SELECT * FROM  tbl_encuesta_cabecera WHERE CreadoPorUsuarioId = :Usuario';
  $resultado = $base->prepare($sql);
  $resultado->execute([':Usuario' => $idUsuario]);
  $numero_registro = $resultado->rowCount();
  if (0 !== $numero_registro) {
      while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
          if (null === $registro['FechaModificacion']) {
              $fecha = $registro['FechaCreacion'];
          } else {
              $fecha = $registro['FechaModificacion'];
          }
          echo'  <div class="encuesta-item encuestaList" id="'.$registro['IdEncuestaCabecera'].'">
					<img src="Vista/img/EncuestaImagen.png" alt="" >

					<a  href="Vista\EditarEncuesta.php?id='.$registro['IdEncuestaCabecera'].'">'.$registro['NombreEncuesta'].'</a>

           <h6 class="MenuEncuesta"><i class=" fa fa-pencil-square-o"></i> &nbsp; Modificado '.$fecha.'</h6>
				</div>';
      }
  }
   ?>


</section>
</div>
</div>






  		</div><!--/.row-->


  	<script src="Vista/js/jquery-1.11.1.min.js"></script>
  	<script src="Vista/js/bootstrap.min.js"></script>
  	<script src="Vista/js/chart.min.js"></script>
  	<script src="Vista/js/chart-data.js"></script>
  	<script src="Vista/js/bootstrap-datepicker.js"></script>
  	<script src="Vista/js/custom.js"></script>
<script>


$(document).ready(function(){

            //Ocultamos el menú al cargar la página
            $("#EncuestaOpciones").hide();

            /* mostramos el menú si hacemos click derecho
            con el ratón */
            $( ".encuestaList" ).bind( "contextmenu", function(e) {
              encuestaId= $(this).attr("id");

              var posicion = $(this).position();
              $(".ulMenu").html('<li class="liMenu" id="Editar"><a class="btn btn-primary" href="Vista/EditarEncuesta.php?id='+encuestaId+'"><i class="fa fa-pencil fa-lg"></i>&nbsp;Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </a></li><li class="liMenu" id="Compartir"><a class=" btn btn-info" href="Vista/EncuestaView/index.php?id='+encuestaId+'"><i class="fa fa-share-alt fa-lg"></i>&nbsp;Compartir</a></li><li class="liMenu" id="Eliminar"><a class="btn btn-danger" href="#"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Eliminar &nbsp;&nbsp;&nbsp;  </a></li>');

                  $("#EncuestaOpciones").css({'display':'block', 'left': posicion.left+55, 'top': posicion.top+50});
                  return false;
            });


            //cuando hagamos click, el menú desaparecerá
            $( document).bind( "click", function(e) {
                  if(e.button == 0){
                        $("#EncuestaOpciones").css("display", "none");
                  }
            });


            //si pulsamos escape, el menú desaparecerá
            $(document).keydown(function(e){
                  if(e.keyCode == 27){
                        $("#EncuestaOpciones").css("display", "none");
                  }
            });

            //controlamos los botones del menú
            $("#EncuestaOpciones").click(function(e){

                  // El switch utiliza los IDs de los <li> del menú
                  switch(e.target.id){
                        case "copiar":
                              alert("copiado!");
                              break;
                        case "mover":
                              alert("movido!");
                              break;
                        case "eliminar":
                              alert("eliminado!");
                              break;
                  }

            });


      });

</script>

  </body>
  </html>
