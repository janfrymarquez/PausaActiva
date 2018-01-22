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

require '../Modelo/cls_Encuesta.php';

$Encuesta = new Encuesta();

if (isset($_POST['DataJson']) && !empty($_POST['DataJson'])) {
    $DatosEncuesta = $_POST['DataJson'];

    $datoinsertar = json_decode($DatosEncuesta);

    $Encuesta->GuardarDatosEncuesta($datoinsertar);
}

if (isset($_POST['InsertarDatos']) && !empty($_POST['InsertarDatos'])) {
    $DatosEncuesta = $_POST['InsertarDatos'];

    $datoinsertar = json_decode($DatosEncuesta);

    $Encuesta->InsertarDatosOnEncuesta($datoinsertar);
}

if (isset($_POST['Actualizar']) && !empty($_POST['Actualizar'])) {
    $DatosActualizarEncuesta = $_POST['Actualizar'];

    $actualizar = json_decode($DatosActualizarEncuesta);

    $Encuesta->ActualizarDatosEncuesta($actualizar);
}

if (isset($_POST['IdPreguntaEliminar']) && !empty($_POST['IdPreguntaEliminar'])) {
    $IdPreguntaEliminar = $_POST['IdPreguntaEliminar'];
    $Encuesta->EliminarPreguntaEncuesta($IdPreguntaEliminar);
}
