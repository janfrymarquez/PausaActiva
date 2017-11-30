function verificar_Password() {
    if ((myform.Password.value).length < 3) {
        $("#BotonGuardar").attr("disabled", true);
        $("#FormPassword").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> La contraseña no cumple con los requisito de longitud  </div>'
    } else {
        $("#Password").attr("required", false);
        $("#BotonGuardar").attr("disabled", false);
        $("#FormPassword").removeClass("has-error");
        $("#FormPassword").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_confirmPassword() {
    if (myform.ConfirPassword.value == "") {
        $("#BotonGuardar").attr("disabled", true);
        $("#FormConfirmPassword").removeClass("has-success");
        $("#FormConfirmPassword").addClass("has-error");
    }
    if (myform.ConfirPassword.value != myform.Password.value) {
        $("#BotonGuardar").attr("disabled", true);
        $("#FormConfirmPassword").addClass("has-error");
        $("#FormPassword").removeClass("has-success");
        $("#FormPassword").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> Las contraseñas no coinciden  </div>'
    } else {
        $("#Password").attr("required", false);
        $("#BotonGuardar").attr("disabled", false);
        $("#FormConfirmPassword").removeClass("has-error");
        $("#FormConfirmPassword").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_Nombre() {
    if (myform.Nombre.value == "") {
        $("#BotonGuardar").attr("disabled", true);
        $("#FormNombre").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El nombre no puede estar en blanco   </div>'
    } else {
        $("#FormNombre").removeClass("has-error");
        $("#FormNombre").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_Apellido() {
    if (myform.Nombre.value == "") {
        $("#BotonGuardar").attr("disabled", true);
        $("#FormApellido").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El Apellido no puede estar en blanco   </div>'
    } else {
        $("#FormApellido").removeClass("has-error");
        $("#FormApellido").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_Email() {
    if (myform.Nombre.value == "") {
        $("#BotonGuardar").attr("disabled", true);
        $("#Email").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El correo no puede estar en blanco   </div>'
    } else {
        $("#Email").removeClass("has-error");
        $("#Email").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}