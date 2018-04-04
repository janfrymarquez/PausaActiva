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

class Encuesta extends Conexion
{
    public function ConstEncuesta()
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

    public function AgregarPregunta($pregunta)
    {
        for ($i = 0; $i < $number; ++$i) {
            if (trim('' !== $pregunta[$i])) {
                $sql = 'INSERT INTO tbl_name(name) VALUES(:pregunta)';
                $resultado = $this->conexion_db->prepare($sql);

                $resultado->execute([':pregunta' => $pregunta[i]]);
            }
        }

        $resultado->closeCursor();
    }

    public function getSubTipoEncuentaByTipoEncuentaID($TipoEncuesta)
    {
        $sql = 'SELECT * FROM  tbl_sub_encuesta WHERE IdTipoEncuesta   = :ID ORDER by SubTipoEncuesta ASC';

        $resultado = $this->conexion_db->prepare($sql);

        $resultado->execute([':ID' => $TipoEncuesta]);

        $numero_registro = $resultado->rowCount();

        if (0 !== $numero_registro) {
            echo '<option value=""> -- Seleciones un SubTipo de Encuesta -- </option>';
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$registro['IdSubTipoEncuesta'].'">'.$registro['SubTipoEncuesta'].'</option>';
            }
        } else {
            echo 'NoDisponible';
        }

