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
     $DatosEncuestaJsom = $_POST['DataJson'];
     $DataArray = json_decode($DatosEncuestaJsom);
     $Encuesta->GuardarDatosEncuesta($DataArray);
 }

 if (isset($_POST['InsertarDatos']) && !empty($_POST['InsertarDatos'])) {
     $InsertarDatosJsom = $_POST['InsertarDatos'];
     $datoinsertar = json_decode($InsertarDatosJsom);
     $Encuesta->InsertarDatosOnEncuesta($datoinsertar);
 }

 if (isset($_POST['DatosActualizar']) && !empty($_POST['DatosActualizar'])) {
     $ActualizarJsom = $_POST['DatosActualizar'];
     $actualizar = json_decode($ActualizarJsom);
     $Encuesta->ActualizarDatosEncuesta($actualizar);
 }

 if (isset($_POST['IdPreguntaEliminar']) && !empty($_POST['IdPreguntaEliminar'])) {
     $IdPreguntaEliminar = $_POST['IdPreguntaEliminar'];
     $Encuesta->EliminarPreguntaEncuesta($IdPreguntaEliminar);
 }

 if (isset($_POST['EncuestaArray']) && !empty($_POST['EncuestaArray'])) {
     $DatasGuardarResultados = $_POST['EncuestaArray'];
     $Datajson = json_decode($DatasGuardarResultados);
     $Encuesta->GuardarResultadosEncuesta($Datajson);
 }
