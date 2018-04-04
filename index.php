  <?php

session_start();
if (isset($_SESSION['userlog'])) {
    $fechaGuardada = $_SESSION['ultimoAcceso'];
    $idUsuario = $_SESSION['IdUsuarioActual'];
    $permiso = $_SESSION['Permiso'];
    switch ($_SESSION['Permiso']) {
        case '2':
            header('Location:Vista/charts.php');

            break;
        case '4':
            header('Location:Vista/CompleteEncuesta.php');

            break;
        default:
            //header('Location:index.php');
            break;
    }

    $ahora = date('Y-n-j H:i:s');
    if ('SI' !== $_SESSION['autentificado']) {
        header('Location:Vista/login.php');

        return false;
    }
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));
    if ($tiempo_transcurrido >= 1200) {
        //1200 milisegundos = 1200/60 = 20 Minutos...
        session_destroy();
        header('Location:Vista/login.php');

        return false;
    }
    $_SESSION['ultimoAcceso'] = $ahora;
} else {
    header('Location:Vista/login.php');

    return false;
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
    <link href="Vista/css/select2.min.css" rel="stylesheet">
    <link href="Vista/css/jquery-ui.min.css" rel="stylesheet">
    <link href="Vista/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="Vista/css/sweetalert.css">
    <script src="Vista/js/jquery.min.js"></script>
     <script src="Vista/js/jquery-ui.min.js"></script>
    <script src="Vista/js/bootstrap.min.js"></script>
    <script src="Vista/js/select2.min.js"></script>

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


                      <?php

switch ($permiso) {
    case '2':
        echo '<li><a href="Vista/charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>
        <li><a href="Vista/logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

        break;
    case '3':

        echo '
    <li ><a href="index.php"><em class="fas fa-home">&nbsp;</em> Inicio</a></li>
    <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
    <em class="fas fa-tachometer-alt">&nbsp;</em> Encuesta <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
    </a>
    <ul class="children collapse" id="sub-item-2">
    <li><a href="Vista/CompleteEncuesta.php">
    <em class="icon-share-alt">&nbsp;</em> Llenar Encuesta
    </a></li>
    <li><a href="Vista/FormularioEncuesta.php">
    <em class="far fa-plus-square">&nbsp;</em> Crear Encuesta
    </a></li>
    </ul>
    </li>

    <li><a href="Vista/charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>
     <li><a href="Vista/logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

        break;
    default:
        echo ' <li ><a href="index.php"><em class="fas fa-home">&nbsp;</em> Inicio</a></li>

        <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
        <em class="fas fa-tachometer-alt">&nbsp;</em> Encuesta <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
        </a>
        <ul class="children collapse" id="sub-item-2">
        <li><a href="Vista/CompleteEncuesta.php">
        <em class="icon-share-alt">&nbsp;</em> Llenar Encuesta
        </a></li>
        <li><a href="Vista/FormularioEncuesta.php">
        <em class="far fa-plus-square">&nbsp;</em> Crear Encuesta
        </a></li>
        </ul>
        </li>


  <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                          <em class="fas fa-cogs">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                      </a>



                    <ul class="children collapse" id="sub-item-1">
                           <li><a class="" href="Vista/ModificarUsuario.php">
                                   <span class="fas fa-user"></span> Usuarios
                               </a></li>
                           <li><a class="" href="Vista/Clientes.php">
                                   <span class="glyphicon glyphicon-usd"></span> Clientes
                               </a></li>

                           <li><a class="" href="#">
                                   <span class="glyphicon glyphicon-shopping-cart"></span> Vendedores
                               </a></li>
                           <li><a class="" href="#">
                                   <span class="glyphicon glyphicon-eye-open"></span> Supervidores
                               </a></li>
                           <li><a class="" href="#">
                                   <span class="fa fa-line-chart"></span> Encuesta
                               </a></li>
                      </ul>
                  </li>

  <li><a href="Vista/charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>

        <li><a href="Vista/logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

        break;
}

?>






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





<div class="container">

  <div id="EncuestaOpciones">
        <ul class="ulMenu">
        </ul>
  </div>

  <div class="row">
    <div align="center">
      <button class="btn btn-default filter-button active" data-filter="all">Todas</button>
  <?php
$sql = 'SELECT * FROM  tbl_encuesta_cabecera WHERE CreadoPorUsuarioId = :Usuario';
$resultado = $base->prepare($sql);
$resultado->execute([':Usuario' => $idUsuario]);
$numero_registro = $resultado->rowCount();
if (0 !== $numero_registro) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<button class="btn btn-default filter-button" data-filter="F'.$registro['SubTipoEncuenta'].'">'.$registro['SubTipoEncuestaDetalle'].'</button>';
    }
}
$resultado->closeCursor();
?>



         </div>

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
        echo '<a href="Vista\EditarEncuesta.php?id='.$registro['IdEncuestaCabecera'].'"> <div  title="'.$registro['NombreEncuesta'].'" name="'.$registro['NombreEncuesta'].'" class="gallery_product col-lg-3 col-md-3 col-sm-3 col-xs-6 filter F'.$registro['SubTipoEncuenta'].'" id="'.$registro['IdEncuestaCabecera'].'">
          <img src="Vista/img/EncuestaImagen.png" class="img-responsive" alt="" >


             <div class="Encuesta-iten-Name">'.$registro['NombreEncuesta'].'</div></a>
           <div class="Encuesta-iten-modificado"><i class="fas fa-edit"></i>Modificado '.$fecha.'
           <div name="'.$registro['NombreEncuesta'].'" class="Mas-Opciones" id="'.$registro['IdEncuestaCabecera'].'"><i class="fas fa-ellipsis-v fa-sm"></i></div></div>
        </div>';
    }
    $resultado->closeCursor();
}
?>



