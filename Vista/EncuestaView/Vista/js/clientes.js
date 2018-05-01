function load(page) {
  var parametros = {
    "action": "ajax",
    "page": page
  };
  $("#DatosTable").fadeIn('slow');
  $.ajax({
    url: '../Controlador/ClienteControlador.php',
    data: parametros,
    beforeSend: function(objeto) {
      $(".DivLoader").addClass('loader');
    },
    success: function(data) {

      $(".DivLoader").removeClass('loader');
      $("#DatosTable").html(data).fadeIn('slow');
      $(".DivLoader").html("");

      var t = $('#DataTable').DataTable({
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": 0,
          "visible": false
        }],

        "order": [
          [1, 'asc']
        ]
      });
      $('#DataTable_filter').addClass('search-box');
    }
  });
}







$(document).ready(function() {


  $('#editEmployeeModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var Nombre = button.data('nombre')
    var id = button.data('id')
    var Apellido = button.data('apellido')
    var Direccion = button.data('direccion')
    var Email = button.data('email')
    var Telefono = button.data('telefono')
    var modal = $(this);



    modal.find('.modal-body #txt_idCliente').val(id);
    modal.find('.modal-body #txt_cliente').val(Nombre);
    modal.find('.modal-body #txt_Apellido').val(Apellido);
    modal.find('.modal-body #txt_Direccion').val(Direccion);
    modal.find('.modal-body #txt_Email').val(Email);
    modal.find('.modal-body #txt_Telefono').val(Telefono);

  });




  $('#deleteClienteModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var id = button.data('id') // Extraer la información de atributos de datos
    var nombre = button.data('nombre');
    var modal = $(this);

    modal.find('.modal-body #borrarClienteMensaje').html('<p id="' + id + '" class="BorrarClienteID">Esta seguro que desea elimanar el Cliente ' + nombre + '?</p>')

  });

  $('#DesactivarPermiso').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var id = button.data('id') // Extraer la información de atributos de datos
    var nombre = button.data('nombre');
    var modal = $(this);

    modal.find('.modal-body #DesactivarPermisoUser').html('<p id="' + id + '" class="DesactivarPermisoClienteID">Se deshabilitará el acceso al sistema para  ' + nombre + '</p>')

  });

  $('#ActivarPermiso').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var id = button.data('id') // Extraer la información de atributos de datos
    var nombre = button.data('nombre');
    var email = button.data('email');
    var apellido = button.data('apellido');
    var modal = $(this);


    modal.find('.modal-body #txt_idClientePA').val(id);
    modal.find('.modal-body #txt_NombreAP').val(nombre);
    modal.find('.modal-body #txt_EmailAP').val(email);
    modal.find('.modal-body #txt_Apellidoap').val(apellido);


  });

  $('#txt_username').focusout(function(e) {
    var usuario = $("#txt_username").val();

    $.ajax({
      url: "../Controlador/UsuarioControlador.php",
      type: "POST",
      data: {
        username: usuario
      },

      success: function(data, textStatus) {
        $("#FormUsuario").addClass("has-success");
        console.log(data);
        if (data == "existe") {
          $("#EnviarPermisoUsuario").attr("disabled", true);
          $("#Usuario-group").addClass("has-error");
          $("#UserNoDisponibles").html('<div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El nombre de usuario no esta disponible  </div>');
          return false;
        } else {

          $("#EnviarPermisoUsuario").removeAttr("disabled");
          $("#Usuario-group").removeClass("has-error");
          $("#Usuario-group").addClass("has-success");
          $("#UserNoDisponibles").html('');
        }
      },
      error: function(jqXHR, textStatus) {
        alert("Algo Fallo");
      }
    });

  });



  $('#EnviarPermisoUsuario').click(function(e) {
    var formDataActivePermiso = {
      'IdCliente': $('#txt_idClientePA').val(),
      'Usuario': $.trim($('#txt_username').val()),
      'Permiso': $.trim($('#permisoUsuario').val()),
      'Nombre': $.trim($('#txt_NombreAP').val()),
      'Email': $.trim($('#txt_EmailAP').val()),
      'Apellido': $.trim($('#txt_Apellidoap').val()),
      'Password': "EncuestaBon",
      'EnviarActivarPermiso': 'Sent'
    }

    event.preventDefault();



    $.ajax({
        url: "../Controlador/ClienteControlador.php",
        type: "POST",
        data: formDataActivePermiso,
        dataType: 'json',
        encode: true,


      })

      .done(function(Datos) {


        if (!Datos.success) {


          if (Datos.errors.usuario) {
            $('#Usuario-group').addClass('has-error');
            $('.SpanUser').addClass('glyphicon glyphicon-remove');
            $('.Error_Usuario').html('<div class="help-block">' + Datos.errors.usuario + '</div>');

          }

        } else {

          $('.form-group').removeClass('has-error');
          $('.help-block').remove();
          $('#iconForm').removeClass('glyphicon glyphicon-remove ');

          $(function() {
            $(this)

              .find("input,textarea,select")
              .val('')
              .end()
            $('#ActivarPermiso').modal('toggle');
          });

          load(1);

        }

      });
  });

  $("#BorrarCliente").click(function(e) {
    event.preventDefault();
    var IdCliente = $('.BorrarClienteID').attr('id');



    $.ajax({
      type: "POST",
      url: "../Controlador/ClienteControlador.php",
      data: 'IdClienteBorrar=' + IdCliente,
      beforeSend: function(objeto) {
        $(".datos_ajax_delete").addClass('loader');
      },
      success: function(datos) {
        console.log(datos);
        $(".datos_ajax_delete").removeClass('loader');
        $('#deleteClienteModal').modal('toggle');
        load(1);
      }
    });



  });


  $("#btnDesactivarPermiso").click(function(e) {
    event.preventDefault();
    var IdClienteDesactivar = $('.DesactivarPermisoClienteID').attr('id');



    $.ajax({
      type: "POST",
      url: "../Controlador/ClienteControlador.php",
      data: 'IdClienteDesactivarPermiso=' + IdClienteDesactivar,
      beforeSend: function(objeto) {
        $(".datos_ajax_delete").addClass('loader');
      },
      success: function(datos) {
        console.log(datos);
        $(".datos_ajax_delete").removeClass('loader');
        $('#DesactivarPermiso').modal('toggle');
        load(1);
      }
    });



  });


  $('#FormDepartamento').hide();
  $("#TipoCliente").on('change', function() {

    var TipoCliente = $(this).val();


    switch (TipoCliente) {
      case '1':
        $('#Slectopcitiondepartamento').html("<select class='form-control Departamento select2'  id='Departamento'></select>");
        $.ajax({
          type: 'POST',
          url: '../Controlador/UsuarioControlador.php',
          data: 'EmpleadoInterno=' + TipoCliente,
          success: function(html) {


            if (html == 'NoDisponible') {
              $('#FormDepartamento').hide();
            } else {

              $('#FormDepartamento').show();

              $('#LebelDepartamento').html("<label>Departamento</label>");
              $('#Departamento').html(html);
              $('#Departamento').attr('name', 'EmpleadoInterno');
              $(".select2").select2();
            }
          }

        });

        break;
      case '2':
        $('#Slectopcitiondepartamento').html("<select class='form-control Departamento select2'   id='Departamento'></select>");
        $.ajax({
          type: 'POST',
          url: '../Controlador/UsuarioControlador.php',
          data: 'EmpleadoExterno=' + TipoCliente,
          success: function(html) {


            if (html == 'NoDisponible') {
              $('#FormDepartamento').hide();
            } else {

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


  $('#txt_cliente').keypress(function(e) {
    $('#Nombre-group').removeClass('has-error');
    $('#Nombre-group').addClass('has-success');
    $('.Error_Nombre').remove();
    $('.SpanName').removeClass('glyphicon glyphicon-remove ');
    $('.SpanName').addClass('glyphicon glyphicon-ok ');
  });


  $('#txt_Direccion').keypress(function(e) {
    $('#Direccion-group').removeClass('has-error');
    $('#Direccion-group').addClass('has-success');
    $('.Error_Direccion').remove();
    $('.SpanDireccion').removeClass('glyphicon glyphicon-remove ');
    $('.SpanDireccion').addClass('glyphicon glyphicon-ok ');
  });


  $('#txt_Apellido').keypress(function(e) {
    $('#Apellido-group').removeClass('has-error');
    $('#Apellido-group').addClass('has-success');
    $('.Error_apellido').remove();
    $('.SpanApellido').removeClass('glyphicon glyphicon-remove ');
    $('.SpanApellido').addClass('glyphicon glyphicon-ok ');
  });

  $('#txt_Email').keypress(function(e) {
    $('#Email-group').removeClass('has-error');
    $('#Email-group').addClass('has-success');
    $('.Error_Email').remove();
    $('.SpanEmail').removeClass('glyphicon glyphicon-remove ');
    $('.SpanEmail').addClass('glyphicon glyphicon-ok ');
  });

  $('#txt_Telefono').keypress(function(e) {
    $('#Telefono-group').removeClass('has-error');
    $('#Telefono-group').addClass('has-success');
    $('.Error_Telefono').remove();
    $('.SpanTele').removeClass('glyphicon glyphicon-remove ');
    $('.SpanTele').addClass('glyphicon glyphicon-ok ');
  });



  $('.txt_cliente').keypress(function(e) {
    $('#Nombre-group1').removeClass('has-error');
    $('#Nombre-group1').addClass('has-success');
    $('.Error_Nombre').remove();
    $('.SpanName').removeClass('glyphicon glyphicon-remove ');
    $('.SpanName').addClass('glyphicon glyphicon-ok ');
  });


  $('.txt_Direccion').keypress(function(e) {
    $('#Direccion-group1').removeClass('has-error');
    $('#Direccion-group1').addClass('has-success');
    $('.Error_Direccion').remove();
    $('.SpanDireccion').removeClass('glyphicon glyphicon-remove ');
    $('.SpanDireccion').addClass('glyphicon glyphicon-ok ');
  });


  $('.txt_Apellido').keypress(function(e) {
    $('#Apellido-group1').removeClass('has-error');
    $('#Apellido-group1').addClass('has-success');
    $('.Error_apellido').remove();
    $('.SpanApellido').removeClass('glyphicon glyphicon-remove ');
    $('.SpanApellido').addClass('glyphicon glyphicon-ok ');
  });

  $('.txt_Email').keypress(function(e) {
    $('#Email-group1').removeClass('has-error');
    $('#Email-group1').addClass('has-success');
    $('.Error_Email').remove();
    $('.SpanEmail').removeClass('glyphicon glyphicon-remove ');
    $('.SpanEmail').addClass('glyphicon glyphicon-ok ');
  });

  $('.txt_Telefono').keypress(function(e) {
    $('#Telefono-group1').removeClass('has-error');
    $('#Telefono-group1').addClass('has-success');
    $('.Error_Telefono').remove();
    $('.SpanTele').removeClass('glyphicon glyphicon-remove ');
    $('.SpanTele').addClass('glyphicon glyphicon-ok ');
  });



  $('#AddCliente').click(function(e) {
    $('.form-group').removeClass('has-error'); // remove the error class
    $('.help-block').remove();
    ('#iconForm').removeClass('glyphicon glyphicon-remove ');
    ('#iconForm').removeClass('glyphicon glyphicon-ok');

    $(function() {
      $(this)

        .find("input,textarea,select")
        .val('')
        .end()

    });

  });

  $('#editarClienteForm').click(function(e) {
    $('.form-group').removeClass('has-error'); // remove the error class
    $('.help-block').remove();
  });



  $('.add').click(function(e) {

    var DepartamentoFull = $('#Departamento').val();
    var separador = ",";
    var departamentoid = '';
    var departamento = '';
    if (DepartamentoFull != null) {
      var DepartamentoArray = DepartamentoFull.split(separador);
      departamentoid = DepartamentoArray[0];
      departamento = DepartamentoArray[1];


    }



    var formData = {
      'Nombre': $.trim($('#txt_cliente').val()),
      'Apellido': $.trim($('#txt_Apellido').val()),
      'Direccion': $.trim($('#txt_Direccion').val()),
      'Email': $.trim($('#txt_Email').val()),
      'Telefono': $.trim($('#txt_Telefono').val()),
      'TipoCliente': $('#TipoCliente').val(),
      'DepartamentoId': departamentoid,
      'Departamento': departamento,
      'add': 'enviar'
    };
    console.log(formData);
    event.preventDefault();

    $.ajax({
        url: "../Controlador/ClienteControlador.php",
        type: "POST",
        data: formData,
        dataType: 'json',
        encode: true,

        beforeSend: function(objeto) {
          $(".UserNoDisponible").addClass('loader');
        }
      })
      .done(function(html) {
        if (!html.success) {


          if (html.errors.nombre) {
            $('#Nombre-group').addClass('has-error');
            $('.SpanName').addClass('glyphicon glyphicon-remove');
            $('.Error_Nombre').html('<div class="help-block">' + html.errors.nombre + '</div>');
          }

          if (html.errors.Direccion) {
            $('#Direccion-group').addClass('has-error');
            $('.SpanDireccion').addClass('glyphicon glyphicon-remove ');
            $('.Error_Direccion').html('<div class="help-block">' + html.errors.Direccion + '</div>');
          }

          if (html.errors.Email) {
            $('#Email-group').addClass('has-error');
            $('.SpanEmail').addClass('glyphicon glyphicon-remove ');
            $('.Error_Email').html('<div class="help-block">' + html.errors.Email + '</div> ');
          }


          if (html.errors.Apellido) {
            $('#Apellido-group').addClass('has-error');
            $('.SpanApellido').addClass('glyphicon glyphicon-remove ');
            $('.Error_apellido').html('<div class="help-block">' + html.errors.Apellido + '</div>');
          }

          if (html.errors.Telefono) {
            $('#Telefono-group').addClass('has-error');
            $('.SpanTele').addClass('glyphicon glyphicon-remove ');
            $('.Error_Telefono').html('<div class="help-block">' + html.errors.Telefono + '</div>');
          }
          if (html.errors.TipoCliente) {
            $('#TipoCliente').addClass('has-error');
            $('.SpanTipo').addClass('glyphicon glyphicon-remove ');
            $('.Error_TipoCliente').html('<div class="help-block">' + html.errors.TipoCliente + '</div>');
          }

          if (html.errors.Departamento) {
            $('#Departamento').addClass('has-error');
            $('.SpanDepa').addClass('glyphicon glyphicon-remove ');
            $('.Error_Departamento').html('<div class="help-block">' + html.errors.Departamento + '</div>');
          }

        } else {

          $('.form-group').removeClass('has-error');
          $('.help-block').remove();
          $('#iconForm').removeClass('glyphicon glyphicon-remove ');
          swal("Cliente Guardado!");
          $(function() {
            $(this)

              .find("input,textarea,select")
              .val('')
              .end()
            $('#addEmployeeModal').modal('toggle');
          });

          load(1);

        }
      })

  });


  $('#editarClienteForm').click(function(e) {
    var formDataEdit = {
      'Id': $.trim($('input:text[name=IdCliente]').val()),
      'nombre': $.trim($('input:text[name=EdiNombre]').val()),
      'apellido': $.trim($('input:text[name=EdiApellido]').val()),
      'direccion': $.trim($('input:text[name=EdiDireccion]').val()),
      'email': $.trim($('input[name=EdiEmail]').val()),
      'Telefono': $.trim($('input[name=EdiTelefono]').val()),

      'Edit': 'Editar'
    };


    event.preventDefault();

    $.ajax({
        url: "../Controlador/ClienteControlador.php",
        type: "POST",
        data: formDataEdit,
        dataType: 'json',
        encode: true,


      })

      .done(function(Datos) {

        console.log(Datos);
        if (!Datos.success) {


          if (Datos.errors.nombre) {
            $('#Nombre-group1').addClass('has-error');
            $('.SpanName').addClass('glyphicon glyphicon-remove');
            $('.Error_Nombre').html('<div class="help-block">' + Datos.errors.nombre + '</div>');
          }

          if (Datos.errors.Direccion) {
            $('#Direccion-group1').addClass('has-error');
            $('.SpanDireccion').addClass('glyphicon glyphicon-remove ');
            $('.Error_Direccion').html('<div class="help-block">' + Datos.errors.Direccion + '</div>');
          }

          if (Datos.errors.Email) {
            $('#Email-group1').addClass('has-error');
            $('.SpanEmail').addClass('glyphicon glyphicon-remove ');
            $('.Error_Email').html('<div class="help-block">' + Datos.errors.Email + '</div> ');
          }


          if (Datos.errors.Apellido) {
            $('#Apellido-group1').addClass('has-error');
            $('.SpanApellido').addClass('glyphicon glyphicon-remove ');
            $('.Error_apellido').html('<div class="help-block">' + Datos.errors.Apellido + '</div>');
          }

          if (Datos.errors.Telefono) {
            $('#Telefono-group1').addClass('has-error');
            $('.SpanTele').addClass('glyphicon glyphicon-remove ');
            $('.Error_Telefono').html('<div class="help-block">' + Datos.errors.Telefono + '</div>');
          }

        } else {

          $('.form-group').removeClass('has-error');
          $('.help-block').remove();
          $('#iconForm').removeClass('glyphicon glyphicon-remove ');

          $(function() {
            $(this)

              .find("input,textarea,select")
              .val('')
              .end()
            $('#editEmployeeModal').modal('toggle');
          });

          load(1);

        }

      })





  });

});