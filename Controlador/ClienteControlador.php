
<?php

require '../Modelo/cls_clientes.php';

$Cliente = new Clientes();
  $errors = [];
  $data = [];

if (isset($_POST['add'])) {
    $errors = [];
    $data = [];
    if (empty($_POST['Nombre'])) {
        $errors['nombre'] = 'Nombre vacio';
    }
    if (empty($_POST['Apellido'])) {
        $errors['Apellido'] = 'Apellido vacio';
    }
    if (empty($_POST['Direccion'])) {
        $errors['Direccion'] = 'Direccion vacio';
    }
    if (empty($_POST['Email']) || !filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
        $errors['Email'] = 'Este E-mail no es valido';
    }

    if (empty($_POST['Telefono'])) {
        $errors['Telefono'] = 'Telefono vacio';
    }

    if (empty($_POST['Departamento'])) {
        $errors['Departamento'] = 'Departamento vacio';
    }
    if (empty($_POST['TipoCliente'])) {
        $errors['TipoCliente'] = 'Tipo de Cliente vacio';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';

        $Nombre = htmlentities(addslashes($_POST['Nombre']));
        $Apellido = htmlentities(addslashes($_POST['Apellido']));
        $Direccion = htmlentities(addslashes($_POST['Direccion']));
        $Correo = htmlentities(addslashes($_POST['Email']));
        $Telefono = htmlentities(addslashes($_POST['Telefono']));
        $TipoCliente = htmlentities(addslashes($_POST['TipoCliente']));
        $Departamentoid = ($_POST['DepartamentoId']);
        $Departamento = ($_POST['Departamento']);

        $Cliente->registrarClienteNuevo($Nombre, $Apellido, $Direccion, $Correo, $Telefono, $TipoCliente, $Departamentoid, $Departamento);
    }

    print_r(json_encode($data));
}

if (isset($_POST['EnviarActivarPermiso'])) {
    $errors = [];
    $data = [];

    if (empty($_POST['Usuario'])) {
        $errors['usuario'] = 'Usuario en blanco';
    }
    if (empty($_POST['Permiso'])) {
        $errors['permiso'] = 'permiso en blanco';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';

        $nombre = htmlentities(addslashes($_POST['Nombre']));
        $email = htmlentities(addslashes($_POST['Email']));
        $apellido = htmlentities(addslashes($_POST['Apellido']));
        $usuario = htmlentities(addslashes($_POST['Usuario']));
        $permiso = htmlentities(addslashes($_POST['Permiso']));
        $password = htmlentities(addslashes($_POST['Password']));
        $idCliente = htmlentities(addslashes($_POST['IdCliente']));

        $Cliente->ActivateLogin($idCliente, $password, $permiso, $usuario, $nombre, $email, $apellido);
    }

    print_r(json_encode($data));
}

if (isset($_POST['Edit'])) {
    if (empty($_POST['nombre'])) {
        $errors['nombre'] = 'Nombre vacio';
    }
    if (empty($_POST['apellido'])) {
        $errors['Apellido'] = 'Apellido vacio222';
    }
    if (empty($_POST['direccion'])) {
        $errors['Direccion'] = 'Direccion vacio';
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['Email'] = 'Este E-mail no es valido';
    }

    if (empty($_POST['Telefono'])) {
        $errors['Telefono'] = 'Telefono vacio';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
        $id = htmlentities(addslashes($_POST['Id']));
        $Nombre = htmlentities(addslashes($_POST['nombre']));
        $Apellido = htmlentities(addslashes($_POST['apellido']));
        $Direccion = htmlentities(addslashes($_POST['direccion']));
        $Correo = htmlentities(addslashes($_POST['email']));
        $Telefono = htmlentities(addslashes($_POST['Telefono']));

        $Cliente->updateCliente($id, $Nombre, $Apellido, $Direccion, $Correo, $Telefono);
    }

    print_r(json_encode($data));
}

if (isset($_POST['IdClienteBorrar'])) {
    $Id = ($_POST['IdClienteBorrar']);
    $Cliente->DeleteCliente($Id);
}

if (isset($_POST['IdClienteDesactivarPermiso'])) {
    $IdClienteDesactivarPermiso = ($_POST['IdClienteDesactivarPermiso']);
    $Cliente->DesactivarPermiso($IdClienteDesactivarPermiso);
}

    $action = (isset($_REQUEST['action']) && null !== $_REQUEST['action']) ? $_REQUEST['action'] : '';
    if ('ajax' === $action) {
        $Cliente->GetDataClientes();
    }
