<?php

require "cls_usuario.php";

$RegistrarUsuario = new Usuario();

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $RegistrarUsuario->UsuarioExiste($username);
}
