<script type="text/javascript">
//DropDown elements
var objList = ['zonal', 'actividad', 'estado', 'empresa', 'celula', 'quiebre'];

/**
 * Ubicaciones actuales (finales) de tecnicos como Google Markers
 * @type Array|@exp;marker
 */
var tecMark = {};

/**
 * Lista de actuaciones por tecnico
 * @type Array
 */
var tecActu = [];

/**
 * Lista de actuaciones temporales, sin gestión
 * @type Array
 */
var tmpActu = [];

/**
 * Mostrar trafico en Google Maps
 * 
 * @type google.maps.TrafficLayer
 */
var trafficLayer;

/**
 * Ruta de un tecnico segun su ubicacion
 * @type Array
 */
var tecPath = [];

/**
 * Coleccion de todos los elementos del mapa
 * @type Array
 */
var mapObjects = {};


    $(document).ready(function() {
        $("[data-toggle='offcanvas']").click();

        // Variables
        var objMain = $('#main');

        // Show sidebar
        function showSidebar() {
            objMain.addClass('use-sidebar');
            mapResize();
        }

        // Hide sidebar
        function hideSidebar() {
            objMain.removeClass('use-sidebar');
            mapResize();
        }

        // Sidebar separator
        var objSeparator = $('#separator');

        objSeparator.click(function(e) {
            e.preventDefault();
            if (objMain.hasClass('use-sidebar')) {
                hideSidebar();
            }
            else {
                showSidebar();
            }
        }).css('height', objSeparator.parent().outerHeight() + 'px');

        //Iniciar mapa
        objMap = doObjMap("mymap", objMapProps);
        
        /**
         * Elementos del formulario
         */

        //Valores de listas
        Visorgps.ListarSlct('actividad');
        Visorgps.ListarSlct('empresa');
        Visorgps.ListarSlct('estado');
        Visorgps.ListarSlct('quiebre');
        Visorgps.ListarSlct('celula');

        $('#fecha_estado').daterangepicker();
                
        //DropDown elements multiselect        
        $.each(objList, function (index, value){
            
            $("#slct_" + value).multiselect({
                maxHeight: 200, // max altura...
                enableFiltering: true,
                includeSelectAllOption: true,
                buttonContainer: '<div class="btn-group col-xxs-12" />', // actualiza la clase del grupo
                buttonClass: 'btn btn-primary col-xxs-12', // clase boton
                templates: {
                    ul: '<ul class="multiselect-container dropdown-menu col-xxs-12"></ul>',
                },
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return select[0].id.substring(5);
                    } else if (options.length > 2) {
                        return options.length + ' Seleccionados';//More than 3 options selected!
                    } else {
                        var labels = [];
                        options.each(function() {
                            if ($(this).attr('label') !== undefined) {
                                labels.push($(this).attr('label'));
                            }
                            else {
                                labels.push($(this).html());
                            }
                        });
                        return labels.join(', ') + '';
                    }
                },
                onDropdownHide: function(event) {
                    /**
                     * Multiselect dependientes
                     */
                    var arrSelected = [];
                    
                    //01. Empresa to Celula                    
                    if (value==='empresa')
                    {
                        $("#slct_celula").multiselect('deselectAll', false);
                        arrSelected.push($("#slct_" + value).val());
                        isRelatedTo("celula", arrSelected);
                    }
                }
            });
        });

        /**
        * Eventos botones
        */

        //Visor GPS
        $("#btn_buscar").click(function (){
            Visorgps.PanelCelulaTecnico();
        });
       
        //Limpiar mapa de temporales
        $("#btn_limpiar_tmp").click(function (){
            limpiarTmpActu();
        });

        $("#btn_limpiar_todo").click(function (){
            limpiarTmpActu();
            clearMap();
        });
        
        //Mostrar trafico
        $("#show_traffic").click(function (){
            mostrarTrafico(objMap);
        });
        
        //Mostrar, ocultar tecnicos
        $("#btn_show_tec").click(function (){
            showHideAll(objMap);
        });

        //Mostrar actuaciones pendientes BOUNCE
        $("#btn_show_pdt").click(function (){
            showBounce();
        });

        //Mostrar actuaciones coordinadas BOUNCE
        $("#btn_show_coo").click(function (){
            showCooBounce();
        });
        
    });

    /**
     * Genera child dropdown en base a valores seleccionados
     * Usa bootstrap multiselect
     * 
     * @param {type} subject
     * @param {type} parentValues
     * @returns {undefined}
     */
    function isRelatedTo(subject, parentValues){
        $("#slct_" + subject + " option").prop("disabled", true);
        //$("#slct_celula option").hide();

        var optValues = $("#slct_" + subject + ">option").map(
            function() { 
                return $(this).val(); 
            }
        );

        if (parentValues !== null)
        {
            $.each(parentValues, function(idxEmp, valOrg){
                $.each(optValues, function(idxOpt, valOpt){

                    var element = $("#slct_" + subject + " option[value='" + valOpt + "']");
                    var sptVal = valOpt.split("_");

                    if ('E' + valOrg == sptVal[0])
                    {
                        element.prop("disabled", false);
                        //element.show();
                    }
                });
            });                            
        } else {
            $("#slct_" + subject + " option").prop("disabled", false);
        }
        
        $("#slct_" + subject).html($("#slct_" + subject + " option").sort(function(x, y) {
            return $(x).prop("disabled") ? 1 : -1;
        }));

        $("#slct_" + subject).multiselect('rebuild');
        $("#slct_" + subject).multiselect('refresh');
    }
    
    function batteryIcon(level){
        var icon = "";

        if (level >=0 && level < 10)
        {
            icon = "0";
        } else if (level >=10 && level < 20)
        {
            icon = "10";
        } else if (level >=20 && level < 40)
        {
            icon = "20";
        } else if (level >=40 && level < 60)
        {
            icon = "40";
        } else if (level >=60 && level < 80)
        {
            icon = "60";
        } else if (level >=80 && level < 90)
        {
            icon = "80";
        } else if (level >=90 && level <= 100)
        {
            icon = "100";
        } else {
            icon = "0";
        }

        icon = "<img alt=\"" + level + "%\" title=\"" + level + "%\" src=\"img/battery/battery_" 
                + icon 
                + "percent.png\" style=\"height:24px; vertical-align:middle\">";

        return icon;
    }
    
    
    function showHideTec(code, show){

        //Tecnicos en mapa
        if ( typeof tecMark[code] !== 'undefined' )
        {
            if (!show)
            {
                //Ocultar tecnico
                tecMark[code].setMap(null);
            } else {
                //Mostrar tecnicos
                tecMark[code].setMap(objMap);
            }
        }    

        //Agendas en mapa
        if ( typeof tecActu[code] !== 'undefined' )
        {
            $.each(tecActu[code], function(id, val){

                if (typeof val === 'object')
                {
                    if (!show)
                    {
                        //Ocultar agendas
                        this.setMap(null);
                    } else {
                        //Mostrar agendas
                        this.setMap(objMap);
                    }
                }

            });
        }            

    }
    
    /**
    * Limpia (oculta) todos elementos del mapa
    * @returns {Boolean}
    */
    function clearMap() {
        try {
            //Elimina ultima ubicacion tecnicos
            $.each(tecMark, function() {
                this.setMap(null);
            });

            //Elimina localizacion de actuaciones
            $.each(tecActu, function() {
                this.setMap(null);
            });

            //Elimina localizacion de actuaciones temporales
            $.each(tmpActu, function() {
                this.setMap(null);
            });

            //Elimina ruta de tecnicos
            //$.each(mapObjects, function(id, obj) {
            //    doNotPath(id);
            //});

            //Variables en blanco
            actuPath = [];
            tecData = [];
            tecActu = [];
            tmpActu = [];
            tecMark = {};
            tecList = [];
            tecPath = [];
            zIndex = 1;
            //mapObjects = {};
            bounds = new google.maps.LatLngBounds();

            //initialize();
            objMap = doObjMap("mymap", objMapProps);

            return true;
        } catch (e) {
            console.log(e);
        }
    }
    
    
    function doTecList(teclist, icons) {
        try {
            var n = 0;
            var carnet;
            var tecnico = "";
            var color;
            var batteryLevel = 0;
            var htmlTecList = "";
            var tecLatLng;

            $.each(teclist, function() {

                n++;
                carnet = this.carnet_tmp;
                /*
                if (typeof mapObjects[carnet] === "undefined") {
                    mapObjects[carnet] = new Array();
                }
                */

                //Nivel de bateria del tecnico
                var batteryLevel = Number(this.battery);
                var tec_phone = this.phone.substr(-9)
                //var tec_lastUpdate = this.t.substr(-8)
                var tec_x = this.x.replace(",",".")
                var tec_y = this.y.replace(",",".")

                var go_gmap = "";
                tecnico = this.carnet + " / " + this.nombre_tecnico;
                
                
                var link_ultima_liquida = " <a href=\"javascript:void(0)\" onclick=\"showLastLiq('" + carnet + "')\">LIQ</a> ";
                /*
                if(window.usuario_movil){
                    tecnico = this.carnet + " / " + "<a href=\"tel:"+tec_phone+"\">" + this.nombre_tecnico + "</a>"+" ";
                    if(tec_coory != "" && tec_coorx != ""){
                        go_gmap = " http://maps.google.com/maps?saddr="+usuario_movil_y+","+ usuario_movil_x +"&daddr="+ tec_coory + ","+ tec_coorx;
                        go_gmap = " <a class='go-map' href='"+go_gmap+"'> <img src='images/car.png' style=\"height: 24px; vertical-align: middle\"> </a>";
                    }
                }
                */

                //AGREGANDOP GRUPO POR CELULA
                
                var grupo_html = "";
                /*var celula = $("#celula").val();
                var grupos = this.grupos.split(",")

                grupo_html += "<select idcel='"+celula+"' idtec='"+this.id+"' id='grupo-"+carnet+"' class='grupoCelula' carnet='"+carnet +"' multiple style='display:none;'>"

                for(var i=1; i<11;i++){
                    var existe = $.inArray(i+"",grupos); // existe tendra el indice del item del array
                    var selected =""
                    if(existe >-1){
                        selected = "selected='selected'";
                    }
                    grupo_html+= "<option value='"+i+"' "+selected+">Grupo "+i+"</option>";
                }

                grupo_html +="</select>";
                */

                var grupos_class =""
                /*grupos.forEach(function(i){
                    grupos_class += " g-"+i
                });
                */

                color = icons[carnet].tec.substring(4,10);
                
                htmlTecList += "<div class=\"tecRow "+grupos_class+ " \">"
                    +    "<div>"
                    +        "<span>" + n + ".</span>"
                    +        "<span>"  + tecnico +  "</span>"
                    +            grupo_html
                    +    "</div>"
                    +    "<div style=\"margin-left: 12px;\">"
                    +        "<input type=\"checkbox\" value=\"" + carnet  + "\" class=\"chb_tec\" checked>"
                    +        "<a href=\"javascript:void(0)\" onclick=\"openInfoWin('" + carnet + "')\"><img src=\"img/icons/visorgps/" + icons[carnet].tec + "\" style=\"height: 24px; vertical-align: middle\" alt=\"Info Tecnico\" title=\"Info Tecnico\"></a>"
                    +        "<a href=\"javascript:void(0)\" onclick=\"Visorgps.DoPath('" + carnet + "', '" + color + "')\"><img src=\"img/icons/visorgps/" + icons[carnet].car + "\" style=\"height: 24px; vertical-align: middle\" alt=\"Ruta Tecnico\" title=\"Ruta Tecnico\"></a>"
                    +        "<a href=\"javascript:void(0)\" onclick=\"actuTecPath('" + carnet + "')\"><img src=\"img/icons/visorgps/" + icons[carnet].cal + "\" style=\"height: 24px; vertical-align: middle\" alt=\"Ruta Agendas\" title=\"Ruta Agendas\"></a>"
                    +        batteryIcon(batteryLevel)
                    //+        "<span id=\"nagtec_" + carnet + "\">(00)</span>"  + tec_lastUpdate + go_gmap + link_ultima_liquida
                    +    "</div>"
                    +"</div>"
                
                /**
                 * Tecnicos en mapa
                 */
                if (tec_x!=="" && tec_y!=="")
                {
                    bounds.extend(new google.maps.LatLng(tec_y, tec_x));

                    //Color tecnico
                    //color = icons[this.EmployeeNum]['tec'].substring(4,10);

                    //Marcador
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(tec_y, tec_x),
                        icon: "img/icons/visorgps/" + icons[carnet]['tec'],
                        map: objMap,
                        title: carnet,
                        zIndex: zIndex++
                    });
                    
                    //DATA PARA VISOR PUBLICO MOVIL
                    var   link_go = "";
                    var   link_go_ocultar = "";
                    /*
                    if(window.usuario_movil){
                        link_go = " - <a href=\"javascript:void(0)\" onClick=\"GoToTecnico('"+x+"','"+y+"')\"> >> Go </a>";
                        link_go_ocultar = " - <a href=\"javascript:void(0)\" onClick=\"ocultarGoToTecnico()\"> Hide GoTo </a>";
                    }
                    */
                    //var link_ultima_liquida = " - <a href=\"javascript:void(0)\" onclick=\"showLastLiq('" + carnet_tecnico + "')\">LIQ</a> ";

                    //Detalle de ultima posicion
                    infocontent = "<table>"
                            + "<tr>"
                            + "    <td rowspan=\"6\"><img src=\"img/icons/tecnico.png\"></td>"
                            + "    <td></td>"
                            + "</tr>"
                            + "<tr>"
                            + "    <td>" + this.EmployeeNum + "</td>"
                            + "</tr>"
                            + "<tr>"
                            + "    <td>" + "<a href=\"tel:"+tec_phone+"\">" + tec_phone + "</a></td>"
                            + "</tr>"
                            + "<tr>"
                            + "    <td>" + tecnico + "</td>"
                            + "</tr>"
                            + "<tr>"
                            //+ "    <td>" + this.t + "</td>"
                            + "</tr>"
                            //+ "<tr>"
                            //+ "    <td><a href=\"javascript:void(0)\" onClick=\"doPath('" 
                            //    + this.EmployeeNum + "', '" 
                            //    + color + "')\">Mostrar ruta</a> " + link_go + link_ultima_liquida
                            //+  "</td>"
                            //+ "</tr>"
                            + "<tr>"
                            + "    <td><a href=\"javascript:void(0)\" onClick=\"doNotPath('" 
                                + this.EmployeeNum 
                                + "')\">Ocultar ruta</a> " + link_go_ocultar  +" </td>"
                            + "</tr>"
                            + "</table>";
                    //Crear infowindow de la ultima posicion
                    //doInfoWindow(marker, infocontent);
                    google.maps.event.addListener(marker, "click", function (){
                        infowindow.setPosition(new google.maps.LatLng(tec_y, tec_x));
                        infowindow.setContent(infocontent);
                        infowindow.open(self.objMap);
                    });
                    
                    //Agregar marcadores de tecnicos al objeto
                    if (typeof tecMark[carnet] === "undefined") {
                        tecMark[carnet] = new Array();
                    }
                    tecMark[carnet] = marker;
                }

                

            });
            $("#tec-list").html(htmlTecList);

            //Mostrar y marcar checkbox
            if (n >= 1) 
            {
                $(".show_hide_tec").show();
                $("#show_tec").prop('checked', true);
            }

            //Class chb_tec
            $(".chb_tec").click(function (){
                showHideTec($(this).val(), $(this).prop("checked"));
            });

        } catch (e) {
            console.log(e);
        }
    }
    
   
    function doTecAgenda(data, icons){
        
        tmpActu = [];
        tecActu = [];
        var agendaIcon = "";
       
        $.each(data, function(){
            
            var infocontent = "";
        
            //Carnet de tecnico
            var carnet = this.carnet_tmp;

            //Arreglo de actuaciones por tecnico
            if (typeof tecActu[carnet] === "undefined") {
                tecActu[carnet] = new Array();
            }

            //Agendas con XY (taps o terminales)
            if (this.x !== "" && this.y !== "")
            {
                myLatlng = new google.maps.LatLng(this.y, this.x);

                bounds.extend(myLatlng);
                
                $.each(icons, function(id, val){
                    if (carnet === id)
                    {
                        agendaIcon = "img/icons/visorgps/" + val.cal;
                    }
                });
                
                //Contenido infowindow
                if (this.estado === 'Temporal')
                {
                    //Icono temporales
                    agendaIcon = "img/icons/tmp_actu.png"
                    
                    infocontent =   "<div class=\"infow\" style=\"width:300px; height:200px; overflow: auto; text-align: left\">" +
                                        "<input type=\"button\" id=\"detalle_actu\" value=\"Mostrar/Ocultar detalle\" onclick=\"mostrarOcultarDetalle()\">" + 
                                        "<div class=\"detalle_actu\">" + 
                                            "Tipo: " + this.tipoactu + "<br>" + 
                                            "Codigo: " + this.codactu + "<br>" + 
                                            "Horas: " + this.horas_actu + "<br>" + 
                                            "Fec. Registro: " + this.fecha_registro + "<br>" + 
                                            this.nombre_cliente + "<br>" + 
                                            this.direccion_instalacion + "<br>" + 
                                            this.fftt + "<br>" + 
                                            this.telefono + "<br>" +  
                                            this.x + " / " + this.y + "<br>" + 
                                        "</div>" +
                                        //"<div><a href=\"javascript:void(0)\" onclick=\"gestionActuTmp('" + this.codactu  + "', '0', '" + tipo + "')\">Gestionar <img src=\"../historico/img/gestionar.png\" style=\"vertical-align: middle\"></a>&nbsp;" + 
                                        "<div class=\"detalle_gestion\"></div>" + 
                                    "</div>";
                } else {
                    infocontent +=   "<div class=\"infow\" style=\"width:300px; height:200px; overflow: auto; text-align: left\"\">" +
                                        "<input type=\"button\" id=\"detalle_actu\" value=\"Mostrar/Ocultar detalle\" onclick=\"mostrarOcultarDetalle()\">" + 
                                        "<div class=\"detalle_actu\">" + 
                                            this.tipoactu + "<br>" + 
                                            this.nombre_cliente + "<br>" + 
                                            this.fecha_agenda + " / " + 
                                            this.horario + "<br>" + 
                                            this.direccion_instalacion + "<br>" + 
                                            this.codactu + "<br>" + 
                                            this.fftt + "<br>" + 
                                            this.codigo_cliente + "<br>" + 
                                            this.id_atc + "<br>" + 
                                            this.carnet_tmp + "<br>" + 
                                            this.quiebre + "<br>" + 
                                            this.tecnico + "<br>" + 
                                        "</div>";
                                        if($.trim($("#sinagenda").val())==''){
                    infocontent+=       //"<div><a href=\"javascript:void(0)\" onclick=\"gestionActu('" + this.id  + "', '0', '" + tipo_actu + "')\">Gestionar <img src=\"../historico/img/gestionar.png\" style=\"vertical-align: middle\"></a>&nbsp;" + 
                                        "<div class=\"detalle_gestion\"></div>";
                                        }
                    infocontent+=       "<div><a href=\"javascript:void(0)\" onclick=\"get_detalle_paso('0001-|" + this.id_atc + "')\">1. Inicio</a>&nbsp;" + 
                                        "<a href=\"javascript:void(0)\" onclick=\"get_detalle_paso('0002-|" + this.id_atc + "')\">2. Supervision</a>&nbsp;" + 
                                        "<a href=\"javascript:void(0)\" onclick=\"get_detalle_paso('0003-|" + this.id_atc + "')\">3. Cierre</a></div>" +
                                        "<div class=\"detalle_paso\"></div>" +                                    
                                    "</div>";
                }

                try {
                    //Marcador
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(this.y, this.x),
                        map: objMap,
                        title: this.EmployeeNum,
                        icon: agendaIcon,
                        zIndex: zIndex++,
                        codactu: this.codactu,
                        tipoactu: this.tipoactu,
                        idgestion: this.id,
                        estado: this.estado,
                        //coordinado: this.coordinado,
                        carnet: carnet
                    });

                    /*
                    //Efecto "BOUNCE" para las agendas pendientes o en curso
                    if ( this.id_estado != 3 && this.id_estado != 19 )
                    {
                        marker.estado = "pendiente";
                    } else {
                        marker.estado = "liquidado";
                    }
                    */
                   
                    //Marcadores temporales
                    if (this.estado === 'Temporal')
                    {
                        tmpActu.push(marker);
                    }

                    //Agrega marcados al arreglo de agendas por tecnico
                    if (carnet !== '')
                    {
                        tecActu[carnet].push(marker);
                    }
                    /*
                    infocontent =   "<div class=\"infow\" style=\"width:300px; height:200px; overflow: auto\">" +
                                        "<input type=\"button\" id=\"detalle_actu\" value=\"Mostrar/Ocultar detalle\" onclick=\"mostrarOcultarDetalle()\">" + 
                                        "<div class=\"detalle_actu\">" + 
                                            this.tipoactu + "<br>" + 
                                            this.nombre_cliente_critico + "<br>" + 
                                            this.fecha_agenda + " / " + 
                                            this.horario + "<br>" + 
                                            this.observacion + "<br>" + 
                                            this.direccion + "<br>" + 
                                            this.codactu + "<br>" + 
                                            this.fftt + "<br>" + 
                                            this.codcli + "<br>" + 
                                            this.mdf + "<br>" + 
                                            this.id_atc + "<br>" + 
                                            this.lejano + "<br>" +  
                                            this.carnet_critico + "<br>" + 
                                            this.paquete + "<br>" + 
                                            this.quiebre + "<br>" + 
                                            this.tecnico + "<br>" + 
                                        "</div>";
                                        if($.trim($("#sinagenda").val())==''){
                    infocontent+=       "<div><a href=\"javascript:void(0)\" onclick=\"gestionActu('" + this.id  + "', '0', '" + tipo_actu + "')\">Gestionar <img src=\"../historico/img/gestionar.png\" style=\"vertical-align: middle\"></a>&nbsp;" + 
                                        "<div class=\"detalle_gestion\"></div>";
                                        }
                    infocontent+=       "<div><a href=\"javascript:void(0)\" onclick=\"get_detalle_paso('0001-|" + this.id_atc + "')\">1. Inicio</a>&nbsp;" + 
                                        "<a href=\"javascript:void(0)\" onclick=\"get_detalle_paso('0002-|" + this.id_atc + "')\">2. Supervision</a>&nbsp;" + 
                                        "<a href=\"javascript:void(0)\" onclick=\"get_detalle_paso('0003-|" + this.id_atc + "')\">3. Cierre</a></div>" +
                                        "<div class=\"detalle_paso\"></div>" +                                    
                                    "</div>";

                    doInfoWindow(marker, infocontent);
                    */
                    /*
                    google.maps.event.addListener(marker, "click", function (){
                        infowindow.setPosition(new google.maps.LatLng(this.y, this.x));
                        infowindow.setContent(infocontent);
                        infowindow.open(self.objMap);
                    });
                    */
                    doInfoWindow(objMap, marker, infocontent);
                } catch (e) {
                    console.log(e);
                }

                objMap.fitBounds(bounds);

            } else {
                //Agrega agendas sin XY, se agrega ATC
                //tecActu[this.carnet_tmp].push(this.id_atc);
            }

        });
        
        //Boton muestra todos los tecnicos y agendas
        $("#btn_show_tec").removeClass("btn btn-default");
        $("#btn_show_tec").addClass("btn btn-success");
    }
    
    
    function limpiarTmpActu(){
        //Elimina marcadores tmp del mapa
        if (tmpActu.length > 0)
        {
            $.each(tmpActu, function (){
                this.setMap(null);
            });
            tmpActu = [];
        }
    }
    
    /**
     * Muestra infowindow para un marcador
     * 
     * @param {type} thisMap Mapa donde se mostrar marcador
     * @param {type} element Marcador (marker)
     * @param {type} content Contenido (html) del infowindow
     */
    function doInfoWindow(thisMap, element, content) {
        google.maps.event.addListener(element, 'click', (
            function(marker, infocontent, infowindow) {
                return function() {
                    infowindow.setContent(infocontent);
                    infowindow.open(thisMap, marker);
                };
            })(element, content, infowindow));
    }
    
    function mostrarTrafico(thisMap){
        
        var btnClass = $("#show_traffic").attr("class") ;
        
        if (btnClass==='btn btn-default')
        {
            trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(thisMap);
            
            $("#show_traffic").html("Ocultar tr&aacute;fico");
            $("#show_traffic").removeClass("btn btn-default");
            $("#show_traffic").addClass("btn btn-success");
        } else {
            trafficLayer.setMap(null);
            
            $("#show_traffic").html("Mostrar tr&aacute;fico");
            $("#show_traffic").removeClass("btn btn-success");
            $("#show_traffic").addClass("btn btn-default");
        }

    }
    
    function mostrarOcultarDetalle(){
        $( ".detalle_actu" ).toggle( "slow" );
    }
    
    function showHideAll(thisMap){
        var show;
        
        if ($("#btn_show_tec").attr("class") === 'btn btn-success')
        {
            show = false;
            $("#btn_show_tec").removeClass("btn btn-success");
            $("#btn_show_tec").addClass("btn btn-default");
        } else {
            show = true;
            $("#btn_show_tec").removeClass("btn btn-default");
            $("#btn_show_tec").addClass("btn btn-success");
        }

        //Tecnicos en mapa
        $.each(tecMark, function(){
            if (!show)
            {
                //Ocultar tecnicos
                this.setMap(null);
            } else {
                //Mostrar tecnicos
                this.setMap(thisMap);
            }
        });

        //Agendas en mapa
        for (key in tecActu) {
            if (tecActu.hasOwnProperty(key))
            {
                $.each(tecActu[key], function(id, val){

                    if (typeof val === 'object')
                    {
                            if (!show)
                        {
                            //Ocultar agendas
                            this.setMap(null);
                        } else {
                            //Mostrar agendas
                            this.setMap(thisMap);
                        }
                    }


                });
            }
        }

        //Checkbox por tecnico
        $.each($(".chb_tec"), function(){
            if (!show)
            {
                //Ocultar agendas
                $(this).prop("checked", false);
            } else {
                //Mostrar agendas
                $(this).prop("checked", true);
            }
        });

    }
        
    
    function drawTecPath(data, code, color, thisMap) {
        if(data.data.length === 0)
        {
            alert("No se encontro ruta para el tecnico seleccionado.");
            return false;
        }

        if (data.estado === true)
        {
            var x;
            var y;
            var n = 1;
            var markerIcon;
            tecPath = [];

            /**
             * Bounds para un solo elemento: path, marker, etc.
             */
            var pathMarker;
            var pathContent = "";
            var boundsElement = new google.maps.LatLngBounds();

            $.each(data.data, function() {
                x = Number(this.X.replace(",", "."));
                y = Number(this.Y.replace(",", "."));
                myLatlng = new google.maps.LatLng(y, x);

                tecPath.push(myLatlng);

                boundsElement.extend(myLatlng);

                //Marcador de inicio
                if (n===1)
                {
                    markerIcon = "http://chart.apis.google.com/chart" 
                        + "?chst=d_map_pin_letter&chld=1|" 
                        + color
                        + "|"
                        + textByColor("#" + color).substring(1,7);
                } else {
                    markerIcon = "img/icons/Marker-Ball-Pink.png";
                }

                //Marcador
                pathMarker = new google.maps.Marker({
                    position: myLatlng,
                    map: thisMap,
                    title: this.EmployeeNum,
                    icon: markerIcon,
                    zIndex: zIndex++
                });

                if (typeof mapObjects[this.EmployeeNum] === "undefined") {
                    mapObjects[this.EmployeeNum] = new Array();
                }
                mapObjects[this.EmployeeNum].push(pathMarker);
                tecCode = this.EmployeeNum;


                //Contenido + Infowindow
                pathContent = this.EmployeeNum
                        + "<br>"
                        + this.t
                        + "<br>"
                        + this.Battery
                        + "<br>"
                        + "<a href=\"javascript:void(0)\" onClick=\"doNotPath('" + this.EmployeeNum + "')\">Ocultar ruta</a>";
                
                doInfoWindow(thisMap, pathMarker, pathContent);
                /*google.maps.event.addListener(pathMarker, "click", function (){
                    infowindow.setPosition(myLatlng);
                    infowindow.setContent(pathContent);
                    infowindow.open(self.objMap);
                });*/
                
                n++;
            });
            thisMap.fitBounds(boundsElement);

            //Dibujar Path
            drawPath = new google.maps.Polyline({
                path: tecPath,
                geodesic: true,
                strokeColor: '#' + color,
                strokeOpacity: 1.0,
                strokeWeight: 3
            });

            drawPath.setMap(thisMap);
            mapObjects[code].push(drawPath);
        } else {
            console.log("Error");
        }
    }
    
    /**
    * Oculta una ruta de tecnico
    * 
    * @param {type} code
    * @returns {undefined}
    */
   function doNotPath(code) {
       try {
           //Elimina ruta de un tecnico
           $.each(mapObjects[code], function() {
               this.setMap(null);
           });
       } catch (e) {
           console.log(e);
       }
   }
   
   
    function openInfoWin(code) {
        try {
            if ( typeof tecMark[code] === 'undefined' )
            {
                throw "[show]T\u00E9cnico sin ubicaci\u00F3n.";
            }
            google.maps.event.trigger(tecMark[code], 'click');
        } catch (e) {
            errorMessage(e);
        }
    }
</script>