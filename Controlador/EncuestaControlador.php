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

if (isset($_POST['name']) && !empty($_POST['name'])) {
    $pregunta = $_POST['name'];

    $Encuesta->AgregarPregunta($pregunta);
}

if (isset($_POST['TiposEncuestaID']) && !empty($_POST['TiposEncuestaID'])) {
    $TipoEncuesta = $_POST['TiposEncuestaID'];

    $Encuesta->getSubTipoEncuentaByTipoEncuentaID($TipoEncuesta);
}
if (isset($_POST['GetUrlbyEncuestaId']) && !empty($_POST['GetUrlbyEncuestaId'])) {
    $GetUrlbyEncuestaId = $_POST['GetUrlbyEncuestaId'];
    $PermisoUrl = $_POST['PermisoUrl'];

    if ('3' === $PermisoUrl || '4' === $PermisoUrl) {
        $FechaExpiracion = $_POST['FechaExpiracion'];
        $fechaExpiracion = date('Y/m/d', strtotime($FechaExpiracion));
    } else {
        $FechaExpiracion = '';
    }
    $Encuesta->getUrlEncuesta($GetUrlbyEncuestaId, $PermisoUrl, $fechaExpiracion);
}
