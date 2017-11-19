

function verificar() {
    if (myform.Password.value == "") {
        alert("Digite una contraseña.");
        myform.Password.focus();
        return false;
    }
    if ((myform.Password.value).length < 3) {
        alert("El Password no puede ser menor a 8 caracteres.");
        myform.Password.focus();
        return false;
    }
    if (myform.ConfirPassword.value == "") {
        alert("Confime la contraseña.");
        return false;
    }
    if (myform.ConfirPassword.value != myform.Password.value) {
        alert("Entre una contraseña deben de coincidir.");
        return false;
    }
    return true;
}