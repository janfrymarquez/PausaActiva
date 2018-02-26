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
    <link href="Vista/css/fontawesome-all.css" rel="stylesheet">
  	<link href="Vista/css/font-awesome.min.css" rel="stylesheet">
  	<link href="Vista/css/datepicker3.css" rel="stylesheet">
  	<link href="Vista/css/styles.css" rel="stylesheet">
      <link rel="stylesheet" href="Vista/css/sweetalert.css">
    <script src="Vista/js/jquery.min.js"></script>
    <script src="Vista/js/bootstrap.min.js"></script>
    <script src="Vista/js/sweetalert.js"></script>
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


  			<li ><a href="index.php"><em class="fas fa-home">&nbsp;</em> Inicio</a></li>

  			<li><a href="Vista/FormularioEncuesta.php"><em class="far fa-plus-square">&nbsp;</em> Crear Encuesta </a></li>


  <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                          <em class="fas fa-cogs">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                      </a>
                      <ul class="children collapse" id="sub-item-1">
                          <li><a class="" href="Vista/ModificarUsuario.php">
                                  <span class="fas fa-user">&nbsp;</span>Usuarios
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

  <li><a href="Vista/charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>

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


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">

          <div class="modal-CompartirHeader">

            <h4 class="modal-title">Enviar Vínculo</h4>
            <div class='ModalEncuestName'> </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Permiso:</label></br>
            <select class="form-control PermisoCompartir" name="Permisos">


              <?php
              $fecha = '';
              $sql = 'SELECT * FROM  tbl_permiso_url WHERE Activo = :activo';
              $resultado = $base->prepare($sql);
              $resultado->execute([':activo' => 1]);

            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo '<option  value="'.$registro['Values'].'">'.$registro['Permiso'].'</option>';
            }
                $resultado->closeCursor();
                ?>
            </select>
            </div>

            <div class="form-group FechaExpiracion"></div>

            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Correo Electronico:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Mensaje(opcional):</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>

     <div class="buttonUrl">
            <div class="form-group col-md-1 modalbottons"></div>

    </div>

          </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal URLCopiado-->

<div class="modal fade" id="modalUrl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
  <div class="modal-header">

      <div class="modal-CompartirHeader">

        <h4 class="modal-title">Se ha generado el enlace a:</h4>
        <div class='ModalEncuestName'> </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

      </div>

    </div>

    <div class="modal-body">
      <div class="UrlHeader"></div>
      <div class="UrlBody">
        <div class="URLCopiado input-group"></div>
        </div>

      </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Enviar</button>
  </div>
</div>
</div>
</div>

  <!-- Mode -->


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
          echo'  <div name="'.$registro['NombreEncuesta'].'" class="encuesta-item encuestaList" id="'.$registro['IdEncuestaCabecera'].'">
					<img src="Vista/img/EncuestaImagen.png" alt="" >

					<a  href="Vista\EditarEncuesta.php?id='.$registro['IdEncuestaCabecera'].'">'.$registro['NombreEncuesta'].'</a>

           <h6 class="MenuEncuesta"><i class="fas fa-edit"></i> &nbsp; Modificado '.$fecha.'</h6>
				</div>';
      }
      $resultado->closeCursor();
  }
   ?>


</section>
</div>
</div>






  		</div><!--/.row-->



  	<script src="Vista/js/chart.min.js"></script>
  	<script src="Vista/js/chart-data.js"></script>
  	<script src="Vista/js/bootstrap-datepicker.js"></script>
  	<script src="Vista/js/custom.js"></script>
    <script src="Vista/js/fontawesome-all.js"></script>
<script>


$(document).ready(function(){

  //Ocultamos el menú al cargar la página
  $("#EncuestaOpciones").hide();

  /* mostramos el menú si hacemos click derecho
  con el ratón */
  $( ".encuestaList" ).bind( "contextmenu", function(e) {
    encuestaId= $(this).attr("id");
    nombreEncues= $(this).attr('name');

    var posicion = $(this).position();
    $(".ulMenu").html('<li class="liMenu" id="Editar"><a class="btn btn-primary" href="Vista/EditarEncuesta.php?id='+encuestaId+'"><i class="fas fa-edit fa-lg"></i>&nbsp;Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li><li class="liMenu" id="Compartir"><button type="button" class="btn btn-info btCompartirEncc" data-toggle="modal" data-target="#myModal"><i class="fas fa-share-alt fa-lg"></i>&nbsp;Compartir</button></li> <li class="liMenu" id="Eliminar"><a class="btn btn-danger" href="#"><i class="fas fa-trash-alt fa-lg"></i>&nbsp;Eliminar &nbsp;&nbsp;&nbsp;  </a></li>');
    $('.ModalEncuestName').html('<h5>'+nombreEncues+'</h5> ');
    $('.modalbottons').html('<button type="button" id="'+encuestaId+'" class="boton getUrlEncuesta" data-dismiss="modal"  data-toggle="modal" data-target="#modalUrl" onclick="GetEncuestaUrl()" ><i class="fas fa-link fa-lg"></i></button></br><label for="message-text"  id=""class="col-form-label GetURL">Copiar enlace:</label>')
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


  $(document).on('change', '.PermisoCompartir', function(){

    var  permiso_url = $(this).val();
    switch (permiso_url) {

       case '3':
       case '4':
       $('.FechaExpiracion').show();
       $('.FechaExpiracion').html('<label for="recipient-name" class="col-form-label">Fecha de Expiración:</label><input type="text" class="form-control UrlDateExpire" id="datepicker">');
        $( "#datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");
         break;

        default:
        $('.FechaExpiracion').hide();
 break;
    }
  });

});

      function GetEncuestaUrl(){
        EncuestaId2 =$('.getUrlEncuesta').attr("id");

        $.ajax({
          type: 'POST',
          url: 'Controlador/EncuestaControlador.php',
          data: {'GetUrlbyEncuestaId': $('.getUrlEncuesta').attr("id"),
                 'FechaExpiracion': $('.UrlDateExpire').val(),
                 'PermisoUrl': $('.PermisoCompartir').val()},

          success: function(html){
            $('.URLCopiado').html('<input type="text" id="txtUrlCopy" class="form-control" value="'+html+'"> <span class="input-group-btn"><button class="btn btn-btn-primary btnCopiar " onclick="copiarAlPortapapeles()" type="button">Copiar</button></span>');

          }
        });

      }


  function copiarAlPortapapeles() {

    var value=$.trim($("#txtUrlCopy").val());

      if(value.length>0){
  $('.UrlHeader').show();
  $('#txtUrlCopy').select();
$('.UrlHeader').html('<img src="Vista/img/Icon/img_check_ok.jpg" height="80" width="80" align="middle">')
  document.execCommand("copy");
}
else{
    swal("Opps!", "No se ha podido Generar el Enlance!", "warning");
  $('.UrlHeader').hide();

}
}

</script>

  </body>
  </html>
