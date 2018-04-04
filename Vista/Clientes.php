<?php
session_start();
if (isset($_SESSION['userlog'])) {
    $fechaGuardada = $_SESSION['ultimoAcceso'];
    $idUsuario = $_SESSION['IdUsuarioActual'];
    $permiso = $_SESSION['Permiso'];

    switch ($_SESSION['Permiso']) {
        case '2':
            header('Location:charts.php');

            break;
        case '4':
            header('Location:CompleteEncuesta.php');

            break;
        case '1':

            break;
        default:
            header('Location:../index.php');

            break;
    }

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
<html>
<head>
  <meta charset="utf-8">
  <link rel="icon" href="img/favicon.ico">
  <link rel="stylesheet" href="css/responsive.dataTables.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Crear Clientes</title>




  <style type="text/css" media="screen">
  .No_Disponible{
    background-color:#FFAAAA;

    font-weight: bold;
    color: #999999;
    font-size:15px;
  }

</style>
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

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"></h1>
      </div>
    </div><!--/.row-->

    <form >

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">

            <div class="panel-body">
              <div class="table-title">
                <div class="row">
                  <div class="col-sm-6">
                    <h2>Administrar  <b>Clientes</b></h2>
                  </div>
                  <div class="col-sm-6">
                    <a href="#addEmployeeModal"  title="Agregar nuevos clientes" id="AddCliente" class="btn btn-success float-right  col-sm-4 AddCliente" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Agregar cliente</span></a>

                  </div>
                </div>
              </div>


              <div class="col-xs-12">



                  <div id="DatosTable" class="table-wrapper">
                      <div class="DivLoader"></div>
                      <div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
                      <div class="outer_div"></div><!-- Datos ajax Final -->
                  </div>




                        <!-- Add Modal HTML -->
                        <div id="addEmployeeModal" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form id="formAddCliente" autocomplete="off">
                                <div class="modal-header">
                                  <h4 class="modal-title">Agregar empleado</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="AddDiv col-xs-12 ">
                                        <div  id="UserNoDisponible">  </div>
                                    </div>

                                      <div id="Nombre-group" class="form-group has-feedback">
                                          <label>Nombre del Cliente (*)</label> </br>
                                          <input type="text" class= "form-control required"  name= "Nombre" id ="txt_cliente"  required ="" />
                                            <span id="iconForm" class="form-control-feedback SpanName "></span>
                                          <div class="Error_Nombre error"></div>
                                      </div>
                                      <div id="Apellido-group" class="form-group has-feedback">
                                          <label>Apellido (*)</label>
                                          <input type="text" class= "form-control required"  name= "Apellido" id ="txt_Apellido"  required =""  />
                                            <span id="iconForm" class="form-control-feedback SpanApellido "></span>
                                          <div class="Error_apellido error"></div>
                                      </div>

                                      <div id="Direccion-group" class="form-group has-feedback">
                                        <label> Direccion (*)</label>
                                          <input type="text" class= "form-control required has-error" name= "Direccion" id= "txt_Direccion"  required ="" />
                                            <span id="iconForm" class="form-control-feedback SpanDireccion "></span>
                                          <div class="Error_Direccion error"></div>
                                      </div>

                                      <div id="Email-group" class="form-group has-feedback">
                                        <label for="txt_Email">Correo Electronico (*)</label>
                                        <input type="email" class= "form-control required email"  name= "Email" id ="txt_Email" required ="" />
                                        <span id="iconForm" class="form-control-feedback SpanEmail "></span>
                                        <div class="Error_Email error"></div>
                                      </div>

                                      <div id="Telefono-group" class="form-group has-feedback">
                                        <label>Telefono</label>
                                        <input type="number" class= "form-control"  name= "Telefono" id ="txt_Telefono"   required="" />
                                          <span id="iconForm" class="form-control-feedback SpanTele "></span>
                                            <div class="Error_Telefono error"></div>
                                      </div>

                                      <div id="TipoCliente-group" class="form-group has-feedback">

                                          <label>Tipo de cliente (*)</label>
                                              <select  class="my-select form-control TipoCliente required" name="TipoCliente" Id="TipoCliente">
                                                  <option disabled selected value> --Elija una opcion-- </option>

                                                  <?php
$sql = 'SELECT * FROM  tbl_tipo_clientes';
$resultado = $base->prepare($sql);
$resultado->execute();
$numero_registro = $resultado->rowCount();

if (0 !== $numero_registro) {
    while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$registro['IdAreaCliente'].'">'.$registro['TipoCliente'].'</option>';
    }
} else {
    echo '<option value="">  Tipo de repuesta no disponibles </option>';
}
?>
                                              </select>
                                                <span id="iconForm" class="form-control-feedback SpanTipo "></span>
                                            <div class="Error_TipoCliente"></div>
                                      </div>


                                    <div id="LebelDepartamento"></div>
                                    <div id="Slectopcitiondepartamento">
                                      <span id="iconForm" class="form-control-feedback SpanDepa "></span>
                                        <div class="Error_Departamento"></div>
                                    </div>

                                </div>
                                <div class="modal-footer">

                                  <button  name="reset" type="reset"  data-dismiss="modal" class="btn btn-danger"> Cerrar </button>
                                  <button  name="add" type="submit" class="btn btn-success add"> Guardar </button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- Edit Modal HTML -->
                        <div id="editEmployeeModal" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form id="editFormCliente">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Editar clientes</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                          <div class="AddDiv col-xs-12 ">
                                            <div  id="UserNoDisponible">  </div>
                                          </div>

                                          <input type="text" class= "form-control required txt_idCliente hidden "  name="IdCliente" id ="txt_idCliente"  />

                                          <div id="Nombre-group1" class="form-group has-feedback">
                                              <label>Nombre del Cliente (*)</label> </br>
                                              <input type="text" class= "form-control required txt_cliente"  name="EdiNombre" id ="txt_cliente"  required ="" />
                                              <span id="iconForm" class="form-control-feedback SpanName "></span>
                                              <div class="Error_Nombre error"></div>
                                          </div>
                                          <div id="Apellido-group1" class="form-group has-feedback">
                                              <label>Apellido (*)</label>
                                              <input type="text" class= "form-control required txt_Apellido"  name ="EdiApellido" id ="txt_Apellido"  required =""  />
                                              <span id="iconForm" class="form-control-feedback SpanApellido "></span>
                                              <div class="Error_apellido error"></div>
                                          </div>

                                          <div id="Direccion-group1" class="form-group has-feedback">
                                              <label> Direccion (*)</label>
                                              <input type="text" class= "form-control required txt_Direccion " name="EdiDireccion" id= "txt_Direccion"  required ="" />
                                              <span id="iconForm" class="form-control-feedback SpanDireccion "></span>
                                              <div class="Error_Direccion error"></div>
                                          </div>
                                          <div id="Email-group1" class="form-group has-feedback">
                                              <label for="txt_Email">Correo Electronico (*)</label>
                                              <input type="email" class= "form-control required email txt_Email"  name="EdiEmail" id ="txt_Email" required ="" />
                                              <span id="iconForm" class="form-control-feedback SpanEmail "></span>
                                              <div class="Error_Email error"></div>
                                          </div>

                                          <div id="Telefono-group1" class="form-group has-feedback">
                                              <label>Telefono</label>
                                              <input type="number" class= "form-control txt_Telefono"  name= "EdiTelefono" id ="txt_Telefono"   required="" />
                                              <span id="iconForm" class="form-control-feedback SpanTele "></span>
                                              <div class="Error_Telefono error"></div>
                                          </div>

                                    </div>
                                    <div class="modal-footer">
                                      <button  name="reset" type="reset"  data-dismiss="modal" class="btn btn-danger"> Cerrar </button>
                                      <button  name="addEditar" id="editarClienteForm" type="submit" class="btn btn-success addEditar"> Guardar </button>
                                    </div>
                              </form>
                            </div>
                          </div>
                        </div>

                                       <!-- Delete Modal HTML -->
                        <div id="deleteClienteModal" class="modal fade">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <form id="eliminarDatos">
                                <div class="modal-header">
                                  <h4 class="modal-title">Borrar cliente</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      </div>
                                        <div class="modal-body">
                                          <div  id="borrarClienteMensaje" class="borrarClienteMensaje"></div>
                                          <p class="text-warning"><small>Una vez borrado no es posible recuperarlo.</small></p>
                                        </div>
                                      <div class="modal-footer">
                                  <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                  <input type="submit"  class="btn btn-danger" id="BorrarCliente" value="Delete">
                                </div>
                              </UsuarioControlador.php>
                            </div>
                          </div>
                        </div>
            </div>
          </div>
        </div>
      </div>
    </form>

<script src="js/dataTables.responsive.min.js">

</script>

<script src="js/clientes.js"></script>
        <script type="text/javascript">


        $(document).ready(function(){

          load(1);

        });

        </script>




      </body>
      </html>
