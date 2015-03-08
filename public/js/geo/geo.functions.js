/**
 * Variales globales
 */

//Objeto Mapa
var objMap;

/**
 * z-index de los elementos del mapa
 * @type Number|Number
 */
var zIndex = 1;

//Propiedades globales del mapa
var objMapProps = {
    center: new google.maps.LatLng(-12.109121, -77.016269),
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
    
};

//Objeto marcador
var marker;

//Arreglo de marcadores
var markers = [];

//Objeto infowindow
var infowindow;

//Contenido de un infowindow
var infocontent;

//Limites del mapa segun los elementos
var bounds;

//Limites de un solo elemento
var boundsElement;

//Una ubicacion en particular
var myLatlng;

/**
 * Inicia un mapa de google
 * 
 * @param {type} element
 * @param {type} props
 * @returns {objMap|google.maps.Map}
 */
function doObjMap(element, props){
    var thisMap = new google.maps.Map(document.getElementById(element), props);
    
    infowindow = new google.maps.InfoWindow({
        content: ""
    });
    
    return thisMap;
}

/**
 * Redimensiona solo el mapa
 * @returns {Boolean}
 */
function mapResize() {
    google.maps.event.trigger(objMap, 'resize');
    return true;
}