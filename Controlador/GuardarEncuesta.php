<?php

require "../Modelo/cls_Encuesta.php";

$Encuesta = new Encuesta();

//////////////////////// PRESIONAR EL BOTÓN //////////////////////////
if (isset($_POST['submit'])) {

    if (isset($_POST['NombreEncuesta']) && !empty($_POST['NombreEncuesta'])) {

        $NombreEncuesta = $_POST['NombreEncuesta'];
    } else if (isset($_POST['TipoEncuesta']) && !empty($_POST['TipoEncuesta'])) {
        $TipoEncuesta = $_POST['TipoEncuesta'];
    } else if (isset($_POST['SubTipoEncuenta']) && !empty($_POST['SubTipoEncuenta'])) {

        $SubTipoEncuenta = $_POST['SubTipoEncuenta'];
    } else if (isset($_POST['TipoDeRepuesta']) && !empty($_POST['TipoDeRepuesta'])) {

        $TipoDeRepuesta = ($_POST['TipoDeRepuesta']);
    }
    echo $NombreEncuesta;

    echo $TipoEncuesta;

    echo $SubTipoEncuenta;

    $Pregunta = ($_POST['Pregunta']);

/*

///////////// SEPARAR VALORES DE ARRAYS, EN ESTE CASO SON 4 ARRAYS UNO POR CADA INPUT (ID, NOMBRE, CARRERA Y GRUPO////////////////////)
while(true) {

//// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
$item1 = current($items1);
$item2 = current($items2);
$item3 = current($items3);
$item4 = current($items4);

////// ASIGNARLOS A VARIABLES ///////////////////
$id=(( $item1 !== false) ? $item1 : ", &nbsp;");
$nom=(( $item2 !== false) ? $item2 : ", &nbsp;");
$carr=(( $item3 !== false) ? $item3 : ", &nbsp;");
$gru=(( $item4 !== false) ? $item4 : ", &nbsp;");

//// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
$valores='('.$id.',"'.$nom.'","'.$carr.'","'.$gru.'"),';

//////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
$valoresQ= substr($valores, 0, -1);

///////// QUERY DE INSERCIÓN ////////////////////////////
$sql = "INSERT INTO alumnos (id_alumno, nombre, carrera, grupo)
VALUES $valoresQ";

$sqlRes=$conexion->query($sql) or mysql_error();

// Up! Next Value
$item1 = next( $items1 );
$item2 = next( $items2 );
$item3 = next( $items3 );
$item4 = next( $items4 );

// Check terminator
if($item1 === false && $item2 === false && $item3 === false && $item4 === false) break;

}
 */
}
