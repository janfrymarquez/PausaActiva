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

    public function VerificarUser($usuario, $password, $token)
    {
        $data = [];
        if ('none' !== $token) {
            $sql = 'SELECT * FROM  tbl_Empleados WHERE Codigo = :login  LIMIT 1';

            $sentencia = $this->conexion_db->prepare($sql);

            $sentencia->execute([':login' => $usuario]);
            $numero_registro = $sentencia->rowCount();
            if (0 !== $numero_registro) {
                while ($registro = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    if ($password === $registro['Password']) {
                        $idCliente = $registro['Codigo'];
                        $ConsultaEvaludo = 'SELECT * FROM  tbl_evaluados WHERE IdCliente = :Cliente & IdToken= :IdToken LIMIT 1';
                        $ExeConsultaEvaluado = $this->conexion_db->prepare($ConsultaEvaludo);
                        $ExeConsultaEvaluado->execute([':Cliente' => $idCliente, ':IdToken' => $token]);

                        $numero_registros = $ExeConsultaEvaluado->rowCount();
                        if (0 !== $numero_registros) {
                            while ($registros = $ExeConsultaEvaluado->fetch(PDO::FETCH_ASSOC)) {
                                $estatus = $registros['Estatus'];
                                if ('Evaluar' === $estatus) {
                                    $data['success'] = true;
                                    $data['url'] = '../Vista/EncuestaView/index.php?token='.$token.' & idCliente='.$idCliente.'';
                                } else {
                                    $data['success'] = true;
                                    $data['url'] = '../Vista/EncuestaView/EncuestaCompletada.php';
                                }
                            }
                        } else {
                            $data['success'] = true;
                            $data['url'] = '../Vista/EncuestaView/EncuestaCompletada.php';
                        }
                    } else {
                        $data['success'] = false;
                    }
                }
            } else {
                $data['success'] = false;
            }
        } else {
            $sql = 'SELECT * FROM  tbl_users WHERE Usuario = :login  LIMIT 1';

            $sentencia = $this->conexion_db->prepare($sql);

            $sentencia->execute([':login' => $usuario]);
            $numero_registro = $sentencia->rowCount();
            if (0 !== $numero_registro) {
                while ($registro = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                    if ($password === $registro['Password']) {
                        $data['success'] = true;
                        session_start();

                        $_SESSION['userlog'] = $registro['Nombre'];
                        $ahora = date('Y-n-j H:i:s');
                        $_SESSION['profileimg'] = $registro['ImgenPerfil'];
                        $_SESSION['IdUsuarioActual'] = $registro['IdUsuario'];
                        $_SESSION['IdSector'] = $registro['IdSector'];
                        $_SESSION['IdSucursal'] = $registro['IdSucursal'];
                        $_SESSION['autentificado'] = 'SI';
                        $_SESSION['ultimoAcceso'] = $ahora;
                        $_SESSION['Permiso'] = $registro['Permiso'];
                        $_SESSION['email'] = $registro['Email'];

                        switch ($registro['Permiso']) {
                    case '2':
                        $data['url'] = 'charts.php';

                        break;
                    case '3':
                        $data['url'] = '../index.php';

                        break;
                    default:
                        $data['url'] = '../index.php';

                    break;
                }
                    } else {
                        $data['success'] = false;
                    }
                }
            } else {
                $data['success'] = false;
            }
            $sentencia->closeCursor();

            $this->conexion_db = null;
        }

        return $data;
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
                echo '<option value="'.$registro['IdDepartamento'].','.$registro['Departamento'].'">'.$registro['Departamento'].'</option>';
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
            echo '<option selected disabled value=""> -- Selecione una heladeria -- </option>';
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$registro['IdLocalidad'].','.$registro['NOM_UNIDAD'].'">'.$registro['NOM_UNIDAD'].'</option>';
            }
        } else {
            echo 'NoDisponible';
        }

        $resultado->closeCursor();
    }
}