</div>
</div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">

          <div class="modal-CompartirHeader">


            <div class='ModalEncuestName '> </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </div>
        <div class="modal-body">
          <form>
 <center><div id="CargandoPagina"></div></center>

            <div class="form-group ClienteOption">
<input type="radio" id="USuarioHB" name="Cliente"  checked value="TU">Todo los usuarios</br>

<input type="radio" id="Departamento" name="Cliente"  value="CE">Por departamento</br>
<input type="radio" id="Heladerias" name="Cliente" value="TH">Todas las heladerias </br>

<input type="radio" id="ClienteOpction" name="Cliente"  value="CE">Clientes en especifico</br>


</div>
<div class="form-group Departamento-group">
  <label for="recipient-name" class="col-form-label">Departamento a ser evaluado (*):</label></br>
  <span id="iconForm" class="form-control-feedback Span_Clientes "></span>

  <select class="DepartamentoSelect select2" id="DepartamentoSelect" style="width: 100%" multiple="multiple">



    <?php
$sql2 = 'SELECT * FROM  tbl_departamentos WHERE Activo = :activo';
$resultado = $base->prepare($sql2);
$resultado->execute([':activo' => 1]);

while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
    echo '<option  value="'.$registro['IdDepartamento'].'/D">'.$registro['Departamento'].'</option>';
}
$resultado->closeCursor();
?>
              </select>
              <div class="Clientes_error error"></div>
            </div>



            <div class="form-group  Cliente-group">
              <label for="recipient-name" class="col-form-label">Cliente a ser evaluado (*):</label></br>
              <span id="iconForm" class="form-control-feedback Span_Clientes "></span>

              <select class="ClienteSelect selet2" id="ClienteSelect" style="width: 100%" multiple="multiple">



                <?php
$fecha = '';

echo '</optgroup>   <optgroup label="Usuarios">';
$sql = 'SELECT * FROM  tbl_clientes WHERE Activo = :activo';
$resultado = $base->prepare($sql);
$resultado->execute([':activo' => 1]);

while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
    echo '<option  value="'.$registro['IdClientes'].'/U">'.$registro['NombreCliente'].'</option>';
}
echo '</optgroup>';

echo '</optgroup>   <optgroup label="HELADERIAS">';
$sql = 'SELECT * FROM tbl_localidades WHERE Activo = :activo';
$resultado = $base->prepare($sql);
$resultado->execute([':activo' => 1]);

