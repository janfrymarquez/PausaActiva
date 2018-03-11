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

class Usuario extends Conexion
{
    public function RegistrarUsuario()
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

    public function RegistrarUser($ID, $Usuario, $password, $Email, $Nombre, $Apellido, $imagen, $UsuarioActual, $FechaCreacion)
    {
        try {
            $Password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);

            //Modificar Usuario

            if ($ID > 0) {
                $sql = "UPDATE tbl_users
                SET Password = '${Password}' ,
                  Email = '${Email}' ,
                  Foto = '${imagen}' ,
                  PrimerNombre ='${Nombre}' ,
                  Apellido = '${Apellido}',
                  ModificadoPorUsuarioId ='${UsuarioActual}' ,
                  FechaModificacion= '${FechaCreacion}'
                  WHERE IdUsuario='${ID}' ";
                $resultado = $this->conexion_db->prepare($sql);

                $resultado->execute();

                echo '<script language="javascript">';
                echo 'alert("El usuario fue modificado exitoxamente")';
                echo '</script>';
            }
            //Crear usuario
            else {
                $sql = 'INSERT INTO tbl_users (Usuario,Password,Email,PrimerNombre,Apellido,Foto,CreadoPorUsuarioId,FechaCreacion) VALUES (:Usuario, :Password,:Email,:Nombre,:Apellido, :imgen,:Creadopor,:FechaCreacion) ';

                $resultado = $this->conexion_db->prepare($sql);

                $resultado->execute([':Usuario' => $Usuario, ':Password' => $Password, ':Email' => $Email, ':Nombre' => $Nombre, ':Apellido' => $Apellido, ':imgen' => $imagen, 'Creadopor' => $UsuarioActual, ':FechaCreacion' => $FechaCreacion]);

                echo '<script language="javascript">';
                echo 'alert("Los datos fueron guardado corectamente")';
                echo '</script>';
            }

            $resultado->closeCursor();

            $this->conexion_db = null;
        } catch (Exception $e) {
            echo '<script type="text/javascript">alert("Error al guardar los datos");</script>'.$e->GetMessage();
        }
    }

    public function VerificarUser($usuario, $password)
    {
        $autenticado = false;

        $sql = 'SELECT * FROM  tbl_users WHERE Usuario = :login  LIMIT 1';

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute([':login' => $usuario]);

        while ($registro = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            if ($password === $registro['Password']) {
                session_start();

                $_SESSION['userlog'] = $registro['Nombre'];

                $_SESSION['profileimg'] = $registro['ImgenPerfil'];
                $_SESSION['IdUsuarioActual'] = $registro['IdUsuario'];
                $_SESSION['IdSector'] = $registro['IdSector'];
                $_SESSION['IdSucursal'] = $registro['IdSucursal'];
                header('Location:../index.php');
            } else {
                echo '<script language="javascript">';
                echo 'alert("La contraseña es incorrecta. Inténtalo de nuevo")';
                echo '</script>';
            }
        }
        $sentencia->closeCursor();

        $this->conexion_db = null;
    }

    //Funcion para comprobar si el usuario existe en la base de datos
    public function UsuarioExiste($usuario)
    {
        $sql = "SELECT * FROM  tbl_users WHERE Usuario ='${usuario}'";
        $resultado = $this->conexion_db->prepare($sql);

        $resultado->execute();

        $numero_registro = $resultado->rowCount();

        if (0 !== $numero_registro) {
            echo 'existe';
        //<div align="center" id="NoExiste" class="No_Disponible"> El nombre de usuario no esta disponible'
        } else {
            echo 'no existe';
        }

        $resultado->closeCursor();

        $this->conexion_db = null;
    }

    public function getEmpleadoInterno()
    {
        $sqlEmpleado = 'SELECT * FROM  tbl_departamentos';

        $resultado = $this->conexion_db->prepare($sqlEmpleado);

        $resultado->execute();

        $numero_registro = $resultado->rowCount();

        if (0 !== $numero_registro) {
            echo '<option selected disabled value=""> -- Selecione un departamento -- </option>';
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$registro['IdDepartamento'].'">'.$registro['Departamento'].'</option>';
            }
        } else {
            echo 'NoDisponible';
        }

        $resultado->closeCursor();
    }

    public function getEmpleadoExterno()
    {
        $sqlEmpleado = 'SELECT * FROM  tbl_localidades';

        $resultado = $this->conexion_db->prepare($sqlEmpleado);

        $resultado->execute();

        $numero_registro = $resultado->rowCount();

        if (0 !== $numero_registro) {
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$registro['IdLocalidad'].'">'.$registro['NOM_UNIDAD'].'</option>';
            }
        } else {
            echo 'NoDisponible';
        }

        $resultado->closeCursor();
    }
}
