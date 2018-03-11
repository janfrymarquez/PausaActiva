<?php
ini_set('session.cookie_lifetime', '3600');
ini_set('session.gc_maxlifetime', '3600');
session_start();

if (!isset($_SESSION['userlog'])) {
    header('location:login.php');
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

    <form    id="myform" name="myform" method="post" action="../Controlador/UsuarioControlador.php" enctype="multipart/form-data"  onsubmit="return checkForm(this);">

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
                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                    <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                  </div>
                </div>
              </div>

        <div class="table-wrapper">

            <table id="DataTable" class="table display table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
						             <th></th>
                        <th>Nombre</th>
                        <th>Apellido</th>
						            <th>Direccion</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
						<td>
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox1" name="options[]" value="1">
								<label for="checkbox1"></label>
							</span>
						</td>
                        <td>Thomas Hardy</td>
                        <td>Hardy</td>
                        <td>thomashardy@mail.com</td>
						             <td>89 Chiaroscuro Rd, Portland, USA</td>
                        <td>(171) 555-2222</td>

                        <td>
                            <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>






                </tbody>
            </table>

        </div>

	<!-- Edit Modal HTML -->
	<div id="addEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Add Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
              <div  id="UserNoDisponible">  </div>



                <label>Nombre del Cliente</label>

                <input type="text" class= "form-control"  name= "Cliente" id ="txt_cliente"  required />



              <label>Apellido</label>
              <input type="text" class= "form-control"  name= "Apellido" id ="Apellido"  required  />



              <label> Direccion</label>
                <input type="text" class= "form-control" name= "Direccion" id= "Direccion"  required />







              <label>Correo Electronico</label>
              <input type="email" class= "form-control"  name= "Email" id ="Email" required />


              <label>Telefono</label>
              <input type="text" class= "form-control" pattern="^[9|8|7|6]\d{8}$" name= "Telefono" id ="Telefono"   required />



               <label>Tipo de cliente</label>
               <select  class="my-select form-control TipoCliente" Id="TipoCliente">
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





              <div id="LebelDepartamento"></div>
              <div id="Slectopcitiondepartamento"></div>



						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Edit Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h4 class="modal-title">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>



            </div>
          </div>
        </div>
      </div>
    </form>




    		<script type="text/javascript">


    		$(document).ready(function(){




              var t = $('#DataTable').DataTable( {
       "columnDefs": [ {
           "searchable": false,
           "orderable": false,
           "targets": 0
       } ],
       "order": [[ 1, 'asc' ]]
   } );





         $('#DataTable_filter').addClass('search-box');

    $('#FormDepartamento').hide();
    				$("#TipoCliente").on('change', function(){

    					var TipoCliente = $(this).val();


    					switch (TipoCliente) {
    						case '1':
    						$('#Slectopcitiondepartamento').html("<select class='form-control Departamento select2'  id='Departamento'></select>");
    						$.ajax({
    							type: 'POST',
    							url: '../Controlador/UsuarioControlador.php',
    							data: 'EmpleadoInterno=' +TipoCliente,
    							success: function(html){


    								if(html== 'NoDisponible'){
    									$('#FormDepartamento').hide();
    								}

    								else {

    									$('#FormDepartamento').show();

    									$('#LebelDepartamento').html("<label>Departamento</label>");
    									$('#Departamento').html(html);
    									$('#Departamento').attr('name', 'EmpleadoInterno');
    									$(".select2").select2();4
    								}
    							}

    						});

    						break;
    						case '2':
    						$('#Slectopcitiondepartamento').html("<select class='form-control Departamento select2' multiple  id='Departamento'></select>");
    						$.ajax({
    							type: 'POST',
    							url: '../Controlador/UsuarioControlador.php',
    							data: 'EmpleadoExterno=' +TipoCliente,
    							success: function(html){


    								if(html== 'NoDisponible'){
    									$('#FormDepartamento').hide();
    								}

    								else {

    									$('#FormDepartamento').show();

    									$('#LebelDepartamento').html("<label>Heladeria</label>");
    									$('#Departamento').html(html);
    									$(".select2").select2();

    								}
    							}

    						});

    						break;
    						default:
    						$('#FormDepartamento').hide();

    					}


    				});




    		});


    		</script>




    	</body>
    	</html>
