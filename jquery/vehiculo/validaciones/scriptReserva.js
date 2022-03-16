
function validar() {
    //declarar valores 
    var persona, vuelo, can_asientos, fecha_reserva, fecha_vuelo;
    persona = document.getElementById("persona").value;
    vuelo = document.getElementById("vuelo").value;
    can_asientos = document.getElementById("can_asientos").value;
    fecha_reserva = document.getElementById("fecha_reserva").value;
    fecha_vuelo = document.getElementById("fecha_vuelo").value;
   
    
    const parrafo = document.getElementById("warnings");
    let warnings = "";
    
    entrar = true;
    //Validar que no existan campos vacios
    if (persona === "" || vuelo === "" || can_asientos === "" || fecha_reserva === "" || fecha_vuelo === "" ) {
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
