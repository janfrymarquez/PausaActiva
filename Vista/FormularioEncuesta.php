<?php
ini_set("session.cookie_lifetime", "3600");
ini_set("session.gc_maxlifetime", "3600");
session_start();

if (!isset($_SESSION["userlog"])) {
    header("location:login.php");
}

require "../Modelo/Conexion.php";

$Conexion = new Conexion();
$base     = $Conexion->Conexion();

?>


<!DOCTYPE html>


<html>
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="img/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Analytic Soluction</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link rel="stylesheet" href="css/chosen.css">
        <link href="css/styles.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="assets/css/github.min.css">

        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    </head>
    <?php
require "header.php";
?>
    <body>

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#">
                            <em class="fa fa-home"></em>
                        </a></li>
                    <li class="active">Crear Encuesta</li>
                </ol>
            </div><!--/.row-->


            <form id= "formEncuesta" action="../Controlador/GuardarEncuesta.php" method="POST">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><input type="text" class="NombreEncuesta col-lg-12" name="NombreEncuesta" id="NombreEncuesta" placeholder="Escriba el nombre de la encuesta aqui" onfocusout = "ComprobaNombreEncuesta()">
                            </div>
                            <div class="panel-body">




                                <div class="form-group col-md-6">
                                    <label>Tipo de Ecnuesta</label>

                                    <select class="form-control" name="TipoEncuesta" id="TiposEncuestaID" >
                                        <option disabled selected value> -- Elija una opcion  -- </option>

                                        <?php
$sql       = "SELECT * FROM  tbl_tipo_encuesta";
$resultado = $base->prepare($sql);
$resultado->execute();

$numero_registro = $resultado->rowCount();

if ($numero_registro != 0) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $registro['IdTipoEncuesta'] . '">' . $registro['DescTipoEncuesta'] . '</option>';
    }
} else {
    echo '<option value=""> Tipo de encuesta no disponibles </option>';

}
?>

                                    </select>    <br>

                                </div>


                                <div class="form-group col-md-6" id="DivSubTipoEncuenta">
                                    <label> Sub Tipo de Encuesta </label>
                                    <select class="form-control" id= "SubTipoEncuenta" name="SubTipoEncuenta" >
                                        <option disabled selected value> -- Seleciones un tipo de encuesta -- </option>

                                    </select>    <br>
                                </div>



                                <div  class = "PreguntaBlock">

                                    <div id="row1">

                                        <div class= "form-group col-md-8">


                                            <input type="text"  id= "Preg1" name="Pregunta[]" placeholder="Introduzca la pregunta aqui" class="form-control">

                                        </div>

                                        <div class ="DivTipoDeRepuesta form-group col-md-3">

                                            <select  class="my-select form-control"  id="1" name="TipoDeRepuesta">
                                                <option disabled selected value> --Elija una opcion-- </option>

                                                <?php
$sql       = "SELECT * FROM  tbl_conf_repuesta";
$resultado = $base->prepare($sql);
$resultado->execute();
$numero_registro = $resultado->rowCount();

