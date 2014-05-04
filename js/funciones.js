//Funcion que nos cargar el mes siguiente al que estamos viendo.
function mesSiguiente(){
    $.post("php/funciones.php",{elegido:"messig"},function(respuesta){
        document.getElementById('year').innerHTML=respuesta;
        }
    );
}
//Funcion que nos carga el mes anterior al que estamos viendo
function mesAnterior(){
    $.post("php/funciones.php",{elegido:"mesant"},function(respuesta){
        document.getElementById('year').innerHTML=respuesta;
        }
    );
}
/*Funcion que nos recoge el color que hemos clickado de la paleta de colores.
Cambia los estilos del div para indicarnos visualmente que el color ha sido seleccionado*/
function getColor(inputid,idcolor){
    document.getElementById(inputid).value = idcolor;
    var elements = document.getElementsByClassName('colores');
    for(var i = 0; i < elements.length; i++) {
        elements[i].style.border = "1px solid gray";
        elements[i].style.width = "20px";
        elements[i].style.height = "20px";
    }
    document.getElementById(idcolor).style.border = "2px solid black";
    document.getElementById(idcolor).style.width = "18px";
    document.getElementById(idcolor).style.height = "18px";
}
//Funcion parecida a la anterior, solo que en este caso es para las etiquetas que ya tenemos creadas.
function getColorEtiquetaCreada(inputid,idcolor){
    document.getElementById(inputid).value = idcolor;
    var elements = document.getElementsByClassName('colores-etiquetas-creadas');
    for(var i = 0; i < elements.length; i++) {
        elements[i].style.border = "1px solid gray";
    }
    document.getElementById(idcolor).style.border = "2px solid black";
}
//Funcion que nos muestra los datos del evento que hemos seleccionado.
function consultarEventos(dia,mes,year,horai,horaf,usuario,titulo){
    $.post("php/funciones.php",{elegido:"evento",
        F_dia:dia,
        F_mes:mes,
        F_year:year,
        F_horai:horai,
        F_horaf:horaf,
        E_usuario:usuario,
        E_titulo:titulo},
        function(respuesta){
        document.getElementById('event').innerHTML=respuesta;
        }
    );
}
/*Funcion que nos recoge los datos del evento que queremos modificar y 
nos los evia en forma de formulario a la pagina donde editaremos el evento*/
function editarEventhoy(dia,mes,year,horai,horaf,fechai,fechaf,usuario,titulo){
    var form = $('<form action="editarevento.php" method="post">' +
    '<input type="hidden" name="dia" value="'+dia+'" />' +
    '<input type="hidden" name="mes" value="'+mes+'" />' +
    '<input type="hidden" name="year" value="'+year+'" />' +
    '<input type="hidden" name="horai" value="'+horai+'" />' +
    '<input type="hidden" name="horaf" value="'+horaf+'" />' +
    '<input type="hidden" name="fechai" value="'+fechai+'" />' +
    '<input type="hidden" name="fechaf" value="'+fechaf+'" />' +
    '<input type="hidden" name="usuario" value="'+usuario+'" />' +
    '<input type="hidden" name="titulo" value="'+titulo+'" />' +
    '</form>');
    $('body').append(form);
    $(form).submit();
}

/*Funcion que nos recoge los datos de los eventos del dia que queremos ver y 
nos los evia en forma de formulario a la pagina donde veremos la linea de tiempo diaria*/
function consultarListaEventos(dia,mes,year,usuario,calendario){
    var form = $('<form action="dia.php" method="post">' +
    '<input type="hidden" name="dia" value="'+dia+'" />' +
    '<input type="hidden" name="mes" value="'+mes+'" />' +
    '<input type="hidden" name="year" value="'+year+'" />' +
    '<input type="hidden" name="usuario" value="'+usuario+'" />' +
    '<input type="hidden" name="calendario" value="'+calendario+'" />' +
    '</form>');
    $('body').append(form);
    $(form).submit();
}

//Funcion para borrar un calendario creado por el usuario
function borrarCal(usuario,nombrecal){
    $.post("php/funciones.php",{
        elegido:"borrarcal",
        E_usuario:usuario,
        E_nombrecal:nombrecal},
        function(respuesta){
            alert(respuesta)
            location.reload();
        }
    );
}

