<?php


  if (isset($_GET['token'])) {
      $token = $_GET['token'];
  } else {
      $token = 'none';
  }

?>
<!DOCTYPE html>
<html >
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

  <title>Login Encuesta</title>


      <link rel="stylesheet" href="css/styleLogin.css">
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/fontawesome-all.css" rel="stylesheet">
      <link href="css/font-awesome.min.css" rel="stylesheet">


</head>

<body>




<div class="container">
  <div class="info">
    <h1> Sistema BonEncuesta</h1>
  </div>


</div>


<div class="Logincontainer"  >


                  <div id="login-detail" class="hidden">
                      <div id="login-status-messaje"><i class="fas fa-exclamation-triangle"> El inicio de sesión no es válido</i></div>
                  </div>
  <div class="thumbnail"><img src="img/Logo.png"><br/></div>

  <form id="FormLogin" >

    <input type="text" placeholder="Usuario" class="required"  name="Usuario" id="Usuario"/>
    <input type="text"  hidden name="token" id="token"  value="<?php echo $token; ?>" />
    <input type="password" placeholder="Contraseña" class="required" autocomplete="false" name="Password" id= "Password"/>

<input type="checkbox" name="recordar" value="recordar"> Recordar Credenciales

    <button id="button" type="button"  >Entrar</button>
    <p class="message"> <a href="#">¿Olvidó su contraseña?</a></p>
  </form>




</div>

  <script src="js/jquery.js"></script>
  <script src="js/login.js"></script>


</body>
</html>
