<?php

require "../Modelo/Conexion.php";

class Usuario extends Conexion
{

    public function RegistrarUsuario()
    {
        parent::__construct();

        function __get($atributo)
        {
            if (isset($this->$atributo)) {
                return $this->$atributo;
            } else {
                return ""; //"No hay nada... -_-";
            }
        }

        function __set($atributo, $valor)
        {
            if (isset($this->$atributo)) {
                $this->$atributo = $valor;
            } else {
                //echo "No Existe {$atributo}... :'(";
            }
        }

    }

    public function RegistrarUser($ID, $Usuario, $password, $Email, $Nombre, $Apellido, $UsuarioActual, $FechaCreacion)
    {

        try {

            $Password = password_hash($password, PASSWORD_DEFAULT, array("cost" => 15));

            //Modificar Usuario

            if ($ID > 0) {

                $sql = "UPDATE tbl_users
                SET Password = '$pass_cifrado' ,
                  Email = '$Email' ,
                  PrimerNombre ='$Nombre' ,
                  Apellido = '$Apellido',
                  ModificadoPorUsuarioId ='$UsuarioActual' ,
                  FechaModificacion= '$FechaCreacion'
                  WHERE IdUsuario='$ID' ";
                $resultado = $this->conexion_db->prepare($sql);

                $resultado->execute();

                echo '<script language="javascript">';
                echo 'alert("El usuario fue modificado exitoxamente")';
                echo '</script>';

            }
            //Crear usuario
            else {

                $sql = "INSERT INTO tbl_users (Usuario,Password,Email,PrimerNombre,Apellido,CreadoPorUsuarioId,FechaCreacion) VALUES (:Usuario, :Password,:Email,:Nombre,:Apellido,:Creadopor,:FechaCreacion) ";

                $resultado = $this->conexion_db->prepare($sql);

                $resultado->execute(array(":Usuario" => $Usuario, ":Password" => $Password, ":Email" => $Email, ":Nombre" => $Nombre, ":Apellido" => $Apellido, "Creadopor" => $UsuarioActual, ":FechaCreacion" => $FechaCreacion));

                echo '<script language="javascript">';
                echo 'alert("Los datos fueron guardado corectamente")';
                echo '</script>';
            }

            $resultado->closeCursor();

            $this->conexion_db = null;

        } catch (Exception $e) {
            echo "<script type=\"text/javascript\">alert(\"Error al guardar los datos\");</script>" . $e->GetMessage();
        }

    }

    public function VerificarUser($usuario, $password)
    {
        $autenticado = false;

        $sql = "SELECT * FROM  tbl_users WHERE Usuario = :login   OR Email =:login  LIMIT 1";

        $sentencia = $this->conexion_db->prepare($sql);

        $sentencia->execute(array(":login" => $usuario));

        while ($registro = $sentencia->fetch(PDO::FETCH_ASSOC)) {

            if (password_verify($password, $registro['Password'])) {

                $autenticado = true;
            } else {

                $autenticado = false;

                echo '<script language="javascript">';
                echo 'alert("La contraseña es incorrecta. Inténtalo de nuevo")';
                echo '</script>';

            }

        }$sentencia->closeCursor();

        $this->conexion_db = null;

        return $autenticado;

    }

//Funcion para comprobar si el usuario existe en la base de datos
    public function UsuarioExiste($usuario)
    {

        $sql       = "SELECT * FROM  tbl_users WHERE Usuario ='$usuario'";
        $resultado = $this->conexion_db->prepare($sql);

        $resultado->execute();

        $numero_registro = $resultado->rowCount();

        if ($numero_registro != 0) {
            echo 'existe';
            //<div align="center" id="NoExiste" class="No_Disponible"> El nombre de usuario no esta disponible'
        }else{
            echo "no existe";
        }

        $resultado->closeCursor();

        $this->conexion_db = null;

    }

}
