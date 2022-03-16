
function validar() {
    //declarar valores 
    var cedula, nombres, apellidos, direccion, email, usuario, clave, telefono, img;
    cedula = document.getElementById("cedula").value;
    nombres = document.getElementById("nombres").value;
    apellidos = document.getElementById("apellidos").value;
    direccion = document.getElementById("direccion").value;
    email = document.getElementById("email").value;
    usuario = document.getElementById("usuario").value;
    clave = document.getElementById("clave").value;
    telefono = document.getElementById("telefono").value;
    img = document.getElementById("imagen").value;
    
    
    const parrafo = document.getElementById("warnings");
    let warnings = "";
    //validar por expresiones regulares
    let regexText = /^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;
    let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;   
    let regexUsuario = /^[a-zA-Z0-9\_\-]{2,16}$/;
    let regexClave = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&:)])([A-Za-z\d$@$!%*?&:)]|[^ ]){8,15}$/;
    
    entrar = true;


    //Validar que no existan campos vacios
    if (cedula === "" || nombres === "" || apellidos === "" || direccion === "" || email === "" || usuario === "" || clave === "" || img.length===0) {
        
        warnings += `*Todos los campos son obligatorios <br>`;
        entrar = false;
    } //Validar campo Cedula
    else if (cedula.length !== 10 || isNaN(cedula)) {
        
        warnings += `*Cédula no valida introdusca 10 números <br>`;
        entrar = false;
    } 
   
    //Validar campo Nombres
    else if (!regexText.test(nombres) || nombres.length > 50) {
        warnings += `El nombre no es valido evita:<br> Números <br> Caracteres especiales <br>Ingresa con letra capital <br>`;
        entrar = false;
    } else if (!regexText.test(apellidos) || apellidos.length > 50) {
        warnings += `El apellido no es valido evita:<br> Números <br> Caracteres especiales <br>Ingresa con letra capital <br>`;
        entrar = false;
    } else if (!regexText.test(direccion) || direccion.length > 50) {
        warnings += `La direccion no es valida evita:<br>Espacios al inicio<br> Números <br> Caracteres especiales <br>Ingresa con letra capital <br>`;
        entrar = false;
    }
    //Validar campo telefono   
    else if (telefono.length !== 10 || isNaN(telefono)) {
        warnings += `*Teléfono no valido introdusca 10 números <br>`;
        entrar = false;
    }
    //Validar campo email   
    else if (!regexEmail.test(email) || email.length > 30) {
        warnings += `*Email no valido introdusca ejemplo@gmail.com <br>`;
        entrar = false;
    }
    //Validar campo usuario   
    else if (!regexUsuario.test(usuario) || usuario.length > 10) {
        warnings += `*Usuario no valido ingrese solo 10 dígitos entre : números, letras y guiones <br>`;
        entrar = false;
    }
    //Validar campo clave
    else if (!regexClave.test(clave)) {
        warnings += `Contraseña no valida evita espacios introdusca entre 8 y 15 caracteres incluye: <br>Mayúscula y minúscula<br>Número<br>Caracter especial:$@$!%*?&:)`;
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