        $resultado->closeCursor();
    }

    ///Funcion para octener clientes
    public function getClienteBySubTipoEncuenta($SubTipoEncuesta)
    {
        $sqlcliente = 'SELECT * FROM  tbl_clientes';

        $resultado = $this->conexion_db->prepare($sqlcliente);

        $resultado->execute();

        $numero_registro = $resultado->rowCount();

        if (0 !== $numero_registro) {
            echo '<option value=""> -- Seleciones los Clientes -- </option>';
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="'.$registro['IdClientes'].'">'.$registro['NombreCliente'].' '.$registro['ApellidoCliente'].'</option>';
            }
        } else {
            echo 'NoDisponible';
        }

        $resultado->closeCursor();
    }

    //Funcion para editarlos encuesta en al base de datos
    public function ActualizarDatosEncuesta($Datosactualizado)
    {
        date_default_timezone_set('America/Santo_Domingo'); //Se seleciona la zona horaria
        //array para guardar las pregunta y repuesta
        $encuestaDetalle = [
            'Pregunta' => [],
            'tipoRepuesta' => [],
            'Repuesta' => [],
            'IdEncuestaDetalle' => [],
        ];

        $cont = 0;

        //foreach para recorres los datos que se pasan por el formularioEncuesta
        foreach ($Datosactualizado as $obj) {
            $NombreEcnuesta = $obj->NombreEcnuesta;
            $TiposEncuesta = $obj->TiposEncuesta;
            $SubTipoEncuenta = $obj->SubTipoEncuenta;
            $IdEncuesta = $obj->IdEncuesta;
            $encuestaDetalle['Pregunta'][$cont] = $obj->Pregunta;
            $encuestaDetalle['tipoRepuesta'][$cont] = $obj->TipoRespuesta;
            $encuestaDetalle['Repuesta'][$cont] = implode(',', $obj->Respuesta);
            $encuestaDetalle['IdEncuestaDetalle'][$cont] = $obj->Id_Pregunta;

            ++$cont;
        }

        session_start(); // Se inicia seccion para tomar datos guadado en la seccion del usuario logueado

        $SubTipoEncuestaDetalle = '';
        $sqlSub = 'SELECT * FROM  tbl_sub_encuesta WHERE IdSubTipoEncuesta = :SubTipoEncuenta';
        $resultado = $this->conexion_db->prepare($sqlSub);
        $resultado->execute([':SubTipoEncuenta' => $SubTipoEncuenta]);
        $numero_registro = $resultado->rowCount();
        if (0 !== $numero_registro) {
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $SubTipoEncuestaDetalle = $registro['SubTipoEncuesta'];
            }
        }

        $IdSucursal = $_SESSION['IdSucursal'];
        $idSector = $_SESSION['IdSector'];
        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');

        // Se gurdan datos en la tabla tbl_encuesta_cabecera
        $sql = "UPDATE tbl_encuesta_cabecera set NombreEncuesta='${NombreEcnuesta}',
                                                TiposEncuesta='${TiposEncuesta}',
                                                SubTipoEncuenta='${SubTipoEncuenta}',
                                                Sucursal='${IdSucursal}',
                                                Sector='${idSector}',
                                                SubTipoEncuestaDetalle=' ${SubTipoEncuestaDetalle}',
                                                ModificadoPorUsuarioId='${idUsuario}',
                                                FechaModificacion ='{$FechaCreacion}'
                                                  WHERE IdEncuestaCabecera='${IdEncuesta}'";

        $resultado = $this->conexion_db->prepare($sql);
        $resultado->execute();

        // Se gurdan datos en la tabla tbl_encuesta_detalle
        $encuestaDetaSql = 'UPDATE tbl_encuesta_detalle set
        IdPreguntas=:IdPreguntas,
        Pregunta=:Pregunta,
        Repuesta=:Repuesta,
        TipoRepuesta=:TipoRepuesta WHERE IdEncuestaDetalle=:IdEncuestaDetalle';
        $Data = $this->conexion_db->prepare($encuestaDetaSql);

        for ($i = 0; $i < count($encuestaDetalle['Pregunta']); ++$i) {
            //Switch case para obtener descrion de la opciones para la encuesta
            $CampoRepuesta = '';

            switch ($encuestaDetalle['tipoRepuesta'][$i]) {
                case '6':
                    $sql3 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql3);
                    $resultado->execute([':Codigo' => 6]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }

                    break;
                case '7':
                    $sql1 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql1);
                    $resultado->execute([':Codigo' => 7]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }

                    break;
                case '8':
                    $sql2 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql2);
                    $resultado->execute([':Codigo' => 8]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }

                    break;
                default:
                    $CampoRepuesta = $encuestaDetalle['Repuesta'][$i];

                    break;
            }

            $Data->execute([':IdPreguntas' => $i + 1, ':Pregunta' => $encuestaDetalle['Pregunta'][$i], ':Repuesta' => $CampoRepuesta,
                ':TipoRepuesta' => $encuestaDetalle['tipoRepuesta'][$i], ':IdEncuestaDetalle' => $encuestaDetalle['IdEncuestaDetalle'][$i], ]);
        }
        $resultado->closeCursor();
    }

    //Fin de la funcion

    public function GuardarDatosEncuesta($dataArray)
    {
        date_default_timezone_set('America/Santo_Domingo'); //Se seleciona la zona horaria
        //array para guardar las pregunta y repuesta
        $encuestaDetalle = [
            'Pregunta' => [],
            'tipoRepuesta' => [],
            'Repuesta' => [],
        ];

        $cont = 0;

        //foreach para recorres los datos que se pasan por el formularioEncuesta
        foreach ($dataArray as $obj) {
            $NombreEcnuesta = $obj->NombreEcnuesta;
            $TiposEncuesta = $obj->TiposEncuesta;
            $SubTipoEncuenta = $obj->SubTipoEncuenta;

            $encuestaDetalle['Pregunta'][$cont] = $obj->Pregunta;
            $encuestaDetalle['tipoRepuesta'][$cont] = $obj->TipoRespuesta;

            $encuestaDetalle['Repuesta'][$cont] = implode(',', $obj->Respuesta);
            ++$cont;
        }

        session_start(); // Se inicia seccion para tomar datos guadado en la seccion del usuario logueado

        $IdSucursal = $_SESSION['IdSucursal'];
        $idSector = $_SESSION['IdSector'];
        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');
        $prefig = $idUsuario.+$idSector.+$IdSucursal;
        $IdEncuesta = uniqid($prefig);
        // Se gurdan datos en la tabla tbl_encuesta_cabecera

        $SubTipoEncuestaDeta = '';
        $sqlSub = 'SELECT * FROM  tbl_sub_encuesta WHERE IdSubTipoEncuesta = :SubTipoEncuenta';
        $resultado = $this->conexion_db->prepare($sqlSub);
        $resultado->execute([':SubTipoEncuenta' => $SubTipoEncuenta]);
        $numero_registro = $resultado->rowCount();
        if (0 !== $numero_registro) {
            while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $SubTipoEncuestaDetalle = $registro['SubTipoEncuesta'];
            }
        }
        $resultado->closeCursor();
        $sql = 'INSERT INTO tbl_encuesta_cabecera (IdEncuestaCabecera,NombreEncuesta,TiposEncuesta,SubTipoEncuenta,SubTipoEncuestaDetalle,Sucursal,Sector,CreadoPorUsuarioId,FechaCreacion) VALUES
                                                    (:IdEncuestaCabecera,:NombreEncuesta, :TiposEncuesta,:SubTipoEncuenta,:SubTipoEncuestaDetalle,:Sucursal,:Sector, :CreadoPorUsuarioId,:FechaCreacion) ';

        $resultado = $this->conexion_db->prepare($sql);
        $resultado->execute([':IdEncuestaCabecera' => $IdEncuesta, ':NombreEncuesta' => $NombreEcnuesta, ':TiposEncuesta' => $TiposEncuesta, ':SubTipoEncuenta' => $SubTipoEncuenta, ':SubTipoEncuestaDetalle' => $SubTipoEncuestaDetalle, ':Sucursal' => $IdSucursal,
            ':Sector' => $idSector, ':CreadoPorUsuarioId' => $idUsuario, 'FechaCreacion' => $FechaCreacion, ]);
        // Se gurdan datos en la tabla tbl_encuesta_detalle
        $encuestaDetaSql = 'INSERT INTO tbl_encuesta_detalle (IdEncuesta,IdPreguntas,Pregunta,Repuesta,TipoRepuesta) VALUES
                            (:IdEncuesta,:IdPreguntas, :Pregunta,:Repuesta,:TipoRepuesta)';
        $Data = $this->conexion_db->prepare($encuestaDetaSql);

        for ($i = 0; $i < count($encuestaDetalle['Pregunta']); ++$i) {
            //Switch case para obtener descrion de la opciones para la encuesta
            $CampoRepuesta = '';

            switch ($encuestaDetalle['tipoRepuesta'][$i]) {
                case '6':
                    $sql3 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql3);
                    $resultado->execute([':Codigo' => 6]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }
                    $resultado->closeCursor();

                    break;
                case '7':
                    $sql1 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql1);
                    $resultado->execute([':Codigo' => 7]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }
                    $resultado->closeCursor();

                    break;
                case '8':
                    $sql2 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql2);
                    $resultado->execute([':Codigo' => 8]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }
                    $resultado->closeCursor();

                    break;
                default:
                    $CampoRepuesta = $encuestaDetalle['Repuesta'][$i];

                    break;
            }

            $Data->execute([':IdEncuesta' => $IdEncuesta, ':IdPreguntas' => $i + 1, ':Pregunta' => $encuestaDetalle['Pregunta'][$i], ':Repuesta' => $CampoRepuesta,
                ':TipoRepuesta' => $encuestaDetalle['tipoRepuesta'][$i], ]);
        }
        $resultado->closeCursor();
    }

    public function InsertarDatosOnEncuesta($dataArray)
    {
        date_default_timezone_set('America/Santo_Domingo'); //Se seleciona la zona horaria
        //array para guardar las pregunta y repuesta
        $encuestaDetalle = [
            'Pregunta' => [],
            'tipoRepuesta' => [],
            'Repuesta' => [],
        ];

        $cont = 0;

        //foreach para recorres los datos que se pasan por el formularioEncuesta
        foreach ($dataArray as $obj) {
            $NombreEcnuesta = $obj->NombreEcnuesta;
            $TiposEncuesta = $obj->TiposEncuesta;
            $SubTipoEncuenta = $obj->SubTipoEncuenta;
            $IdEncuesta = $obj->IdEncuesta;
            $idPregunta = $obj->Id_Pregunta;

            $encuestaDetalle['Pregunta'][$cont] = $obj->Pregunta;
            $encuestaDetalle['tipoRepuesta'][$cont] = $obj->TipoRespuesta;

            $encuestaDetalle['Repuesta'][$cont] = implode(',', $obj->Respuesta);
            ++$cont;
        }

        session_start(); // Se inicia seccion para tomar datos guadado en la seccion del usuario logueado

        $FechaCreacion = date('Y/m/d');

        $encuestaDetaSql = 'INSERT INTO tbl_encuesta_detalle (IdEncuesta,IdPreguntas,Pregunta,Repuesta,TipoRepuesta) VALUES
                            (:IdEncuesta,:IdPreguntas, :Pregunta,:Repuesta,:TipoRepuesta)';
        $Data = $this->conexion_db->prepare($encuestaDetaSql);

        for ($i = 0; $i < count($encuestaDetalle['Pregunta']); ++$i) {
            //Switch case para obtener descrion de la opciones para la encuesta
            $CampoRepuesta = '';

            switch ($encuestaDetalle['tipoRepuesta'][$i]) {
                case '6':
                    $sql3 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql3);
                    $resultado->execute([':Codigo' => 6]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }

                    break;
                case '7':
                    $sql1 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql1);
                    $resultado->execute([':Codigo' => 7]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }

                    break;
                case '8':
                    $sql2 = 'SELECT * FROM  tbl_conf_repuesta WHERE IdConfiRepuesta = :Codigo';
                    $resultado = $this->conexion_db->prepare($sql2);
                    $resultado->execute([':Codigo' => 8]);
                    $numero_registro = $resultado->rowCount();
                    if (0 !== $numero_registro) {
                        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
                            $CampoRepuesta = $registro['DescripConfiRepuesta'];
                        }
                    }

                    break;
                default:
                    $CampoRepuesta = $encuestaDetalle['Repuesta'][$i];

                    break;
            }

            $Data->execute([':IdEncuesta' => $IdEncuesta, ':IdPreguntas' => $idPregunta, ':Pregunta' => $encuestaDetalle['Pregunta'][$i], ':Repuesta' => $CampoRepuesta,
                ':TipoRepuesta' => $encuestaDetalle['tipoRepuesta'][$i], ]);
        }
    }

    //fin Funcion Guardar Datos Encuesta

    public function EliminarPreguntaEncuesta($IDPregunta)
    {
        $sqlEliminarPregunta = "DELETE FROM tbl_encuesta_detalle WHERE IdEncuestaDetalle = '${IDPregunta}' ";
        $resultado = $this->conexion_db->prepare($sqlEliminarPregunta);
        $resultado->execute();

        $numero_registro = $resultado->rowCount();
        if (0 === $numero_registro) {
            echo '<script type="text/javascript">alert("Pregunta no eliminada");</script>';
        }
    }

    public function GuardarResultadosEncuesta($resultadoArrayEncuesta)
    {
        date_default_timezone_set('America/Santo_Domingo'); //Se seleciona la zona horaria

        $fechaCreacion = date('Y-m-d');
        $horaCreacion = date('H:i:s');
        function getRealIP()
        {
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                return $_SERVER['HTTP_CLIENT_IP'];
            }
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            if (isset($_SERVER['HTTP_X_FORWARDED'])) {
                return $_SERVER['HTTP_X_FORWARDED'];
            }
            if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_FORWARDED_FOR'];
            }
            if (isset($_SERVER['HTTP_FORWARDED'])) {
                return $_SERVER['HTTP_FORWARDED'];
            }

            return $_SERVER['REMOTE_ADDR'];
        }

        $direccionIp = getRealIP();

        $guardarResultadoSql = 'INSERT INTO tbl_resultados (IdPregunta,IdEncuesta,CampoSelecionado,DireccionIpCreacion,FechaCreacion,HoraCreacion) VALUES
                                  (:IdPregunta,:IdEncuesta, :CampoSelecionado, :DireccionIpCreacion,:FechaCreacion,:HoraCreacion)';
        $Data = $this->conexion_db->prepare($guardarResultadoSql);
        $idPregunta = [];
        $respSelec = [];
        $EncuestaId = '';
        foreach ($resultadoArrayEncuesta as $key => $value) {
            $idPregunta = $value->Id_Pregunta;
            $respSelec = $value->RepuestaSelec;
            $EncuestaId = $value->IdEncuesta;
        }
        for ($i = 0; $i < count($idPregunta); ++$i) {
            $Data->execute([':IdPregunta' => $idPregunta[$i], ':IdEncuesta' => $EncuestaId, ':CampoSelecionado' => $respSelec[$i], ':DireccionIpCreacion' => $direccionIp, ':FechaCreacion' => $fechaCreacion,
                ':HoraCreacion' => $horaCreacion, ]);
        }
        $Data->closeCursor();
    }

    public function getUrlEncuesta($GetUrlbyEncuestaId, $PermisoUrl, $FechaExpiracion, $ClienteAEvaluar, $Evaluador, $mensaje, $clienteOpcion)
    {
        $Clientes = [];
        $TipodeClientes = [];
        $Cliente = '';
        $TipodeCliente = '';
        $evaluador = '';
        $clieteText = '';
        $temp = '';

        if ('' === $FechaExpiracion) {
            $FechaExpiracion = null;
        }

        if (empty($ClienteAEvaluar)) {
            $ClienteAEvaluar = null;
        }

        if (empty($Evaluador)) {
            $Evaluador = null;
        }

        if (null !== $ClienteAEvaluar) {
            for ($i = 0; $i < count($ClienteAEvaluar); ++$i) {
                $clieteText = $ClienteAEvaluar[$i];
                $temp = explode('/', $clieteText);
                array_push($Clientes, $temp[0]);
                array_push($TipodeClientes, $temp[1]);
            }
        }

        if (null !== $Evaluador) {
            for ($i = 0; $i < count($Evaluador); ++$i) {
                $evaluador = implode(',', $Evaluador);
            }
        }
        $sqlevaluado = 'INSERT INTO tbl_evaluados (TipoCliente,IdCliente,IdToken,idEncuesta,FechaCreacion,CreadoPorUsuarioId) VALUES
                                                                   (:TipoCliente,:IdCliente, :IdToken, :idEncuesta, :FechaCreacion,:CreadoPorUsuarioId)';

        session_start();
        $idUsuario = $_SESSION['IdUsuarioActual'];
        $FechaCreacion = date('Y/m/d');
        $token = sha1(uniqid());
        $url = "http://lhbjjmarquez/SistemaEncuesta/Vista/EncuestaView/PrepareEncuesta.php?token=${token}";

        if (count($Clientes) > 0) {
            $Data = $this->conexion_db->prepare($sqlevaluado);

            for ($i = 0; $i < count($Clientes); ++$i) {
                $Data->execute([':TipoCliente' => $TipodeClientes[$i], ':IdCliente' => $Clientes[$i], ':IdToken' => $token, ':idEncuesta' => $GetUrlbyEncuestaId, ':FechaCreacion' => $FechaCreacion, ':CreadoPorUsuarioId' => $idUsuario]);
            }
            $Data->closeCursor();
        }

        $sql = 'INSERT INTO tbl_token(token, Url, FechaEspiracion,IdEncuesta, Evaluador, Mensaje,ClienteOpcion,Permiso,FechaCreacion,CreadoPorUsuarioId) VALUES
                          (:token, :Url,:FechaEspiracion,:IdEncuesta,:Evaluador,:Mensaje, :ClienteOpcion, :Permiso,:FechaCreacion, :CreadoPorUsuarioId ) ';
        $Data = $this->conexion_db->prepare($sql);

        $Data->execute([':token' => $token, ':Url' => $url, ':FechaEspiracion' => $FechaExpiracion, ':IdEncuesta' => $GetUrlbyEncuestaId, ':Evaluador' => $evaluador, ':Mensaje' => $mensaje, ':ClienteOpcion' => $clienteOpcion, ':Permiso' => $PermisoUrl, ':FechaCreacion' => $FechaCreacion, ':CreadoPorUsuarioId' => $idUsuario]);
        $Data->closeCursor();
        print_r($url);
    }
}
