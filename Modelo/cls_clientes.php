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

require 'Conexion.php';

class Clientes extends Conexion
{
    public function ConstCliente()
    {
        parent::__construct();

        function __get($atributo)
        {
            if (isset($this->{$atributo})) {
                return $this->{$atributo};
            }

            return ''; //"No hay nada... -_-";
        }

        function __set($atributo, $valor)
        {
            if (isset($this->{$atributo})) {
                $this->{$atributo} = $valor;
            }
            //echo "No Existe {$atributo}... :'(";
        }
    }

    public function registrarClienteNuevo($Nombre, $Apellido, $Direccion, $Correo, $Telefono, $TipoCliente, $Departamentoid, $Departamento)
    {
        session_start();

        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');

        $sql = 'INSERT INTO tbl_clientes (NombreCliente,ApellidoCliente,DireccionClientes,TelefonoClientes,Email,TipoCliente, IdDepartamento, Departamento,CreadoPorUsuarioId,FechaCreacion) VALUES (:nom, :ape , :dir, :Telefono, :Email, :TipoCliente, :IdDepartamento, :Departamento, :CreadoPorUsuarioId, :FechaCreacion)';

        $resultado = $this->conexion_db->prepare($sql);

        $resultado->execute([':nom' => $Nombre, ':ape' => $Apellido, ':dir' => $Direccion, ':Telefono' => $Telefono, ':Email' => $Correo, ':TipoCliente' => $TipoCliente, ':IdDepartamento' => $Departamentoid, ':Departamento' => $Departamento, ':CreadoPorUsuarioId' => $idUsuario, ':FechaCreacion' => $FechaCreacion]);

        $resultado->closeCursor();
    }

    public function updateCliente($id, $Nombre, $Apellido, $Direccion, $Correo, $Telefono)
    {
        session_start();

        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');

        $sql = "UPDATE tbl_clientes set NombreCliente='${Nombre}',
                                              ApellidoCliente='${Apellido}',
                                              DireccionClientes='${Direccion}',
                                              TelefonoClientes='${Telefono}',
                                              Email='${Correo}',

                                              ModificadoPorUsuarioId='${idUsuario}',
                                              FechaModificacion ='${FechaCreacion}'
                                                WHERE IdClientes='${id}'";

        $resultado = $this->conexion_db->prepare($sql);
        $resultado->execute();
        $resultado->closeCursor();
    }

    public function ActivateLogin($idCliente, $password, $permiso, $usuario, $nombre, $email, $apellido)
    {
        session_start();

        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');
        $imagen = 'userprofilleDefault.png';

        $sql = "UPDATE tbl_clientes set       PuedeLoguearse='1',
                                              ModificadoPorUsuarioId='${idUsuario}',
                                              FechaModificacion ='${FechaCreacion}'
                                                WHERE IdClientes='${idCliente}'";

        $resultado = $this->conexion_db->prepare($sql);
        $resultado->execute();
        $resultado->closeCursor();

        $sql2 = 'INSERT into tbl_users (IdUsuario, Nombre,Apellido,Usuario,Password,Permiso,Email,CreadoPorUsuarioId,FechaCreacion,ImgenPerfil)
                                VALUES(:IdUsuario, :Nombre , :Apellido, :Usuario, :Password, :Permiso, :Email, :CreadoPorUsuarioId, :FechaCreacion, :Imgen)';

        $resultados = $this->conexion_db->prepare($sql2);

        $resultados->execute([':IdUsuario' => $idCliente, ':Nombre' => $nombre, ':Apellido' => $apellido, ':Usuario' => $usuario, ':Password' => $password, ':Permiso' => $permiso, ':Email' => $email, ':CreadoPorUsuarioId' => $idUsuario, ':FechaCreacion' => $FechaCreacion, ':Imgen' => $imagen]);

        $resultados->closeCursor();
    }

    public function DeleteCliente($id)
    {
        session_start();

        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');
        $Activo = '0';

        $sql = "UPDATE tbl_clientes set     ModificadoPorUsuarioId='${idUsuario}',
                                            FechaModificacion ='{$FechaCreacion}',
                                            Activo ='${Activo}'
                                            WHERE IdClientes='${id}'";

        $resultado = $this->conexion_db->prepare($sql);
        $resultado->execute();
        $resultado->closeCursor();

        $sql2 = "DELETE FROM tbl_users  WHERE IdUsuario='${id}'";

        $resultados = $this->conexion_db->prepare($sql2);
        $resultados->execute();
        $resultados->closeCursor();
    }

