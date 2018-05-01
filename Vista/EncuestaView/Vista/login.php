<?php

include '../Modelo/cls_usuario.php';
if (isset($_POST['enviar'])) {
    $usuario = htmlentities(addslashes($_POST['Usuario']));
    $password = htmlentities(addslashes($_POST['Password']));

    $user = new Usuario();

    $user->VerificarUser($usuario, $password);

   
}
?>




<!DOCTYPE html>


<html >
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
  
  <title>Login Encuesta</title>
 <link rel="icon" href="img/favicon.ico">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/styleLogin.css">


</head>

<body>

<div class="container">
  <div class="info">
    <h1> Encuesta Analytic Soluction</h1>
  </div>
</div>
<div class="form" >
  <div class="thumbnail"><img src="img/Logo.png"><br/></div>
  <form class="register-form">

    <input type="text" placeholder="Correo electriconico" name "Correo" id "Correo"/>
    <button>Aceptar</button>
  </form>

  <form class="login-form" action ="login.php" method="POST">

    <input type="text" placeholder="Usuario"  name="Usuario" id="Usuario"/>

    <input type="password" placeholder="Contraseña" autocomplete="false" name="Password" id= "Password"/>

<input type="checkbox" name="recordar" value="recordar"> Recordar Credenciales

    <input id="button" type="submit" value="Entrar" name="enviar" id="enviar" >
    <p class="message"> <a href="#">¿Olvidó su contraseña?</a></p>
  </form>




</div>





</body>
</html>
