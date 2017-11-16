<?php

include 'conection.php'
class  PausaActiva{
	
	
	var $ IdDepartamento;
	var IdVideo;
	var Dias;
	var HoraEjecucion; 
	var Tanda; 
	var $CreadoPorUsuarioID;
	var $ModificadoPorUsuarioId;
	var $FechaCreacion;
	var $FechaModificacion;
	var $Activo;
	var $IdPausaActiva;
	
	
	function _construct() {
		
	}
	
	function guardar() {
		
	  if ($this -> IdPausaActiva >0){
			$sql = "UPDATE tbl_pausa_activa SET

				IdDepartamento = '$this -> IdDepartamento',
				IdVideo = '$this ->IdVideo'
				Dias = '$this ->Dias'
				HoraEjecucion` = '$this ->HoraEjecucion'
				Tanda = '$Tanda'
				CreadoPorUsuarioId = '$this -> CreadoPorUsuarioId',
				ModificadoPorUsuarioId = '$this ->ModificadoPorUsuarioId',
				FechaCreacion = '$this ->FechaCreacion',
				FechaModificacion = '$this ->FechaModificacion',

				WHERE IdPausaActiva = '$this -> IdPausaActiva' ";
				
				mysql_query($sql);
				
		}
			
		else {
			$sql = " INSERT INTO tbl_pausa_activa 
			(IdDepartamento,IdVideo,Dias,HoraEjecucion,Tanda,CreadoPorUsuarioId,ModificadoPorUsuarioId,FechaCreacion,FechaModificacion,)
			VALUES
			('$this ->IdDepartamento','$this ->IdVideo','$this ->Dias','$this ->HoraEjecucion','$this ->Tanda','$this ->CreadoPorUsuarioId','$this ->ModificadoPorUsuarioId','$this ->FechaCreacion','$this ->FechaModificacion',)";	
		mysql_query($sql);
		$this ->IdPausaActiva =mysql_insert_id();
		}
		
		
	}  //Funcion Insertar y actualizar 
	
	function Cargar (){
		
		$sql= " SELECT  * from vw_pausa_activa where IdPausaActiva = '$this->IdPausaActiva'";
    
    		  $rs= mysql_query($sql);
		$Arreglo = new array();

		while ($row = mysql_num_rows($rs) > 0 {
		  $Arreglo[] = $row;
		}
	
		print_r($Arreglo);




	
	}
	
	
	
	
	
	function _construct() {
		
	}
	
	
	
	
	
	
	
	
	
	
	?>