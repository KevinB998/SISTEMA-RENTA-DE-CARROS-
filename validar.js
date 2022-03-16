function validar() {

    var nombre, apellido, cedula, usuario, email, telefono, direccion, clave;
    
    nombre = document.getElementById("nombres").value;
    apellido = document.getElementById("apellidos").value;
    cedula = document.getElementById("cedula").value;
    usuario = document.getElementById("usuario").value;
    email = document.getElementById("email").value;
    telefono = document.getElementById("telefono").value;
    direccion = document.getElementById("direccion").value;
    clave = document.getElementById("clave").value;

    var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (nombre === "" || apellido === "" || cedula === "" || usuario === "" || email === "" || telefono === "" || direccion === "" || clave === "") {
        alert("Todos los campos con obligatorios");
        return false;
    }

    else if(cedula.length!=10){
        alert("La cédula requiere 10 digitos");
        return false;
    }

    else if(telefono.length!=10){
        alert("El teléfono requiere 10 digitos");
        return false;
    }

    else if(!regex.test(email)){
        alert("Formato del correo inválido");
        return false;
    }

    else {
        return true;
    }

}

function validarAct() {

    var nombre, apellido, cedula, usuario, email, telefono, direccion;
    
    nombre = document.getElementById("nombres").value;
    apellido = document.getElementById("apellidos").value;
    cedula = document.getElementById("cedula").value;
    usuario = document.getElementById("usuario").value;
    email = document.getElementById("email").value;
    telefono = document.getElementById("telefono").value;
    direccion = document.getElementById("direccion").value;

    var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (nombre === "" || apellido === "" || cedula === "" || usuario === "" || email === "" || telefono === "" || direccion === "") {
        alert("Todos los campos con obligatorios");
        return false;
    }

    else if(cedula.length!=10){
        alert("La cédula requiere 10 digitos");
        return false;
    }

    else if(telefono.length!=10){
        alert("El teléfono requiere 10 digitos");
        return false;
    }

    else if(!regex.test(email)){
        alert("Formato del correo inválido");
        return false;
    }

    else {
        return true;
    }

}

function SoloNumeros(evt) {
    if (window.event) {
        keynum = evt.keyCode;
    } else {
        keynum = evt.which;
    }
    if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 46)
    {
        return true;
    } else {
        alert("Ingresar solo números");
        return false;
    }
}

