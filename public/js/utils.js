/**
 * Muestra un mensaje al pie de la página
 * 
 * @param String tipo "success" para OK o "danger" para ERROR
 * @param String texto El mensaje a mostrar
 * @param Int tiempo Tiempo que tarda en desaparecer el mensaje
 * @returns {undefined}
 */
function alertBootstrap(tipo, texto, tiempo) {
    var fan= '<i class="fa fa-ban"></i>';
    if (tipo==='success') {
        fan='<i class="fa fa-check"></i>';
    }
    if (tipo == 'danger' && texto.length == 0) {
        texto = 'Ocurrio una interrupción en el proceso, favor de intentar nuevamente.';
    }
    var html='<div class="alert alert-dismissable alert-' + tipo + '">' +fan+
            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
            '<b>' + texto + '</b>' +
            '</div>';

    $("#msj").html(html);
    $("#msj").effect('shake');
    $("#msj").fadeOut(tiempo*1000);
}
/**
 * 
 * Utilitarios Javascript
 * 
 */

/**
 * Genera un color aleatorio
 * 
 * @returns {String}
 */
function getRandomColor() {
    var hex = Math.floor(Math.random() * 0xFFFFFF);
    return "#" + ("000000" + hex.toString(16)).substr(-6);
}

/**
 * Convierte un valor hexadecimal al sistema decimal
 * @param {type} h
 * @returns {unresolved}
 */
function hexdec(h) {
    h = h.toUpperCase();
    return parseInt(h, 16);
}

/**
 * Retorna color de texto de acuerdo al color de fondo
 * Color de texto: Blanco o negro.
 * Recibe color en hexadecimal con '#'
 * @param {type} color
 * @returns {String}
 */
function textByColor(color) {
    color = color.substring(1);

    var c_r = hexdec(color.substring(0, 2));
    var c_g = hexdec(color.substring(2, 4));
    var c_b = hexdec(color.substring(4, 6));

    var bg = ((c_r * 299) + (c_g * 587) + (c_b * 114)) / 1000;
    if (bg > 130) {
        return "#000000";
    } else {
        return "#FFFFFF";
    }
}

/**
 * Retorna una cadena con ceros delante
 * 
 * @param {type} num El numero a formatear
 * @param {type} size El tamaño final de la cadena con ceros
 * @returns {String|pad.s}
 */
function pad(num, size) {
    //Via http://stackoverflow.com/questions/2998784/how-to-output-integers-with-leading-zeros-in-javascript
    var s = num + "";
    while (s.length < size)
        s = "0" + s;
    return s;
}

/**
 * Retorna los valores seleccionados 
 * de un elemento multiselect (jquery plugin)
 * separados por comas
 * 
 * @param {String} selector . / # / [vacio]
 * @param {String} element nombre del class, id o etiqueta
 * @returns {getMultiSelect.searchItem|String} Cadena de valores
 */
function getMultiSelect(selector, element){
    try {
        if ( $.trim( element ) === "" )
        {
            throw "[show]No se encuentra el elemento";
        }
        
        var searchItem = "";
        var itemsChecked = $(selector + element)
                .multiselect("getChecked")
                .map(function() {
            return this.value;
        }).get();

        //Cadena de elementos a buscar
        $.each(itemsChecked, function(){
            searchItem += "," + this;
        });
        searchItem = searchItem.substring(1);

        return searchItem;
        
    } catch (e){
        errorMessage(e);
    }    
}