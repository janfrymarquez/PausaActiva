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

class Conexion
{
    public $conexion_db;

    public function Conexion()
    {
        try {
            $this->conexion_db = new PDO('mysql:host=191.97.89.52; dbname=hbon_sistemaencuesta', 'hbon_admin', '5572927@*');
            $this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conexion_db->exec('SET CHARACTER SET utf8');

            return $this->conexion_db;
        } catch (Exception $e) {
            echo '<script type="text/javascript">alert("Error al Conectar con la Base de Datos");</script>'.$e->GetMessage();
        }
    }
}
