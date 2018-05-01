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

session_start();
if (isset($_SESSION['userlog'])) {
    $fechaGuardada = $_SESSION['ultimoAcceso'];
    $idUsuario = $_SESSION['IdUsuarioActual'];

    $ahora = date('Y-n-j H:i:s');
    if ('SI' !== $_SESSION['autentificado']) {
        header('Location:login.php');

        return false;
    }
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));
    if ($tiempo_transcurrido >= 1200) {
        //1200 milisegundos = 1200/60 = 20 Minutos...
        session_destroy();
        header('Location:login.php');

        return false;
    }
    $_SESSION['ultimoAcceso'] = $ahora;
} else {
    header('Location:login.php');

    return false;
}

require '../Modelo/Conexion.php';

$Conexion = new Conexion();
$base = $Conexion->Conexion();

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Actualizar Perfil</title>

  </head>
  <body>
    <?php
    require 'header.php';
    ?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="#">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Forms Admin</li>
        </ol>
      </div><!--/.row-->

 <div class="container">
      <form >

        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">




                    <div class="col-md-6  offset-md-0  toppad" >
                        <div class="card">
                            <div class="card-body">
                              <form id="formActualizarPerfil "autocomplete="off">
                              </br><h3 class="modal-title">Actualizar tu datos</h3> </br></br>

                                          <div class="AddDiv col-xs-12 ">
                                            <div  id="UserNoDisponible">  </div>
                                          </div>

                                          <input type="text" class= "form-control required txt_idCliente hidden "  name="IdCliente" id ="txt_idCliente"  />

                                          <div id="Nombre-group1" class="form-group has-feedback">
                                              <label>Nombre</label> </br>
                                              <input type="text" class= "form-control required txt_cliente"  name="EdiNombre" id ="txt_cliente" autocomplete="off"  required ="" />
                                              <span id="iconForm" class="form-control-feedback SpanName "></span>
                                              <div class="Error_Nombre error"></div>
                                          </div>
                                          <div id="Apellido-group1" class="form-group has-feedback">
                                              <label>Apellido</label>
                                              <input type="text" class= "form-control required txt_Apellido"  name ="EdiApellido" id ="txt_Apellido"  autocomplete="off" required =""  />
                                              <span id="iconForm" class="form-control-feedback SpanApellido "></span>
                                              <div class="Error_apellido error"></div>
                                          </div>

                                          <div id="Direccion-group1" class="form-group has-feedback">
                                              <label> Direccion</label>
                                              <input type="text" class= "form-control required txt_Direccion " name="EdiDireccion" id= "txt_Direccion" autocomplete="off" required ="" />
                                              <span id="iconForm" class="form-control-feedback SpanDireccion "></span>
                                              <div class="Error_Direccion error"></div>
                                          </div>
                                          <div id="Email-group1" class="form-group has-feedback">
                                              <label for="txt_Email">Correo Electronico</label>
                                              <input type="email" class= "form-control required email txt_Email"  name="EdiEmail" id ="txt_Email" autocomplete="off" required ="" />
                                              <span id="iconForm" class="form-control-feedback SpanEmail "></span>
                                              <div class="Error_Email error"></div>
                                          </div>

                                          <div id="Telefono-group1" class="form-group has-feedback">
                                              <label>Telefono</label>
                                              <input type="number" class= "form-control txt_Telefono"  name= "EdiTelefono" id ="txt_Telefono"  autocomplete="off" required="" />
                                              <span id="iconForm" class="form-control-feedback SpanTele "></span>
                                              <div class="Error_Telefono error"></div>
                                          </div>


                                    <div class="">

                                      <button  name="addEditar" id="editarClienteForm" type="submit" class="btn btn-success addEditar pull-right "> Guardar </button>
                                    </div>
                              </form>



                            </div>
                        </div>
                    </div>
                <div class="col-md-6  offset-md-0  toppad">
                    <div class="card2">
                        <div class="card-body">
                            <h3 class="card-title">Cambia tu clave</h3></br>
                            <form  autocomplete="new-password">
                            <table class="table table-user-information ">



                                <tbody>
                                    <tr>
                                        <td>Clave actual:</td>
                                        <td>

                                            <input type="password" class= "form-control txt_password"  name= "password" id ="txt_password"  autocomplete="new-password" required="" />

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Calve nueva:</td>
                                        <td>
                                            <input type="password" class= "form-control txt_newPassword"  name= "txt_newPassword" id ="txt_newPassword" autocomplete="false"  required="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Repita clave nueva:</td>
                                        <td>
                                            <input type="password" class= "form-control txt_newPasswordConfir"  name= "txt_newPassword" id ="txt_newPasswordConfi"  autocomplete="false" required="" />
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <button  name="addEditar" id="CambiarPassword" type="submit" class="btn btn-success addEditar "> Cambiar Contraseña  </button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>



  </body>
</html>
