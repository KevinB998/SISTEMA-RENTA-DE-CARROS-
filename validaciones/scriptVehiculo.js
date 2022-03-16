function validar() {
    var marca, can_disponible, horarios, dias, precio;
    marca = document.getElementById("marca").value;
    can_disponible = document.getElementById("can_disponible").value;
    horarios = document.getElementById("horarios").value;
    dias = document.getElementById("dias").value;
    precio = document.getElementById("precio").value;

    const parrafo = document.getElementById("warnings");
    let warnings = "";
    let regexText = /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;
    entrar = true;

    if (marca === "" || can_disponible === "" || horarios === "" || dias === "" || precio === "") {
        warnings += `*Todos los campos son obligatorios`;
        entrar = false;
    }
    else if (!regexText.test(dias) || dias.length > 20){
        warnings += `*Ingresa solo letras:<br>Con letra capital<br>Evita caracteres especiales`;
        entrar = false;
    }else if (precio.length > 18){
        warnings += `*Máximo de dígitos permitidos 18`;
        entrar = false;
    }
    
    if (entrar) {
        parrafo.innerHTML = "Enviado";
        return entrar;
    } else {
         parrafo.innerHTML = warnings;
        return entrar;
    }
}