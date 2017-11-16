function getXMLHttpRequest() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function TraerPagina(datos, contenedor) {
    divResultado = document.getElementById(contenedor);
    ajax = getXMLHttpRequest();
    ajax.open("GET", datos);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 1) {
            divLoader.innerHTML = '<br/><br/><br/><center><img widht="50" height="50" src="./bigrotation2.gif"/><br/>Cargando...</center>'
        } else {
            if (ajax.readyState == 4) {
                divResultado.innerHTML = ajax.responseText;
                divLoader.innerHTML = ''
            }
        }
    }
    ajax.send(null)
}

function ComprobarUsuario(datos, contenedor) {
    divResultado = document.getElementById(contenedor);
    username_ = document.myform.txt_username.value;
    ajax = getXMLHttpRequest();
    ajax.open("POST", datos);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 1) {
            divResultado.innerHTML = '<br/><br/><br/><center><img widht="50" height="50" src="../img/bigrotation2.gif"/><br/>Cargando...</center>'
        } else {
            if (ajax.readyState == 4) {
                divResultado.innerHTML = ajax.responseText;
            }
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //enviando los valores
    ajax.send("username=" + username_);
}

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