<?php
require "Conexion.php";

class Encuesta extends Conexion
{

    public function Encuesta()
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

    public function AgregarPregunta($pregunta)
    {

        for ($i = 0; $i < $number; $i++) {

            if (trim($pregunta[$i] != '')) {
                $sql       = "INSERT INTO tbl_name(name) VALUES(:pregunta)";
                $resultado = $this->conexion_db->prepare($sql);

                $resultado->execute(array(":pregunta" => $pregunta[i]));

            }

        }

        $resultado->closeCursor();

    }

    public function getSubTipoEncuentaByTipoEncuentaID($TipoEncuesta)
    {

        $sql = "SELECT * FROM  tbl_sub_encuesta WHERE IdTipoEncuesta   = :ID ORDER by SubTipoEncuesta ASC";

        $resultado = $this->conexion_db->prepare($sql);

        $resultado->execute(array(":ID" => $TipoEncuesta));

        $numero_registro = $resultado->rowCount();

        if ($numero_registro != 0) {

            echo '<option value=""> -- Seleciones un SubTipo de Encuesta -- </option>';
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

                echo '<option value="' . $registro['IdSubTipoEncuesta'] . '">' . $registro['SubTipoEncuesta'] . '</option>';

            }

        } else {
            echo "NoDisponible";
        }

        $resultado->closeCursor();
    }
}
