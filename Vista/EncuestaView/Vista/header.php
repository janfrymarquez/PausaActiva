
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/fontawesome-all.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/sweetalert.css">
<link rel="stylesheet" href="css/chosen.css">
<link rel="stylesheet" href="css/jquery.dataTables.min.css">
<script src="js/jquery.dataTables.min.js"></script>

<link rel="icon" href="img/favicon.ico">
  <link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">


<script src="js/ImageSelect.jquery.js"></script>


<script src="js/jquery.validate.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/chosen.jquery.js"></script>
  <script src="js/sweetalert.js"></script>
<script src="js/ValidarExistencia.js"></script>
<script type="text/javascript" src="assets/js/highlight.min.js"></script>
<script type="text/javascript">
    hljs.configure({tabReplace: '    '});
    hljs.initHighlightingOnLoad();
</script>

<?php $usar = $_SESSION['userlog'];
   $email = $_SESSION['email']; ?>



  <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
           <div class="container-fluid">
               <div class="navbar-header">

                   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>


                       <span class="icon-bar"></span></button>

                    <a class="navbar-brand" href="../index.php"><span> Bon</span> </span> Encuesta</a>

                   <ul class="navbar-right navbar-nav ">
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <span class="glyphicon glyphicon-user"></span>
                          <strong><?php echo $usar; ?></strong>
                          <span class="glyphicon glyphicon-chevron-down"></span>
                      </a>
                      <ul class="dropdown-menu">
                          <li>
                              <div class="navbar-login">
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <p class="text-center">
                                            <img src="img/<?php echo $_SESSION['profileimg']; ?> " class="img-responsive" alt="">
                                          </p>
                                      </div>
                                      <div class="col-lg-8">
                                          <p class="text-left"><strong><?php echo $usar; ?></strong></p>
                                          <p class="text-left small"><?php echo $email; ?></p>
                                          <p class="text-left">
                                            <a href="ActualizarPerfil.php" class="btn btn-primary btn-block btn-sm">Actualizar Datos</a>
                                          </p>
                                      </div>
                                  </div>
                              </div>
                          </li>
                          <li class="divider"></li>
                          <li>
                              <div class="navbar-login navbar-login-session">
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <p>
                                              <a  href="logout.php" class="btn btn-danger btn-block">Cerrar Sesion</a>
                                          </p>
                                      </div>
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </li>
                </ul>
               </div>


           </div><!-- /.container-fluid -->
       </nav>
       <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
           <div class="profile-sidebar">
               <div class="profile-userpic">
                   <img src="img/<?php echo $_SESSION['profileimg']; ?> " class="img-responsive" alt="">
               </div>
               <div class="profile-usertitle">

                   <?php

$permiso = $_SESSION['Permiso'];

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
        echo '<li><a href="charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>
        <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

        break;
    case '3':

        echo '
    <li ><a href="../index.php"><em class="fas fa-home">&nbsp;</em> Inicio</a></li>
    <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
    <em class="fas fa-tachometer-alt">&nbsp;</em> Encuesta <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
    </a>
    <ul class="children collapse" id="sub-item-2">
    <li><a href="CompleteEncuesta.php">
    <em class="icon-share-alt">&nbsp;</em> Llenar Encuesta
    </a></li>
    <li><a href="FormularioEncuesta.php">
    <em class="far fa-plus-square">&nbsp;</em> Crear Encuesta
    </a></li>
    </ul>
    </li>

    <li><a href="charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>
     <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

        break;
        case '4':
        echo ' <li ><a href="CompleteEncuesta.php"><em class="fas fa-home">&nbsp;</em> Completar Encuesta</a></li>
          <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

          break;
    default:
        echo ' <li ><a href="../index.php"><em class="fas fa-home">&nbsp;</em> Inicio</a></li>

        <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
        <em class="fas fa-tachometer-alt">&nbsp;</em> Encuesta <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
        </a>
        <ul class="children collapse" id="sub-item-2">
        <li><a href="CompleteEncuesta.php">
        <em class="icon-share-alt">&nbsp;</em> Llenar Encuesta
        </a></li>
        <li><a href="FormularioEncuesta.php">
        <em class="far fa-plus-square">&nbsp;</em> Crear Encuesta
        </a></li>
        </ul>
        </li>

  <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                          <em class="fas fa-cogs">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                      </a>



                    <ul class="children collapse" id="sub-item-1">

                           <li><a class="" href="Clientes.php">
                                   <span class="glyphicon glyphicon-usd"></span> Clientes
                               </a></li>

                           <li><a class="" href="#">
                                   <span class="glyphicon glyphicon-shopping-cart"></span> Vendedores
                               </a></li>
                           <li><a class="" href="#">
                                   <span class="glyphicon glyphicon-eye-open"></span> Supervidores
                               </a></li>

                      </ul>
                  </li>

  <li><a href="charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>

        <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>';

        break;
}

?>
   </ul>
 </div><!--/.sidebar-->