    public function DesactivarPermiso($id)
    {
        session_start();

        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');
        $Activo = '0';

        $sql = "UPDATE tbl_clientes set     PuedeLoguearse='0',
                                            FechaModificacion ='${FechaCreacion}'
                                            WHERE IdClientes='${id}'";

        $resultado = $this->conexion_db->prepare($sql);
        $resultado->execute();
        $resultado->closeCursor();
        $sql2 = "DELETE FROM tbl_users  WHERE IdUsuario='${id}'";

        $resultados = $this->conexion_db->prepare($sql2);
        $resultados->execute();
        $resultados->closeCursor();
    }

    public function GetDataClientes()
    {
        $sqlcliente = 'SELECT * FROM  tbl_clientes where Activo =1';

        $resultado = $this->conexion_db->prepare($sqlcliente);

        $resultado->execute();

        $numero_registro = $resultado->rowCount();

        if ($numero_registro > 0) {
            $registros = $resultado->fetchAll(PDO::FETCH_OBJ); ?>



      <table id="DataTable" class="table display table-striped table-hover" cellspacing="0" width="100%">
          <thead>
              <tr>


                   <th>Id</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Direccion</th>
                  <th>Correo</th>
                  <th>Login</th>
                  <th>Telefono</th>
                  <th>Departamento</th>
                  <th>Actions</th>
              </tr>
          </thead>



                 <tbody>
                     <?php
                 foreach ($registros as $clientes): ?>
                    <tr>

                      <td><?php echo $clientes->IdClientes; ?> </td>
                      <td><?php echo $clientes->NombreCliente; ?></td>
                      <td><?php echo $clientes->ApellidoCliente; ?></td>
                      <td><?php echo $clientes->DireccionClientes; ?></td>
                      <td><?php echo $clientes->Email; ?></td>

                        <td><?php
                           if ('0' === $clientes->PuedeLoguearse) {
                               echo '<i id="LoginDeny" title="No se puede loguear en el sistema " class="material-icons colorRed">&#xE5C9;</i>';
                           } else {
                               echo '<i  id="LoginAllow" title="Se puede loguear en el sistema " class="material-icons colorGreen">&#xE86C;</i>';
                           } ?></td>
                        <td><?php echo $clientes->TelefonoClientes; ?></td>
                          <td><?php echo $clientes->Departamento; ?></td>

                      <td>

                                    <a  data-toggle="modal" title="Editar Cliente"  class="edit editCampoCliente" data-target="#editEmployeeModal" data-id="<?php echo $clientes->IdClientes; ?>" data-nombre="<?php echo $clientes->NombreCliente; ?>" data-apellido="<?php echo $clientes->ApellidoCliente; ?>" data-direccion="<?php echo $clientes->DireccionClientes; ?>"
                                      data-email="<?php echo $clientes->Email; ?>" data-telefono="<?php echo $clientes->TelefonoClientes; ?>"><i class="material-icons">&#xE254;</i></a>
                        						<a data-toggle="modal" title="Borrar Cliente" class="delete" data-target="#deleteClienteModal" data-id="<?php echo $clientes->IdClientes; ?>" data-nombre="<?php echo $clientes->NombreCliente; ?>" ><i class="material-icons">&#xE872;</a>
                                   <?php if ('1' !== $clientes->PuedeLoguearse) {
                               echo '  <a data-toggle="modal" title="Activar acceso al sistema" class="AddPermiso" data-target="#ActivarPermiso" data-id=" '.$clientes->IdClientes.'" data-nombre="'.$clientes->NombreCliente.' "data-email="'.$clientes->Email.'  "data-apellido="'.$clientes->ApellidoCliente.'"><i class="material-icons">&#xE897;</a>';
                           } else {
                               echo '<a data-toggle="modal" title="Desactivar acceso al sistema" class="AddPermiso" data-target="#DesactivarPermiso" data-id=" '.$clientes->IdClientes.'" data-nombre="'.$clientes->NombreCliente.' "><i class="material-icons">&#xE898;</a>';
                           } ?>


                      </td>

                    </tr>
                  <?php endforeach; ?>



          </tbody>
      </table>
    <?php
        } else {
            print_r('No hay datos disponibles');
        }
    }
}