if ($numero_registro != 0) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $registro['IdConfiRepuesta'] . '" data-img-src="' . $registro['IconoConfiRepuesta'] . '">' . $registro['DescripConfiRepuesta'] . '</option>';
    }
} else {
    echo '<option value="">  Tipo de repuesta no disponibles </option>';
}
?>

                                            </select>

                                        </div>





                                        <div class="form-group col-md-12 " id="Rep1"> </div>

                                    </div>


                            </div>


                        </div>

                        <button type="button" name="add" id="add" class="btn btn-success agragarPreguntaBtn"> Agregar Pregunta </button>
                         <button  name="submit"  id="submit" class="btn btn-info pull-right enviarFormBtn">Crear Encuesta</button>
                    </div>

                </div>
            </form>







            <script src="js/jquery-1.11.1.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/chart.min.js"></script>
            <script src="js/chart-data.js"></script>
            <script src="js/simple-popup.js"></script>
            <script src="js/bootstrap-datepicker.js"></script>

            <script src="js/piexif.js"></script>
            <script src="js/fileinput.js"></script>
            <script src="js/custom.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
            <script src="js/ValidarExistencia.js"></script>
            <script type="js/text/javascript" src="assets/js/jquery.min.js"></script>
            <script type="js/text/javascript" src="assets/js/bootstrap.min.js"></script>
            <script type="js/text/javascript" src="dist/bootstrap-clockpicker.min.js"></script>
            <script src="js/chosen.jquery.js"></script>
            <script src="js/ImageSelect.jquery.js"></script>



            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
            <script type="text/javascript" src="assets/js/highlight.min.js"></script>
            <script type="text/javascript">
                hljs.configure({tabReplace: '    '});
                hljs.initHighlightingOnLoad();
            </script>



            <script>  // Script para agregar nuevas preguntas
            $(document).ready(function(){
           var i =2, j=1;
                 $('#add').click(function(){





                      $('.PreguntaBlock').append(' <div id ="row'+i+'"> <div   class= "form-group col-md-8"><input type="text" id="'+i+'" name="Pregunta[]" placeholder="Introduzca la pregunta aqui" class="form-control"></div> <div class ="DivTipoDeRepuesta form-group col-md-3"><select  class="my-select form-control" id="'+i+'" name="TipoDeRepuesta"><option disabled selected value> --Elija una opcion-- </option><?php
$sql       = "SELECT * FROM  tbl_conf_repuesta";
$resultado = $base->prepare($sql);
$resultado->execute();
$numero_registro = $resultado->rowCount();
if ($numero_registro != 0) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $registro['IdConfiRepuesta'] . '" data-img-src="' . $registro['IconoConfiRepuesta'] . '">' . $registro['DescripConfiRepuesta'] . '</option>';
    }
} else {
    echo '<option value="">  Tipo de repuesta no disponibles </option>';
}
?></select></div><div class ="form-group col-md-1"><button type="button" name="remove" id="'+i+'"  class="btn btn-danger btn_remove"><i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></button></div><div class="form-group col-md-12 "  class = "Repuesta" id="Rep'+i+'"> </div> </div>');

           i++;


                       $(".my-select").chosen({width:"100%"});
                 });
                 $(document).on('click', '.btn_remove', function(){
                      var button_id = $(this).attr("id");
                      $('#row'+button_id+'').remove();
                 });


           $(document).on('change', '.my-select', function(){

           var resp_id = $(this).attr("id");
            var TipoDeRepuestaID = $(this).val();

           switch (TipoDeRepuestaID) {
               case '1':
               j=1;

                   repuesta = '<i id="fa fa-circle-o" class="fa fa-circle-o fa-lg iconos'+resp_id+'" aria-hidden="true"></i>&nbsp;<input type="text" placeholder="Escriba una opcion" name="Opcion1[]" id="RadioOption'+resp_id+'" autocomolete="off" class="RespComentario"> <span> </span><button type="button" name="addCase1Opcion" id="'+resp_id+'"  class="btn_addOption btn btn-success">+</button>';





                   break;
               case '2':

               repuesta = ' <i id="fa fa-square-o" class="fa fa-square-o fa-lg iconos'+resp_id+'" aria-hidden="true "></i>&nbsp;<input type="text" placeholder="Escriba una opcion" autocomolete="off" name="Opcion2[]" class="RespComentario"> <span> </span><button type="button" name="addCase2Opcion" id="'+resp_id+'"  class="btn_addOption btn btn-success">+</button>';

                   break;
               case '3':
                    repuesta= '<textarea  autocomolete="off" name="comentarios" class="" rows="4" cols="60"></textarea>';
                   break;
               case '4':
               repuesta = '<div  onmouseover="showdiv(event,'+resp_id+');"onMouseOut="hiddenDiv()" style="display:table; font-weight: bold;"">Ejemplo:<br> </div><p>Del: <input type="number" value="1"  name="ValMinimo[]" id="ValMinimo'+resp_id+'">   Al: <input type="number" value="10" name="valMaximo[]" id="valMaximo'+resp_id+'"></p><div id="flotante"></div><br>';



                   break;
               case '5':
                   repuesta = '<div id="apDiv1"><table width="100%" border="0"><tr><?php
$sql       = "SELECT * FROM  tbl_repuesta_imagen";
$resultado = $base->prepare($sql);
$resultado->execute();
$numero_registro = $resultado->rowCount();
if ($numero_registro != 0) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<td><img id="ImagenRepuesta" src="' . $registro['ImagenRuta'] . '"></td><td width="20"></td>';
    }
} else {
    echo '<option value="">  Tipo de repuesta no disponibles </option>';
}
?></select></tr></table></div>';
                   break;
               case '6':
                    repuesta = '<ul class="fa-ul"><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Deficiente</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Regular</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Bueno</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Muy bueno</li></ul>';
                   break;
               case  '7':
                repuesta = '<ul class="fa-ul"><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Malo</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Regular</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Bueno</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Excelente</li></ul>';

                   break;


                   case  '8':
                  repuesta = '<ul class="fa-ul"><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;Si</li><li><i class="fa-li fa fa-circle-o fa-lg"></i>&nbsp;No</li></ul>';
                   break;



           }

           $('#Rep'+resp_id+'').html(repuesta);



             });




             $(document).on('click', '.btn_addOption', function(){

           var case1_id = $(this).attr("id");

     var icono = $('.iconos'+case1_id+'').attr("id");

if (icono === "fa fa-circle-o"){
var opcion = "Opcion1[]";
}else {
  var opcion= "Opcion2[]";
}

console.log(opcion);

           j++;
           $('#Rep'+case1_id+'').append(' <div id ="BlocResp'+case1_id+''+"A"+''+j+'"><div id="'+j+'"  class ="case'+case1_id+'"><i class="'+icono+' fa-lg" aria-hidden="true"></i> <input type="text" autocomolete="off" name="'+opcion+'" placeholder="Escriba una opcion" class="RespComentario"> <span> </span><button type="button" name="remove" id="'+j+'"  class="btn_removerOption'+case1_id+''+"r"+''+j+' btn btn-danger"><i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></button> </div> </div>');

           var tipoRepista = "";

                       $('.btn_removerOption'+case1_id+''+"r"+''+j+'').hide();


                       $('.case'+case1_id+'').mouseover (function() {

                            var remo_id = $(this).attr("id");



                            $('.btn_removerOption'+case1_id+''+"r"+''+remo_id+'').show();

                               $('.btn_removerOption'+case1_id+''+"r"+''+remo_id+'').click(function(){

                                   $('#BlocResp'+case1_id+''+"A"+''+remo_id+'').remove();

                                });
                       });



                                 $('.case'+case1_id+'').mouseleave (function() {

                                     var remo_id = $(this).attr("id");
                                 $('.btn_removerOption'+case1_id+''+"r"+''+remo_id+'').hide();

                                 });



           });



            });   //Fin script para agregar nuevas preguntas
            </script>


            <script>//Script para cargar los suptipos de encuesta



                $(document).ready(function() {

                $("#TiposEncuestaID").on('change', function(){

                    var TiposEncuestaID = $(this).val();


                if (TiposEncuestaID){

                    $.ajax({
                       type: 'POST',
                       url: '../Controlador/EncuestaControlador.php',
                       data: 'TiposEncuestaID=' +TiposEncuestaID,
                       success: function(html){


                             if(html== 'NoDisponible'){
                              $('#DivSubTipoEncuenta').hide();
                             }

                             else {
                                $('#DivSubTipoEncuenta').show();
                             $('#SubTipoEncuenta').html(html);

                             }
                        }

                        });


            }else {
                $('#SubTipoEncuenta').html('option value=""> --Seleciones un tipo de encuentas-- </option>')
            }

            });

            });


            </script>



            <script>
                /**
                * Funcion que muestra el div en la posicion del mouse
                */
                function showdiv(event,ID)
                {



            var ValorMini= $('#ValMinimo'+ID+'').val();
            var ValorMaxi= $('#valMaximo'+ID+'').val();



                    document.getElementById('flotante').innerHTML="¿Del "+ValorMini+" al "+ValorMaxi+" que tanto ....?";

                    document.getElementById('flotante').style.display='block';
                    return;
                }




                function hiddenDiv()
                {
                    document.getElementById('flotante').style.display='none';
                }








            </script>



            <script type="text/javascript">
                    $(document).ready(function(){
            $(".select2").select2();

            $('#DivSubTipoEncuenta').hide();  });

            </script>


            <script>
             $(".my-select").chosen({width:"100%"});
            </script>






    </body>
</html>
