<?php

class Conexion
{

    public $conexion_db;
    public function Conexion()
    {

        try {

            $this->conexion_db = new PDO('mysql:host=localhost; dbname=pausaactiva', 'root', 'JMC1995c245');
            $this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conexion_db->exec("SET CHARACTER SET utf8");

            return $this->conexion_db;

        } catch (Exception $e) {

            echo "<script type=\"text/javascript\">alert(\"Error al Conectar con la Base de Datos\");</script>" . $e->GetMessage();
        }

    }

}