function validarDecimales(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filtrar(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filtrar(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filtrar(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

function SoloLetras(e) {
    key = e.keyCOde || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = "ABCDEFGHIJKLMNÑOPQRSTUVWWXYZabcdefghijklmnñopqrstáéíóúA B C D E F G H I J K L M N Ñ O P Q R S T U V W X Y Za b c d e f g h i j k l m n ñ o p q r s t u v w x y z";

    especiales = [8, 13];
    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;

        }
    }
    if (letras.indexOf(tecla) == -1 && !tecla_especial)
    {
        alert("Ingresar solo letras");
        return false;
    }
}
function fechaN(evt) {
    var numero = parseInt(elemento.value, 10);
    if (numero < 4 || numero > 20) {
        alert('Solo se permite  en el rango: 1 - 31');
        elemento.focus();
        return false;
    }
    return true;
}

function verificarCampos() {

    var aerolinea = document.getElementsById("marca").value;
    var asientos = document.getElementById("cant").value;
    var horario = document.getElementById("horario").value;
    var dias = document.getElementById("dias").value;
    var precio = document.getElementById("precio").value;

    if(marca == "" || asientos == "" || horario == "" || dias == "" || precio == ""){
        alert("Llene todo los campos");
        return false;
    }

    else{
        return true;
    }

}

function verificarConsultaAerolinea() {

    var marca = document.getElementsById("marca").value;

    if(aerolinea == ""){
        alert("Seleccione una marca");
        return false;
    }

    else{
        return true;
    }

}

function verificarConsultaCedula() {

    var cedula = document.getElementsById("cedula").value;

    if(cedula == ""){
        alert("Ingrese una cédula");
        return false;
    }

    else{
        return true;
    }

}

function unoPorVez() {
    var checkUno = document.getElementById("op_1");
    var checkDos = document.getElementById("op_2");
    var checkTres = document.getElementById("op_3");
    var checkCuatro = document.getElementById("op_4");
    checkUno.onclick = function () {
        if (checkUno.checked != false) {
            checkDos.checked = null;
            checkTres.checked = null;
            checkCuatro.checked = null;
        }
    }
    checkDos.onclick = function () {
        if (checkDos.checked != false) {
            checkUno.checked = null;
            checkTres.checked = null;
            checkCuatro.checked = null;
        }
    }
    checkTres.onclick = function () {
        if (checkTres.checked != false) {
            checkUno.checked = null;
            checkDos.checked = null;
            checkCuatro.checked = null;
        }
    }
    checkCuatro.onclick = function () {
        if (checkCuatro.checked != false) {
            checkUno.checked = null;
            checkDos.checked = null;
            checkTres.checked = null;
        }
    }
}

function devolverMarca(id) {
    if (id == 'Tame') {
        $('#op_1').prop('checked');
    } else if (id == 'Lam') {
        $('#op_2').prop('checked');
    } else if (id == 'Latam') {
        $('#op_3').prop('checked');
    } else if (id == 'Avianca') {
        $('#op_4').prop('checked');
    }
}

function calcularImpuesto(){

    var categoria = document.actualizar.categoria.value;
    var precio = document.actualizar.precio.value;
    var impuesto;

    if(categoria == "Economica"){
        impuesto = precio * 0.05;
    }

    else if(categoria == "Media"){
        impuesto = precio * 0.1;
    }

    else{
        impuesto = precio * 0.15;
    }

    document.actualizar.impuesto.value = impuesto.toFixed(2);

}

function validarCredenciales(){

    var usuario = document.getElementById("usuario").value;
    var clave = document.getElementById("clave").value;

    if(usuario == "" || clave == ""){
        alert("Ingrese el usuario y la contraseña");
        return false;
    }

    else {
        return true;
    }

}

function validarReserva(){

    var id_vuelo = document.getElementById("id_vuelo").value;
    var cedula = document.getElementById("cedula").value;
    var asientos = document.getElementById("asientos").value;
    var fecha_vuelo = document.getElementById("fecha_entrega").value;

    if(id_vuelo == "" || cedula == "" || asientos == "" || fecha_entrega == ""){
        alert("Llene todos los campos");
        return false;
    }

    else{
        return true;
    }

}

function validarReservaCliente(){

    var id_vehiculo = document.getElementById("id_vehiculo").value;
    var asientos = document.getElementById("asientos").value;
    var fecha_entrega = document.getElementById("fecha_entrega").value;

    if(id_vehiculo == "" || asientos == "" || fecha_entrega == ""){
        alert("Llene todos los campos");
        return false;
    }

    else{
        return true;
    }

}

function verificarFechas(){

    var fecha_inicio = document.getElementById("fecha_inicio").value;
    var fecha_fin = document.getElementById("fecha_fin").value;

    if(fecha_inicio == "" || fecha_fin == ""){
        alert("Seleccione ambas fechas");
        return false;
    }

    else if(fecha_inicio > fecha_fin){
        alert("La fecha de inicio no puede ser mayor a la fecha final");
        return false;
    }

    else if(fecha_inicio < fecha_fin){
        return true;
    }

}

function verificarPrecios(){

    var precio_minimo = document.getElementById("precio_minimo").value;
    var precio_maximo = document.getElementById("precio_maximo").value;

    if(precio_minimo == "" || precio_maximo == ""){
        alert("Ingrese ambos precios");
        return false;
    }

    else if(precio_minimo > precio_maximo){
        alert("El precio minimo no puede ser mayor al precio maximo");
        return false;
    }

    else if(precio_minimo < precio_maximo){
        return true;
    }

}

function validarRecuperacion(){

    var cedula, usuario, email, telefono, clavenueva, reclavenueva;
    
    cedula = document.getElementById("cedula").value;
    usuario = document.getElementById("usuario").value;
    email = document.getElementById("email").value;
    telefono = document.getElementById("telefono").value;
    clavenueva = document.getElementById("clavenueva").value;
    reclavenueva = document.getElementById("reclavenueva").value;

    var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (cedula === "" || usuario === "" || email === "" || telefono === "" || clavenueva === "" || reclavenueva === "") {
        alert("Todos los campos con obligatorios");
        return false;
    }

    else if(cedula.length!=10){
        alert("La cédula requiere 10 digitos");
        return false;
    }

    else if(telefono.length!=10){
        alert("El teléfono requiere 10 digitos");
        return false;
    }

    else if(!regex.test(email)){
        alert("Formato del correo inválido");
        return false;
    }

    else if(reclavenueva != clavenueva){
        alert("Las claves deben coincidir");
        return false;
    }

    else {
        return true;
    }

}