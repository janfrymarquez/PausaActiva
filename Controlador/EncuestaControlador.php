<?php

require "../Modelo/cls_Encuesta.php";

$Encuesta = new Encuesta();

if (isset($_POST['name']) && !empty($_POST['name'])) {

    $pregunta = $_POST['name'];

    $Encuesta->AgregarPregunta($pregunta);

}

if (isset($_POST['TiposEncuestaID']) && !empty($_POST['TiposEncuestaID'])) {

    $TipoEncuesta = $_POST['TiposEncuestaID'];

    $Encuesta->getSubTipoEncuentaByTipoEncuentaID($TipoEncuesta);

} else {
    echo "Error";
}
