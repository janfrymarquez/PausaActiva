
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/fontawesome-all.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/sweetalert.css">
<link rel="stylesheet" href="css/chosen.css">
<link rel="stylesheet" href="css/jquery.dataTables.min.css">

<link rel="icon" href="img/favicon.ico">
  <link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/ImageSelect.jquery.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/chosen.jquery.js"></script>
  <script src="js/sweetalert.js"></script>
<script src="js/ValidarExistencia.js"></script>
<script type="text/javascript" src="assets/js/highlight.min.js"></script>
<script type="text/javascript">
    hljs.configure({tabReplace: '    '});
    hljs.initHighlightingOnLoad();
</script>




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
                   <img src="img/<?php echo $_SESSION['profileimg']; ?> " class="img-responsive" alt="">
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


     <li ><a href="../index.php"><em class="fas fa-home">&nbsp;</em> Inicio</a></li>

     <li><a href="FormularioEncuesta.php"><em class="far fa-plus-square">&nbsp;</em> Crear Encuesta </a></li>


<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                       <em class="fas fa-cogs">&nbsp;</em> Configuraciones <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                   </a>
                   <ul class="children collapse" id="sub-item-1">
                         <li><a class="" href="ModificarUsuario.php">
                                 <span class="fas fa-user"></span> Usuarios
                             </a></li>
                         <li><a class="" href="clientebeta.php">
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

<li><a href="charts.php"><em class="fas fa-chart-pie">&nbsp;</em> Reportes</a></li>

     <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
   </ul>
 </div><!--/.sidebar-->
