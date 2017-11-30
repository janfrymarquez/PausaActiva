
<?php

include "../Controlador/cls_usuario.php";
if (isset($_POST["enviar"])) {

    $usuario  = htmlentities(addslashes($_POST["Usuario"]));
    $password = htmlentities(addslashes($_POST["Password"]));

    $user = new Usuario();

    $user->VerificarUser($usuario, $password);

    /* if ($login) {

session_start();

$_SESSION["userlog"] = $_POST["Usuario"];

header("Location:../index.php");

}*/
}
?>




<!DOCTYPE html>


<html >
<head>
  <meta charset="UTF-8">
  <title>Pausa Activa Administracion</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/styleLogin.css">


</head>

<body>

<div class="container">
  <div class="info">
    <h1>Pausa Activa HB </h1>
  </div>
</div>
<div class="form" >
  <div class="thumbnail"><img src="img/logo.png"><br/></div>
  <form class="register-form">

    <input type="text" placeholder="Correo electriconico" name "Correo" id "Correo"/>
    <button>Aceptar</button>
  </form>

  <form class="login-form" action ="login.php" method="POST">

    <input type="text" placeholder="Usuario"  name="Usuario" id="Usuario"/>

    <input type="password" placeholder="Contraseña" name="Password" id= "Password"/>

<input type="checkbox" name="recordar" value="recordar"> Recordar Credenciales

    <input id="button" type="submit" value="Entrar" name="enviar" id="enviar" >
    <p class="message"> <a href="#">¿Olvidó su contraseña?</a></p>
  </form>




</div>



  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/login.js"></script>

</body>
</html>
