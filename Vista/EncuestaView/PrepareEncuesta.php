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

try {
    require '../../Modelo/Conexion.php';

    $Conexion = new Conexion();
    $base = $Conexion->Conexion();

    function eliminarEnlace($tokn)
    {
        $ConexionDb = new Conexion();
        $base = $ConexionDb->Conexion();
        $FechaCreacion = date('Y/m/d');
        $Activo = '0';

        $sqldelete = "UPDATE tbl_token set     FechaModificacion ='${FechaCreacion}',
                                            Activo ='${Activo}'
                                            WHERE token='${tokn}'";

        $resultados = $base->prepare($sqldelete);
        $resultados->execute();
        $resultados->closeCursor();
    }

    function comprobarlogin()
    {
        $autenticado = false;

        return $autenticado;
    }

    $token = $_GET['token'];
    $IdTipoEncuesta = '';
    $SubTipoEncuenta = '';
    $activo = 1;
    $sql = 'SELECT * FROM  tbl_token WHERE token = :token';
    $resultados = $base->prepare($sql);
    $resultados->execute([':token' => $token]);
    $numero_registro = $resultados->rowCount();

    if (0 !== $numero_registro) {
        $registros = $resultados->fetch(PDO::FETCH_ASSOC);
        $Encuestaactiva = $registros['Activo'];
        $Id = $registros['IdEncuesta'];
        $FechaExpiracion = $registros['FechaEspiracion'];
        $permiso = $registros['Permiso'];
        $Evaluador = $registros['Evaluador'];
        $ClienteOpcion = $registros['ClienteOpcion'];
    }
    $resultados->closeCursor();
    $sql = 'SELECT * FROM  tbl_encuesta_cabecera WHERE IdEncuestaCabecera = :Id && Activo = :Activo';
    $resultados = $base->prepare($sql);
    $resultados->execute([':Id' => $Id, ':Activo' => $activo]);
    $numero_registro = $resultados->rowCount();
    if (0 !== $numero_registro) {
        $registros = $resultados->fetch(PDO::FETCH_ASSOC);

        $NombreEncuesta = $registros['NombreEncuesta'];
    }
    $resultados->closeCursor();
    date_default_timezone_set('America/Santo_Domingo');
    if ('1' === $Encuestaactiva) {
        switch ($permiso) {
               case '1':

                    if ('CE' === $ClienteOpcion) {
                        header('Location:Encuestaevaluado.php?token='.$token.'');
                    } elseif ('TU' === $ClienteOpcion || 'TH' === $ClienteOpcion) {
                        header('Location:index.php?token='.$token.'');
                        eliminarEnlace($token);
                    }

                    break;
                case '2':
                                $autententicado = comprobarlogin();
                                    if ($autenticado) {
                                        header('Location:index.php?token='.$token.'');
                                    }

                    break;
                case '3':
                                if ($FechaExpiracion !== 0000 - 00 - 00) {
                                    $FechaActual = date('Y-m-d');

                                    if ($FechaExpiracion <= $FechaActual) {
                                        eliminarEnlace($token);
                                        header('Location:EncuestaExpirada.php?name='.$NombreEncuesta.'  & tipo=ha expirado,');
                                    } else {
                                        header('Location:index.php?token='.$token.'');
                                        eliminarEnlace($token);
                                    }
                                } else {
                                    header('Location:index.php?token='.$token.'');
                                    eliminarEnlace($token);
                                }

                    break;
                case '4':
                            header('Location:index.php?token='.$token.'');

                    break;
                case '5':
                         header('Location:https:../login.php?token='.$token.'');

                    break;
                default:
                    // code...
                    break;
            }
    } else {
        header('Location:EncuestaExpirada.php?name='.$NombreEncuesta.'  & tipo=está desabilitada,');
    }
} catch (Exception $e) {
}
