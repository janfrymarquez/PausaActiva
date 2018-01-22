   <?php
$sql       = "SELECT * FROM  tbl_conf_repuesta";
$resultado = $base->prepare($sql);
$resultado->execute();
$numero_registro = $resultado->rowCount();

if ($numero_registro != 0) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {

        echo '<option value="' . $registro['IdConfiRepuesta'] . '" data-img-src="' . $registro['IconoConfiRepuesta'] . '">' . $registro['DescripConfiRepuesta'] . '</option>';
    }
} else {
    echo '<option value=""> Tipo de repuesta no disponible </option>';
}
?>