//Funcion para borrar un calendario creado por el usuario
function changecal(nombrecal){
    $.post("php/funciones.php",{
        elegido:"tempcal",
        E_nombrecal:nombrecal},
        function(respuesta){
            location.reload();
        }
    );
}

//Funcion para borrar un evento creado por el usuario
function borrarEvent(dia,mes,year,horai,horaf,fechai,fechaf,usuario,titulo,tipo){
    $.post("php/funciones.php",{
        elegido:"borrarevento",
        F_dia:dia,
        F_mes:mes,
        F_year:year,
        F_horai:horai,
        F_horaf:horaf,
        F_fechai:fechai,
        F_fechaf:fechaf,
        E_usuario:usuario,
        E_titulo:titulo,
        E_tipodel:tipo},
        function(respuesta){
            alert(respuesta)
            window.location="calendario.php";
        }
    );
}
//Funcion para borar una etiqueta creada por el usuario
function borrarEtiqueta(usuario,etiqueta,color){
    $.post("php/funciones.php",{
        elegido:"borraretiqueta",
        E_usuario:usuario,
        E_etiqueta:etiqueta,
        E_color:color},
        function(respuesta){
            alert(respuesta)
            location.reload();
        }
    );
}



//Funcion para cambiarle el estilo a un campo de texto que no cumple con los requesitos de envio
var framework = {
    objframework :{
        imagenInputText : function(textclass,textclassicon){
            var text = document.getElementById(textclass).value;
            if(text == ""){
                document.getElementById(textclassicon).style.background = "url(img/texta.png)";
                document.getElementById(textclassicon).style.width = "20px";
                document.getElementById(textclassicon).style.height = "20px";
                document.getElementById(textclassicon).style.position = "absolute";
                document.getElementById(textclassicon).style.display = "inline";
                document.getElementById(textclassicon).style.margin = "20px 0px 0px 346px";
                document.getElementById(textclassicon).style.transition = "all 0.3s ease-in 0s";
            }else if(text != ""){
                document.getElementById(textclassicon).style.background = "url(img/textb.png)";
                document.getElementById(textclassicon).style.width = "20px";
                document.getElementById(textclassicon).style.height = "20px";
                document.getElementById(textclassicon).style.position = "absolute";
                document.getElementById(textclassicon).style.display = "inline";
                document.getElementById(textclassicon).style.margin = "20px 0px 0px 346px";
                document.getElementById(textclassicon).style.transition = "all 0.3s ease-in 0s";
            }
        },

        colorInputText:function(textclass){
            var texto = document.getElementById(textclass).value
            if(texto == ""){
                document.getElementById(textclass).value = "";
                document.getElementById(textclass).style.color = "#000";
            }else if(texto != ""){
                document.getElementById(textclass).style.color = "#000";
            }
        },

        colorTextoCheckbox:function(labelcheckbox){
            if(checked){
                document.getElementById(labelcheckbox).style.color = "#2ecc71";
            }else{
                document.getElementById(labelcheckbox).style.color = "#000";
            }
        },

        cambiarColorLabelRadio:function(valor){
            var radio = document.getElementById(valor);
            if(radio.checked){
                radio.style.color="red";
            }else{
                var radioclass = document.getElementsByClassName('radio-class-label');
                for(var x=0;x<radioclass.length;x++){
                    radioclass[x].style.color="black";
                }
                radio.style.color="red";
            }
        }
    }
};
//Funciones para verificar que el formulario de registro este rellenado correctamente.
var formularioDeRegistro = {
    objRegistro : {
        //Variables que recogen datos del form de registro
        formulario : document.getElementById('formulario'),
        nombre : document.getElementById('inombre'),
        imagennombre : document.getElementById('nombre'),
        email : document.getElementById('iemail'),
        imagenemail : document.getElementById('email'),
        usuario : document.getElementById('iuser'),
        imagenusuario : document.getElementById('user'),
        contrasena : document.getElementById('ipassword'),
        imagencontrasena : document.getElementById('password'),
        // Variables para expresiones regulares
        patronNombre : /^[A-Za-zñÑ-áéíóúÁÉÍÓÚ]+([A-Za-zñÑ-áéíóúÁÉÍÓÚ] ?)*[A-Za-zñÑ-áéíóúÁÉÍÓÚ]$/,
        patronEmail : /^[\w\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/,
        patronUsuario : /^([\w-a-zA-Z0-9]{3,20})$/,
        patronContrasena : /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/,
        //Banderas de verificacion
        flag1 : false,
        flag2 : false,
        flag3 : false,
        flag4 : false,

        //Funcion para cargar los eventos blur y asi validar los parametros de cada campo.
        cargarEventos : function() {
            this.nombre.addEventListener('blur', function() { registro.validarNombre() }, false);
            this.email.addEventListener('blur', function() { registro.validarEmail() }, false);
            this.usuario.addEventListener('blur', function() { registro.validarUser() }, false);
            this.contrasena.addEventListener('blur', function() { registro.validarContrasena() }, false);
            this.formulario.setAttribute('onSubmit','return registro.verificar()');
        },

        //Valida el nombre del registro
        validarNombre : function() {
            if(this.nombre.value.search(this.patronNombre)!= -1){
                this.nombre.style.border = "2px solid #9FF781";
                this.imagennombre.style.background = "url(img/textb.png)";
                this.imagennombre.style.width = "20px";
                this.imagennombre.style.height = "20px";
                this.imagennombre.style.position = "absolute";
                this.imagennombre.style.display = "inline";
                this.imagennombre.style.margin = "20px 0px 0px 158px";
                this.imagennombre.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = true;
            }else{
                this.nombre.style.border = "2px solid #E99191";
                this.imagennombre.style.background = "url(img/textc.png)";
                this.imagennombre.style.width = "20px";
                this.imagennombre.style.height = "20px";
                this.imagennombre.style.position = "absolute";
                this.imagennombre.style.display = "inline";
                this.imagennombre.style.margin = "20px 0px 0px 158px";
                this.imagennombre.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = false;
                alert('No has introducido el nombre correctamente.');
                this.nombre.focus();
            }
        },

        //Valida el email del registro         
        validarEmail : function() {
            if(this.email.value.search(this.patronEmail) != -1){
                this.email.style.border = "2px solid #9FF781";
                this.imagenemail.style.background = "url(img/textb.png)";
                this.imagenemail.style.width = "20px";
                this.imagenemail.style.height = "20px";
                this.imagenemail.style.position = "absolute";
                this.imagenemail.style.display = "inline";
                this.imagenemail.style.margin = "20px 0px 0px 346px";
                this.imagenemail.style.transition = "all 0.3s ease-in 0s";
                this.flag2 = true;
            }else{
                this.email.style.border = "2px solid #E99191";
                this.imagenemail.style.background = "url(img/textc.png)";
                this.imagenemail.style.width = "20px";
                this.imagenemail.style.height = "20px";
                this.imagenemail.style.position = "absolute";
                this.imagenemail.style.display = "inline";
                this.imagenemail.style.margin = "20px 0px 0px 346px";
                this.imagenemail.style.transition = "all 0.3s ease-in 0s";
                this.flag2 = false;
                alert('No has introducido un email correcto.');
                this.email.focus();
            }
        },

        //valida el usuario del registro         
        validarUser : function() {
            if(this.usuario.value.search(this.patronUsuario) != -1){
                this.usuario.style.border = "2px solid #9FF781";
                this.imagenusuario.style.background = "url(img/textb.png)";
                this.imagenusuario.style.width = "20px";
                this.imagenusuario.style.height = "20px";
                this.imagenusuario.style.position = "absolute";
                this.imagenusuario.style.display = "inline";
                this.imagenusuario.style.margin = "20px 0px 0px 346px";
                this.imagenusuario.style.transition = "all 0.3s ease-in 0s";
                this.flag3 = true;
            }else{
                this.usuario.style.border = "2px solid #E99191";
                this.imagenusuario.style.background = "url(img/textc.png)";
                this.imagenusuario.style.width = "20px";
                this.imagenusuario.style.height = "20px";
                this.imagenusuario.style.position = "absolute";
                this.imagenusuario.style.display = "inline";
                this.imagenusuario.style.margin = "20px 0px 0px 346px";
                this.imagenusuario.style.transition = "all 0.3s ease-in 0s";
                this.flag3 = false;
                alert('No has introducido el nombre de usuario correctamente.');
                this.usuario.focus();
            }
        },

        
        //valida la contraseña        
        validarContrasena : function() {
            if(this.contrasena.value.search(this.patronContrasena) != -1){
                this.contrasena.style.border = "2px solid #9FF781";
                this.imagencontrasena.style.background = "url(img/textb.png)";
                this.imagencontrasena.style.width = "20px";
                this.imagencontrasena.style.height = "20px";
                this.imagencontrasena.style.position = "absolute";
                this.imagencontrasena.style.display = "inline";
                this.imagencontrasena.style.margin = "20px 0px 0px 346px";
                this.imagencontrasena.style.transition = "all 0.3s ease-in 0s";
                this.flag4 = true;
            }else{
                this.contrasena.style.border = "2px solid #E99191";
                this.imagencontrasena.style.background = "url(img/textc.png)";
                this.imagencontrasena.style.width = "20px";
                this.imagencontrasena.style.height = "20px";
                this.imagencontrasena.style.position = "absolute";
                this.imagencontrasena.style.display = "inline";
                this.imagencontrasena.style.margin = "20px 0px 0px 346px";
                this.imagencontrasena.style.transition = "all 0.3s ease-in 0s";
                this.flag4 = false;
                alert('La contraseña ha de tener entre 8 y 10 caracteres, por lo menos un digito alfanumérico, y no puede contener caracteres espaciales.');
                this.contrasena.focus();
            }
        },

        //Verificacion final
        verificar : function() {
            alert('culo')
            if(this.flag1 && this.flag2 && this.flag3 && this.flag4){
                return true;
            }else{
                alert('Tienes que completar todos los campos obligatorios.');
                return false;
            }
        }
    }
    
};

//Funcion que comprueba que los datos del formulario del nuevo password sean correctos
var formularioNuevoPass = {
	objCambiarPass : {
        // Variables que recogen datos del form .
        formulario : document.getElementById('formulario'),
        ipassword : document.getElementById('ipassword'),
        imagencontrasena : document.getElementById('password'),
        irpassword : document.getElementById('irpassword'),
        imagencontrasena2 : document.getElementById('rpassword'),

        // Variables para expresiones regulares.
        patronContrasena : /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/,

        // Banderas de verificacion.
        flag1 : false,
        flag2 : false,

        // Funcion para cargar los eventos blur y asi validar los parametros de cada campo. 
        cargarEventosPass : function() {
            this.ipassword.addEventListener('blur', function() { objPass.validarContrasena() }, false);
            this.irpassword.addEventListener('blur', function() { objPass.validarContrasena2() }, false);
            //this.formulario.addEventListener('submit', function() { objPass.verificar() }, false);
            this.formulario.setAttribute('onSubmit','return objPass.verificar()');
        },

        validarContrasena : function() {
            if(this.ipassword.value.search(this.patronContrasena) != -1){
                this.ipassword.style.border = "2px solid #9FF781";
                this.imagencontrasena.style.background = "url(img/textb.png)";
                this.imagencontrasena.style.width = "20px";
                this.imagencontrasena.style.height = "20px";
                this.imagencontrasena.style.position = "absolute";
                this.imagencontrasena.style.display = "inline";
                this.imagencontrasena.style.margin = "20px 0px 0px 346px";
                this.imagencontrasena.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = true;
            }else{
                this.ipassword.style.border = "2px solid #E99191";
                this.imagencontrasena.style.background = "url(img/textc.png)";
                this.imagencontrasena.style.width = "20px";
                this.imagencontrasena.style.height = "20px";
                this.imagencontrasena.style.position = "absolute";
                this.imagencontrasena.style.display = "inline";
                this.imagencontrasena.style.margin = "20px 0px 0px 346px";
                this.imagencontrasena.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = false;
                this.ipassword.focus();
            }
        },

        validarContrasena2 : function() {
            if(this.irpassword.value.search(this.patronContrasena) != -1){
                this.irpassword.style.border = "2px solid #9FF781";
                this.imagencontrasena2.style.background = "url(img/textb.png)";
                this.imagencontrasena2.style.width = "20px";
                this.imagencontrasena2.style.height = "20px";
                this.imagencontrasena2.style.position = "absolute";
                this.imagencontrasena2.style.display = "inline";
                this.imagencontrasena2.style.margin = "20px 0px 0px 346px";
                this.imagencontrasena2.style.transition = "all 0.3s ease-in 0s";
                this.flag2 = true;
            }else{
                this.irpassword.style.border = "2px solid #E99191";
                this.imagencontrasena2.style.background = "url(img/textc.png)";
                this.imagencontrasena2.style.width = "20px";
                this.imagencontrasena2.style.height = "20px";
                this.imagencontrasena2.style.position = "absolute";
                this.imagencontrasena2.style.display = "inline";
                this.imagencontrasena2.style.margin = "20px 0px 0px 346px";
                this.imagencontrasena2.style.transition = "all 0.3s ease-in 0s";
                this.flag2 = false;
                this.irpassword.focus();
            }
        },

        //Verificacion final
        verificar : function() {
            if(this.ipassword.value == this.irpassword.value){
                if(this.flag1 && this.flag2){
                    return true;
                }else{
                    alert('Tienes que completar todos los campos obligatorios.');
                    return false;
                }
            }else{
                alert('Las contraseñas no son iguales.')
                return false;
            }
        }
    }
};
//Funcion que nos comprueba que el codigo secreto este bien introducido en su campo de texto
var formularioCodigo = {
    objCodigo : {
        // Variables que recogen datos del form .
        formulario : document.getElementById('formulario'),
        codigo : document.getElementById('icodigo'),
        imagencodigo : document.getElementById('codigo'),

        // Banderas de verificacion .
        flag1 : false,

        // Funcion para cargar los eventos blur y asi validar los parametros de cada campo. .
        cargarEventos : function() {
            this.codigo.addEventListener('blur', function() { objCode.validarCodigo() } , false);
            this.formulario.setAttribute('onSubmit','return objRecupearPass.verificar();');
        },

        //Verifica el email
        validarCodigo : function() {
            if(this.codigo.value != ""){
                this.codigo.style.border = "2px solid #9FF781";
                this.imagencodigo.style.background = "url(img/textb.png)";
                this.imagencodigo.style.width = "20px";
                this.imagencodigo.style.height = "20px";
                this.imagencodigo.style.position = "absolute";
                this.imagencodigo.style.display = "inline";
                this.imagencodigo.style.margin = "20px 0px 0px 346px";
                this.imagencodigo.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = true;
            }else{
                this.codigo.style.border = "2px solid #E99191";
                this.imagencodigo.style.background = "url(img/textc.png)";
                this.imagencodigo.style.width = "20px";
                this.imagencodigo.style.height = "20px";
                this.imagencodigo.style.position = "absolute";
                this.imagencodigo.style.display = "inline";
                this.imagencodigo.style.margin = "20px 0px 0px 346px";
                this.imagencodigo.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = false;
                this.codigo.focus();
                alert('El email introducido no es correcto.')
            }
        },

        // Verificacion final .
        verificar : function() {
            if(this.flag1){
                return true;
            }else{
                alert('Introduce el email para obtener la nueva contraseña.')
                return false;
            }
        }
    }
};

/*Funcion que comprueba que el email al que se va a enviar el correro con el codigo secreto
este bien escrito*/
var formularioRecuperarPass = {
    objRecPass : {
        // Variables que recogen datos del form .
        formulario : document.getElementById('formulario'),
        email : document.getElementById('iemail'),
        imagenemail : document.getElementById('email'),

        // Variables para expresiones regulares.
        patronEmail : /^[\w\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/,

        // Banderas de verificacion .
        flag1 : false,

        // Funcion para cargar los eventos blur y asi validar los parametros de cada campo. .
        cargarEventos : function() {
            this.email.addEventListener('blur', function() { objRecupearPass.validarEmail() } , false);
            this.formulario.setAttribute('onSubmit','return objRecupearPass.verificar();');
        },

        //Verifica el email
        validarEmail : function() {
            if(this.email.value.search(this.patronEmail) != -1){
                this.email.style.border = "2px solid #9FF781";
                this.imagenemail.style.background = "url(img/textb.png)";
                this.imagenemail.style.width = "20px";
                this.imagenemail.style.height = "20px";
                this.imagenemail.style.position = "absolute";
                this.imagenemail.style.display = "inline";
                this.imagenemail.style.margin = "20px 0px 0px 346px";
                this.imagenemail.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = true;
            }else{
                this.email.style.border = "2px solid #E99191";
                this.imagenemail.style.background = "url(img/textc.png)";
                this.imagenemail.style.width = "20px";
                this.imagenemail.style.height = "20px";
                this.imagenemail.style.position = "absolute";
                this.imagenemail.style.display = "inline";
                this.imagenemail.style.margin = "20px 0px 0px 346px";
                this.imagenemail.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = false;
                this.email.focus();
                alert('El email introducido no es correcto.')
            }
        },

        // Verificacion final .
        verificar : function() {
            if(this.flag1){
                return true;
            }else{
                alert('Introduce el email para obtener la nueva contraseña.')
                return false;
            }
        }
    }
};
//Funcion que comprueba que el evento nuevo este bien rellenado
var formularioNuevoEvento = {
    objNewEvent : {
        // Variables que recogen datos del form .
        formulario : document.getElementById('formulario'),
        titulo : document.getElementById('itituloevento'),
        imagentitulo : document.getElementById('tituloevento'),

        // Variables para expresiones regulares.
        patronNombre : /^[A-Za-zñÑ-áéíóúÁÉÍÓÚ]+([A-Za-zñÑ-áéíóúÁÉÍÓÚ] ?)*[A-Za-zñÑ-áéíóúÁÉÍÓÚ]$/,

        // Banderas de verificacion .
        flag1 : false,

        // Funcion para cargar los eventos blur y asi validar los parametros de cada campo. .
        cargarEventos : function() {
            this.titulo.addEventListener('blur', function(){ nuevoEvento.validarNombre() } , false);
            this.formulario.setAttribute('onSubmit','return nuevoEvento.verificar();');
        },

        //validar nombre
        validarNombre : function(){
            if(this.titulo.value.search(this.patronNombre)!= -1){
                this.titulo.style.border = "2px solid #9FF781";
                this.imagentitulo.style.background = "url(img/textb.png)";
                this.imagentitulo.style.width = "20px";
                this.imagentitulo.style.height = "20px";
                this.imagentitulo.style.position = "absolute";
                this.imagentitulo.style.display = "inline";
                this.imagentitulo.style.margin = "4px 0px 0px 249px";
                this.imagentitulo.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = true;
            }else{
                this.titulo.style.border = "2px solid #E99191";
                this.imagentitulo.style.background = "url(img/textc.png)";
                this.imagentitulo.style.width = "20px";
                this.imagentitulo.style.height = "20px";
                this.imagentitulo.style.position = "absolute";
                this.imagentitulo.style.display = "inline";
                this.imagentitulo.style.margin = "4px 0px 0px 249px";
                this.imagentitulo.style.transition = "all 0.3s ease-in 0s";
                this.flag1 = false;
                this.titulo.focus();
                alert('El nombre no es correcto.')
            }
        },

        // Verificacion final .
        verificar : function(){
            if(this.flag1){
                return true;
            }else{
                alert('Tienes que rellenar los campos para completar el evento.')
                return false;
            }
        }

    }
};
//Funcion que nos cambiara el background de forma aleatoria.
var background = {
    objFondo : {
        fondoAleatorio : function(){
            var fondos = new Array("back1","back2","back3","back4","back5","back6","back7","back8","back9","back10");
            var indice = Math.floor(Math.random()*fondos.length);
            var imagen = fondos[indice];
            document.body.style.background = "url(images/"+imagen+".jpg) no-repeat center center fixed";
            document.body.style.backgroundSize = "cover";
        }
    }
};
//Funcion que nos pinta en html los select en el que iran las fechas para el form de registro
var fechas = {
    objFechas : {
        registroFechas : function(){
            var options = "<select name='dia' id='dia'>";
            var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            for(var x=1;x<32;x++){
                if(x<10){
                    options += "<option value=''"+x+"'>0"+x+"</option>"
                }
                else{options += "<option value=''"+x+"'>"+x+"</option>"}
            }
            options += "</select>";
            document.getElementById('selectdia').innerHTML = options;
            options = "";
            options = "<select name='mes' id='mes'>";
            for(var x=0;x<12;x++){
                options += "<option value='"+(parseInt(x)+1)+"'>"+meses[x]+"</option>"
            }
            options += "</select>";
            document.getElementById('selectmes').innerHTML = options;
            options = "";
            options = "<select name='year' id='ano'>";
            for(var x=2014;x>1910;x--){
                options += "<option value=''"+x+"'>"+x+"</option>"
            }
            options += "</select>";
            document.getElementById('selectyear').innerHTML = options;
        }
    }
};
//Funcion para pintar en html los select con las fechas y las horas para crear eventos
var seleccionFechas = {
    objFechasInicial : {
        fechaSeleccionada : function(dia,mes,year){
            document.getElementById('diai').value = dia;
            document.getElementById('mesi').value = mes;
            document.getElementById('anoi').value = year;
            document.getElementById('diaf').value = dia;
            document.getElementById('mesf').value = mes;
            document.getElementById('anof').value = year;
        },
        registroFechasI : function(){
            var options = "<select name='diai' id='diai'>";
            var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            var f = new Date();
            var year = f.getFullYear();
            for(var x=1;x<32;x++){
                    if(x<10){
                        options += "<option value='"+x+"'>0"+x+"</option>"
                    }else{
                        options += "<option value='"+x+"'>"+x+"</option>"
                    }
            }
            options += "</select>";
            document.getElementById('selectdiai').innerHTML = options;
            options = "";
            options = "<select name='mesi' id='mesi'>";
            for(var x=0;x<12;x++){
                options += "<option value='"+(parseInt(x)+1)+"'>"+meses[x]+"</option>"
            }
            options += "</select>";
            document.getElementById('selectmesi').innerHTML = options;
            options = "";
            options = "<select name='yeari' id='anoi'>";
            for(var x=year;x<2025;x++){
                options += "<option value='"+x+"'>"+x+"</option>"
            }
            options += "</select>";
            document.getElementById('selectyeari').innerHTML = options;
        },
        registroFechasF : function(){
            var options = "<select name='diaf' id='diaf'>";
            var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            var f = new Date();
            var year = f.getFullYear();
            for(var x=1;x<32;x++){
                    if(x<10){
                        options += "<option value='"+x+"'>0"+x+"</option>"
                    }else{
                        options += "<option value='"+x+"'>"+x+"</option>"
                    }
            }
            options += "</select>";
            document.getElementById('selectdiaf').innerHTML = options;
            options = "";
            options = "<select name='mesf' id='mesf'>";
            for(var x=0;x<12;x++){
                options += "<option value='"+(parseInt(x)+1)+"'>"+meses[x]+"</option>"
            }
            options += "</select>";
            document.getElementById('selectmesf').innerHTML = options;
            options = "";
            options = "<select name='yearf' id='anof'>";
            for(var x=year;x<2025;x++){
                options += "<option value='"+x+"'>"+x+"</option>"
            }
            options += "</select>";
            document.getElementById('selectyearf').innerHTML = options;
        },
        registroHoraI : function(){
            var options = "<select name='horai' id='horai'>";
            for(var x=0;x<24;x++){
                if(x<10){
                    options += "<option value='0"+x+"'>0"+x+"</option>"
                }else{
                    options += "<option value='"+x+"'>"+x+"</option>"
                }
            }
            options += "</select>";
            document.getElementById('selecthorai').innerHTML = options;
            options = "";
            options = "<select name='mini' id='mini'>";
            for(var x=0;x<60;x++){
                if(x<10){
                    options += "<option value='0"+x+"'>0"+x+"</option>"
                }else{
                    options += "<option value='"+x+"'>"+x+"</option>"
                }
            }
            options += "</select>";
            document.getElementById('selectmini').innerHTML = options;
        },
        registroHoraF : function(){
            var options = "<select name='horaf' id='horaf'>";
            for(var x=0;x<24;x++){
                if(x<10){
                    options += "<option value='0"+x+"'>0"+x+"</option>"
                }else{
                    options += "<option value='"+x+"'>"+x+"</option>"
                }
            }
            options += "</select>";
            document.getElementById('selecthoraf').innerHTML = options;
            options = "";
            options = "<select name='minf' id='minf'>";
            for(var x=0;x<60;x++){
                if(x<10){
                    options += "<option value='0"+x+"'>0"+x+"</option>"
                }else{
                    options += "<option value='"+x+"'>"+x+"</option>"
                }
            }
            options += "</select>";
            document.getElementById('selectminf').innerHTML = options;
        }                
    }
};






