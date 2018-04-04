

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Finalizar Encuesta</title>

  </head>

 <script>
	function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}

</script>

</script>
  <body onload="deshabilitaRetroceso()" class="FinalizarEncuesta">

  </br></br></br></br></br><center> 	<img src="../img/success.png" class="img-responsive"   width="400"  align=center  alt=""></center></br>

<center> <h1 >La encuesta se ha finalizado de manera exitosa</h1></center>


  </body>
</html>
