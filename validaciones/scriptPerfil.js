//
function validar(){
    //var variable gobal
    var id_perfil,nombre,descripcion;
    id_perfil = document.getElementById("id_perfil").value;
    nombre = document.getElementById("nombre").value;
    descripcion = document.getElementById("descripcion").value;
    //variable solo de lectura, puntero a memoria 
    const parrafo = document.getElementById("warnings");
    //variable de alcance limitado 
    let warnings = "";
    let regexText = /^([A-ZÁÉÍÓÚa-zñáéíóú]+[\s]*)+$/;
    entrar = true;
    //controlar que los campos no esten vacios 
    if( nombre === "" || descripcion === ""){
        warnings += `*Todos los campos son obligatorios <br>`;
        entrar = false;
    }
    //control del tamaño y tipo de caracteres
    else if(!regexText.test(nombre) || nombre.length > 20){
        warnings += `*Nombre Ingrese solo letras menores a 20 caracteres  <br>`;
        entrar = false;
    }
    else if (!regexText.test(descripcion) || descripcion.length > 50){
        warnings += `*Descripción Ingrese solo letras menores a 50 caracteres <br>`;
        entrar = false;
    }
    
    if(entrar ){
        parrafo.innerHTML = "Enviado";
        return entrar;
    }else{
        parrafo.innerHTML = warnings;
        return entrar;
    }
    
}