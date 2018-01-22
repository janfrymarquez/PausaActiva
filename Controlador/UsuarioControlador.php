<?php

require "../Modelo/cls_usuario.php";

$RegistrarUsuario = new Usuario();

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $RegistrarUsuario->UsuarioExiste($username);
}

if (isset($_POST["login"])) {

    date_default_timezone_set('America/Santo_Domingo');

    $mipagina = $_SERVER["PHP_SELF"];
    session_start();
    $usuario         = htmlentities(addslashes($_POST["Usuario"]));
    $password        = htmlentities(addslashes($_POST["Password"]));
    $Nombre          = htmlentities(addslashes($_POST["Nombre"]));
    $Apellido        = htmlentities(addslashes($_POST["Apellido"]));
    $Email           = htmlentities(addslashes($_POST["Email"]));
    $confirmpassword = htmlentities(addslashes($_POST["confirmpassword"]));
    $Permisos        = $_POST["Permisos"];
    $UsuarioActual   = $_SESSION["IdUsuarioActual"];
    $FechaCreacion   = date('Y/m/d');
    $ID              = 3;

    $NombreImagen = $_FILES['imagen']['name'];
    $tipoImagen   = $_FILES["imagen"]['type'];
    $tamImagen    = $_FILES["imagen"]['size'];

//Ruta de la carpeta Destino en el servidor

    $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/ProyectoPausaActiva/PausaActiva/Vista/img/';

//Movemos la imagen del directorio temporal a la carpeta de destino

    move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino . $NombreImagen);

    $RegistrarUsuario->RegistrarUser($ID, $usuario, $password, $Email, $Nombre, $Apellido, $NombreImagen, $UsuarioActual, $FechaCreacion);

}