while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
    echo '<option  value="'.$registro['COD_UNIDAD'].'/H">'.$registro['NOM_UNIDAD'].'</option>';
}
echo '</optgroup>';

$resultado->closeCursor();
?>
              </select>
              <div class="Clientes_error error"></div>
            </div>
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

            <div class="form-group Evaluado-group">
              <label for="recipient-name" class="col-form-label">Evaluador (*):</label></br>
              <span id="iconForm" class="form-control-feedback Span_Evaluador "></span>

              <select class="EvaludarSelec" id="EvaludarSelec" style="width: 100%" multiple="multiple">


                <?php
$fecha = '';
$sql = 'SELECT * FROM  tbl_users WHERE Activo = :activo';
$resultado = $base->prepare($sql);
$resultado->execute([':activo' => 1]);

while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
    echo '<option  value="'.$registro['IdUsuario'].'">'.$registro['Nombre'].'</option>';
}
$resultado->closeCursor();
?>
              </select>
              <div class="Error_Evaluador error"></div>
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
        <button type="button" class="btn btn-secondary MymodalClose" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Enviar</button>
      </div>
    </div>
  </div>
</div>

   <center><div id="CargandoPagina"></div></center>

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
    <button type="button" class="btn btn-secondary UrlCopiadoClose" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Enviar</button>
  </div>
</div>
</div>
</div>

  <!-- Mode -->





      </div><!--/.row-->



    <script src="Vista/js/chart.min.js"></script>
    <script src="Vista/js/chart-data.js"></script>

    <script src="Vista/js/fontawesome-all.js"></script>
<script>


