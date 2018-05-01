$(document).ready(function() {
  event.preventDefault();

  $('#button').click(function(e) {

    var FormLoginData = {
      'Usuario': $.trim($('#Usuario').val()),
      'Password': $.trim($('#Password').val()),
      'token': $.trim($('#token').val())

    }


    console.log(FormLoginData);
    $.ajax({
        url: "../Controlador/UsuarioControlador.php",
        type: "POST",
        data: FormLoginData,
        dataType: 'json',
        encode: true,


      })

      .done(function(Datos) {

        console.log(Datos);

        if (!Datos.success) {
          $('#login-detail').removeClass('hidden');
          $(function() {
            $(this)

            $('#Usuario').val('');
            $('#Password').val('');


          });

        } else {
          $('#login-detail').addClass('hidden');

          window.location.href = Datos.url;


        }
      });
  });

});