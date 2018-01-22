function verificar_Password() {
    if ((myform.Password.value).length < 3) {
        $("#FormPassword").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> La contraseña no cumple con los requisito de longitud  </div>'
        return false;
    } else {
        $("#Password").attr("required", false);
        $("#FormPassword").removeClass("has-error");
        $("#FormPassword").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_confirmPassword() {
    if (myform.ConfirPassword.value == "") {
        $("#FormConfirmPassword").removeClass("has-success");
        $("#FormConfirmPassword").addClass("has-error");
        return false;
    }
    if (myform.ConfirPassword.value != myform.Password.value) {
        $("#FormConfirmPassword").addClass("has-error");
        $("#FormPassword").removeClass("has-success");
        $("#FormPassword").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> Las contraseñas no coinciden  </div>'
        return false;
    } else {
        $("#Password").attr("required", false);
        $("#FormConfirmPassword").removeClass("has-error");
        $("#FormConfirmPassword").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_Nombre() {
    if (myform.Nombre.value == "") {
        $("#FormNombre").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El nombre no puede estar en blanco   </div>'
        return false;
    } else {
        $("#FormNombre").removeClass("has-error");
        $("#FormNombre").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_Apellido() {
    if (myform.Nombre.value == "") {
        $("#FormApellido").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El Apellido no puede estar en blanco   </div>'
        return false;
    } else {
        $("#FormApellido").removeClass("has-error");
        $("#FormApellido").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function Verificar_Email() {
    if (myform.Email.value == "") {
        $("#Email").addClass("has-error");
        document.getElementById("UserNoDisponible").innerHTML = ' <div align="center" id="NoExiste" class="fa fa-warning alert alert-danger col-lg-12 "> El correo no puede estar en blanco   </div>'
        return false;
    } else {
        $("#Email").removeClass("has-error");
        $("#Email").addClass("has-success");
        document.getElementById("UserNoDisponible").innerHTML = '';
    }
}

function ComprobaNombreEncuesta() {
    if (formEncuesta.NombreEncuesta.value == "") {
        $("#NombreEncuesta").removeClass("has-success");
        $("#NombreEncuesta").addClass("has-error");
        return false;
    } else {
        $("#NombreEncuesta").attr("required", false);
        $("#NombreEncuesta").removeClass("has-error");
        $("#NombreEncuesta").addClass("has-success");
    }
}