$(document).ready(function(){


  $(".Cliente-group").hide();
  $(".Departamento-group").hide();

  $( '#USuarioHB, #Heladerias').on( 'click', function() {
    if( $(this).is(':checked') ){
      $('.DepartamentoSelect').val(null).trigger('change');
      $('.ClienteSelect').val(null).trigger('change');
  $(".Cliente-group").hide();
  $(".Departamento-group").hide();


    }
});


$('#ClienteOpction').on( 'click', function() {
  if( $(this).is(':checked') ){
    $('#DepartamentoSelect').val(null).trigger('change');
      $(".Departamento-group").hide();
$(".Cliente-group").show();

  }
});

$('#Departamento').on( 'click', function() {
  if( $(this).is(':checked') ){
    $('.ClienteSelect').val(null).trigger('change');
      $(".Cliente-group").hide();
$(".Departamento-group").show();

  }
});

$('.UrlCopiadoClose').on('click', function() {
  location.reload();
});




  $(".ClienteSelect").select2({
      width: 'resolve'
  });

  $(".DepartamentoSelect").select2({
      width: 'resolve'
  });

  $('.EvaludarSelec').select2({
      width: 'resolve'
  });

  //Ocultamos el menú al cargar la página
  $("#EncuestaOpciones").hide();

  /* mostramos el menú si hacemos click derecho
  con el ratón */
  $( ".gallery_product" ).bind( "contextmenu", function(e) {
    encuestaId= $(this).attr("id");
    nombreEncues= $(this).attr('name');

    var posicion = $(this).position();
    $(".ulMenu").html('<li class="liMenu" id="Editar"><a class="btn btn-primary" href="Vista/EditarEncuesta.php?id='+encuestaId+'"><i class="fas fa-edit fa-lg"></i>&nbsp;Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li><li class="liMenu" id="Compartir"><button type="button" class="btn btn-info btCompartirEncc" data-toggle="modal" data-target="#myModal"><i class="fas fa-share-alt fa-lg"></i>&nbsp;Compartir</button></li> <li class="liMenu" id="Eliminar"><a class="btn btn-danger" href="#"><i class="fas fa-trash-alt fa-lg"></i>&nbsp;Eliminar &nbsp;&nbsp;&nbsp;  </a></li>');
    $('.ModalEncuestName').html('<h5> <span class="modal-title">Enviar Vínculo para </span>  ' +nombreEncues+'</h5> ');
    $('.modalbottons').html('<button type="button" id="'+encuestaId+'" class="boton getUrlEncuesta"  onclick="GetEncuestaUrl()" ><i class="fas fa-link fa-lg"></i></button></br><label for="message-text"  id=""class="col-form-label GetURL">Copiar enlace:</label>')
    $("#EncuestaOpciones").css({'display':'block', 'left': posicion.left+6, 'top': posicion.top+40});
    return false;
  });

$(".Mas-Opciones").click("contextmenu", function(e) {
  encuestaId= $(this).attr("id");
  nombreEncues= $(this).attr('name');

  var posicion = $(this).position();
  $(".ulMenu").html('<li class="liMenu" id="Editar"><a class="btn btn-primary" href="Vista/EditarEncuesta.php?id='+encuestaId+'"><i class="fas fa-edit fa-lg"></i>&nbsp;Editar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li><li class="liMenu" id="Compartir"><button type="button" class="btn btn-info btCompartirEncc" data-toggle="modal" data-target="#myModal"><i class="fas fa-share-alt fa-lg"></i>&nbsp;Compartir</button></li> <li class="liMenu" id="Eliminar"><a class="btn btn-danger" href="#"><i class="fas fa-trash-alt fa-lg"></i>&nbsp;Eliminar &nbsp;&nbsp;&nbsp;  </a></li>');
  $('.ModalEncuestName').html('<h5>'+nombreEncues+'</h5> ');
  $('.modalbottons').html('<button type="button" id="'+encuestaId+'" class="boton getUrlEncuesta"  onclick="GetEncuestaUrl()" ><i class="fas fa-link fa-lg"></i></button></br><label for="message-text"  id=""class="col-form-label GetURL">Copiar enlace:</label>')
  $("#EncuestaOpciones").css({'display':'block', 'left': posicion.left -180, 'top': posicion.top -160});
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
       $('.FechaExpiracion').html('<label for="recipient-name" class="col-form-label">Fecha de Expiración:</label><input type="text" placeholder="Especifique una fecha" class="form-control UrlDateExpire" id="datepicker">');
       $( "#datepicker" ).datepicker({ minDate: 0,
                                      changeMonth: true,
                                      changeYear: true });
         break;

        default:
        $('.FechaExpiracion').hide();
 break;
    }
  });




  $(".filter-button").click(function(){
         var value = $(this).attr('data-filter');

         if(value == "all")
         {

             $('.filter').show('1000');
         }
         else
         {

             $(".filter").not('.'+value).hide('3000');
             $('.filter').filter('.'+value).show('3000');

         }
     });

     if ($(".filter-button").removeClass("active")) {
 $(this).removeClass("active");
 }
 $(this).addClass("active");

});



function GetEncuestaUrl(){
  EncuestaId2 =$('.getUrlEncuesta').attr("id");
var mensaja = $('#message-text').val();
  var Cliente = $('#ClienteSelect').val();
  var Departamento = $('#DepartamentoSelect').val();
  var Evaluador = $('#EvaludarSelec').val();


if(Evaluador ==''){
Evaluador = null;
}
if(Cliente == '' && Departamento == ''  ){
  ClienteEvaluado = null;

}
 else if (Cliente != ''){
  ClienteEvaluado = Cliente;
}
else {
  ClienteEvaluado =Departamento;
}



    $.ajax({
      type: 'POST',
      url: 'Controlador/EncuestaControlador.php',
      data: {'GetUrlbyEncuestaId': $('.getUrlEncuesta').attr("id"),
      'FechaExpiracion': $('.UrlDateExpire').val(),
      'PermisoUrl': $('.PermisoCompartir').val(),
      'ClienteAEvaluar':ClienteEvaluado,
      'Evaluador':  Evaluador,
      'mensaje' :mensaja,
       'clienteoption' :$('input:radio[name=Cliente]:checked').val()},

 beforeSend: function(objeto) {
          $("#CargandoPagina").addClass('loader');
        },

      success: function(html){

         $('#ClienteSelect').val(null).trigger('change');
               $('#EvaludarSelec').val(null).trigger('change');
                $("#CargandoPagina").removeClass('loader');
                $('#myModal').modal('toggle');
                  $('#modalUrl').modal('show');

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
