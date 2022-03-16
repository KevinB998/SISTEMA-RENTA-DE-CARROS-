
function validar() {
    //declarar valores 
    var persona, vehiculo, can_asientos, fecha_reserva, fecha_entrega;
    persona = document.getElementById("persona").value;
    vehiculo = document.getElementById("vehiculo").value;
    can_asientos = document.getElementById("can_asientos").value;
    fecha_reserva = document.getElementById("fecha_reserva").value;
    fecha_entrega = document.getElementById("fecha_entrega").value;
   
    
    const parrafo = document.getElementById("warnings");
    let warnings = "";
    
    entrar = true;
    //Validar que no existan campos vacios
    if (persona === "" || vehiculo === "" || can_asientos === "" || fecha_reserva === "" || fecha_entrega === "" ) {
        warnings += `*Todos los campos son obligatorios <br>`;
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
