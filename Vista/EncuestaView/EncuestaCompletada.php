<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <title>
                Encuesta expirada
            </title>
            <link href="../css/styles.css" rel="stylesheet">
                <link href="../img/favicon.ico" rel="icon">
                    <meta content="width=device-width, initial-scale=1" name="viewport">
                    </meta>
                </link>
            </link>
        </meta>


         <script>
    function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}

</script>
    </head>
    <body onload="deshabilitaRetroceso()" class="FinalizarEncuesta">
        <center>
            <img align="center" alt="" class="img-responsive" height="200" src="../img/expirado.png" width="200"/>
            <br>
            </br>
        </center>
        <center>
            <h2>
                La encuesta a la cual ha entrado ha sido completada por este usuario
            </h2>
            <p>Favor de contactar a la persona que le compartió este enlace</p>
        </center>
    </body>
</html>
