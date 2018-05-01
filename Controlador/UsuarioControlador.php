<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require '../Modelo/cls_usuario.php';

$RegistrarUsuario = new Usuario();

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $RegistrarUsuario->UsuarioExiste($username);
}

if (isset($_POST['EmpleadoInterno']) && !empty($_POST['EmpleadoInterno'])) {
    $Empleadointerno = $_POST['EmpleadoInterno'];

    $RegistrarUsuario->getEmpleadoInterno();
}

if (isset($_POST['EmpleadoExterno']) && !empty($_POST['EmpleadoExterno'])) {
    $EmpleadoExterno = $_POST['EmpleadoExterno'];

    $RegistrarUsuario->getEmpleadoExterno();
}

if (isset($_POST['Usuario'])) {
    $errors = [];
    $data = [];
    if (empty($_POST['Usuario'])) {
        $errors['Usuario'] = 'El usuario no puede estar en blanco';
    }
    if (empty($_POST['Password'])) {
        $errors['Password'] = 'Password no puede estar en blanco';
    }
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';

        $usuario = htmlentities(addslashes($_POST['Usuario']));
        $password = htmlentities(addslashes($_POST['Password']));
        $idencuesta = htmlentities(addslashes($_POST['token']));

        $result = $RegistrarUsuario->VerificarUser($usuario, $password, $idencuesta);

        print_r(json_encode($result));
    }
}
