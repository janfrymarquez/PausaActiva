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

function clean_text($string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);

    return $string;
}
if (isset($_POST['name']) && !empty($_POST['name'])) {
    $pregunta = clean_text($_POST['name']);

    $Encuesta->AgregarPregunta($pregunta);
}

if (isset($_POST['TiposEncuestaID']) && !empty($_POST['TiposEncuestaID'])) {
    $TipoEncuesta = clean_text($_POST['TiposEncuestaID']);

    $Encuesta->getSubTipoEncuentaByTipoEncuentaID($TipoEncuesta);
}

if (isset($_POST['SubTipoEncuenta']) && !empty($_POST['SubTipoEncuenta'])) {
    $SubTipoEncuesta = clean_text($_POST['SubTipoEncuenta']);

    $Encuesta->getClienteBySubTipoEncuenta($SubTipoEncuesta);
}
if (isset($_POST['GetUrlbyEncuestaId']) && !empty($_POST['GetUrlbyEncuestaId'])) {
    $GetUrlbyEncuestaId = clean_text($_POST['GetUrlbyEncuestaId']);
    $PermisoUrl = clean_text($_POST['PermisoUrl']);
    $ClienteAEvaluar = $_POST['ClienteAEvaluar'];
    $Evaluador = $_POST['Evaluador'];
    $mensaje = clean_text($_POST['mensaje']);
    $clienteOpcion = clean_text($_POST['clienteoption']);

    if ('3' === $PermisoUrl || '4' === $PermisoUrl) {
        $FechaExpiracion = clean_text($_POST['FechaExpiracion']);
        $fechaExpiracion = date('Y/m/d', strtotime($FechaExpiracion));
    } else {
        $fechaExpiracion = 'null';
    }
    $Encuesta->getUrlEncuesta($GetUrlbyEncuestaId, $PermisoUrl, $fechaExpiracion, $ClienteAEvaluar, $Evaluador, $mensaje, $clienteOpcion);
}

if (isset($_POST['SentEncuestaMail']) && !empty($_POST['SentEncuestaMail'])) {
    $SentEncuestaMail = clean_text($_POST['SentEncuestaMail']);
    $PermisoUrl = clean_text($_POST['PermisoUrl']);
    $ClienteAEvaluar = $_POST['ClienteAEvaluar'];
    $Evaluador = $_POST['Evaluador'];
    $mensaje = clean_text($_POST['mensaje']);
    $clienteOpcion = $_POST['clienteoption'];
    $NombreEncuesta = clean_text($_POST['nombreEncuesta']);
    if ('3' === $PermisoUrl || '4' === $PermisoUrl) {
        $FechaExpiracion = clean_text($_POST['FechaExpiracion']);
        $fechaExpiracion = date('Y/m/d', strtotime($FechaExpiracion));
    } else {
        $fechaExpiracion = 'null';
    }
    $Encuesta->SentEmailToCompleteEncuesta($SentEncuestaMail, $PermisoUrl, $fechaExpiracion, $ClienteAEvaluar, $Evaluador, $mensaje, $clienteOpcion, $NombreEncuesta);
}
