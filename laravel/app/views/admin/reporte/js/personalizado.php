<script type="text/javascript">
var NombreMes=["","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
var TotalGlobal={total:0,pendiente:0,atendido:0,destiempo_a:0,destiempo_p:0,finalizo:0};
$(document).ready(function() {
    
   $('.tree').treegrid({
//        onChange: function() {
//            alert("Changed: "+$(this).attr("id"));
//        }, 
//        onCollapse: function() {
//            alert("Collapsed: "+$(this).attr("id"));
//        }, 
//        onExpand: function() {
//            alert("Expanded "+$(this).attr("id"));
//        }});
//        $('#node-1').on("change", function() {
//            alert("Event from " + $(this).attr("id"));
    });
//    $("#generar").click(function (){
//        var fecha=$("#fecha").val();
//        if ( fecha!=="") {
//            var dataG = {fecha:fecha};
//            Auditoria.CuadroAuditoria(dataG);
//        }else{
//            alert("Seleccione Fecha");
//        }
//    });
//   
//    $("#btnexport").click(GeneraHref);
//var ctx = $("#myChart");
'use strict';

window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
        black: 'rgb(0,0,0)',
};

(function(global) {
	var Months = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	];

	var COLORS = [
		'#4dc9f6',
		'#f67019',
		'#f53794',
		'#537bc4',
		'#acc236',
		'#166a8f',
		'#00a950',
		'#58595b',
		'#8549ba'
	];

	var Samples = global.Samples || (global.Samples = {});
	var Color = global.Color;

	Samples.utils = {
		// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
		srand: function(seed) {
			this._seed = seed;
		},

		rand: function(min, max) {
			var seed = this._seed;
			min = min === undefined ? 0 : min;
			max = max === undefined ? 1 : max;
			this._seed = (seed * 9301 + 49297) % 233280;
			return min + (this._seed / 233280) * (max - min);
		},

		numbers: function(config) {
			var cfg = config || {};
			var min = cfg.min || 0;
			var max = cfg.max || 1;
			var from = cfg.from || [];
			var count = cfg.count || 8;
			var decimals = cfg.decimals || 8;
			var continuity = cfg.continuity || 1;
			var dfactor = Math.pow(10, decimals) || 0;
			var data = [];
			var i, value;

			for (i = 0; i < count; ++i) {
				value = (from[i] || 0) + this.rand(min, max);
				if (this.rand() <= continuity) {
					data.push(Math.round(dfactor * value) / dfactor);
				} else {
					data.push(null);
				}
			}

			return data;
		},

		labels: function(config) {
			var cfg = config || {};
			var min = cfg.min || 0;
			var max = cfg.max || 100;
			var count = cfg.count || 8;
			var step = (max - min) / count;
			var decimals = cfg.decimals || 8;
			var dfactor = Math.pow(10, decimals) || 0;
			var prefix = cfg.prefix || '';
			var values = [];
			var i;

			for (i = min; i < max; i += step) {
				values.push(prefix + Math.round(dfactor * i) / dfactor);
			}

			return values;
		},

		months: function(config) {
			var cfg = config || {};
			var count = cfg.count || 12;
			var section = cfg.section;
			var values = [];
			var i, value;

			for (i = 0; i < count; ++i) {
				value = Months[Math.ceil(i) % 12];
				values.push(value.substring(0, section));
			}

			return values;
		},

		color: function(index) {
			return COLORS[index % COLORS.length];
		},

		transparentize: function(color, opacity) {
			var alpha = opacity === undefined ? 0.5 : 1 - opacity;
			return Color(color).alpha(alpha).rgbString();
		}
	};

	// DEPRECATED
	window.randomScalingFactor = function() {
		return Math.round(Samples.utils.rand(-100, 100));
	};

	// INITIALIZATION

	Samples.utils.srand(Date.now());

	// Google Analytics
	/* eslint-disable */
	if (document.location.hostname.match(/^(www\.)?chartjs\.org$/)) {
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-28909194-3', 'auto');
		ga('send', 'pageview');
	}
	/* eslint-enable */

}(this));



	
});

eventoSlctGlobalSimple=function(slct,valores){
};

selectTR=function(boton,tipo){
    
    var tr = boton;
    var trs = tr.parentNode.children;
    for (var i = 0; i < trs.length; i++)
        trs[i].style.backgroundColor = "#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    var dataG={};
    //if(1==2){    
        if(tipo==1){
             dataG={fecha_ini:$(boton).data("fechaini"),fecha_fin:$(boton).data("fechafin"),ruta_flujo_id:$(boton).data("rutaflujoid"),length_norden:$(boton).data("length_norden"),norden:$(boton).data("norden"),ruta_flujo_id_micro:$(boton).data("ruta_flujo_id_micro")};
        }else{
             dataG={fecha_ini:$(boton).data("fechaini"),fecha_fin:$(boton).data("fechafin"),ruta_flujo_id:$(boton).data("rutaflujoid"),length_norden:$(boton).data("length_norden"),ruta_flujo_id_micro:$(boton).data("ruta_flujo_id_micro")};
        }
        var ResumenG={pendiente:$(boton).data("pendiente"),atendido:$(boton).data("atendido"),finalizo:$(boton).data("finalizo"),destiempo_p:$(boton).data("destiempo_p"),destiempo_a:$(boton).data("destiempo_a")};
        Personalizado.GraficoData(dataG,ResumenG);
        $("#graficaModal").modal("show");
    //}
};

HTMLPersonalizado=function(datos,parametros){
    TotalGlobal.total=0;
    TotalGlobal.pendiente=0;
    TotalGlobal.atendido=0;
    TotalGlobal.destiempo_a=0;
    TotalGlobal.destiempo_p=0;
    TotalGlobal.finalizo=0;
    
    var html ='';
    var pos=0;
    var parent=0;
    var aux_id=0;
    
    var totalr=0;
    var pendienter=0;
    var destiempopr=0;
    var atendidor=0;
    var destiempoar=0;
    var finalizador=0;
    $.each(datos,function(index,data){
        
        if(aux_id!==data.flujo_id){
            if(index>0){
                html = html.replace(/totalr/g, totalr);
                html = html.replace(/pendienter/g, pendienter);
                html = html.replace(/atendidor/g, atendidor);
                html = html.replace(/finalizador/g, finalizador);
                html = html.replace(/destiempopr/g, destiempopr);
                html = html.replace(/destiempoar/g, destiempoar);
            }
            pos++;
            html+="<tr class='treegrid-"+pos+"' ondblclick='selectTR(this,0)' id='"+pos+"' data-rutaflujoid='"+parametros.ruta_flujo_id+"' data-fechaini='"+parametros.fecha_ini+"' data-fechafin='"+parametros.fecha_fin+"' data-length_norden='"+data.norden.length+"' data-pendiente='pendienter' data-atendido='atendidor' data-finalizo='finalizador' data-destiempo_p='destiempopr' data-destiempo_a='destiempoar'>";
            html+="<td colspan='2'><b>"+data.flujo+"</b></td>"+
            "<td><b class='oculto'>totalr</b></td>"+
            "<td><b class='oculto'>pendienter / <span style='color:red;'>destiempopr</span></b></td>"+
            "<td><b class='oculto'>atendidor / <span style='color:red;'>destiempoar</span></b></td>"+
            "<td><b class='oculto'>finalizador</b></td>";
            html+="</tr>";
                
            totalr=0;
            pendienter=0;
            atendidor=0;
            finalizador=0;
            destiempopr=0;
            destiempoar=0;
            
            aux_id=data.flujo_id;
            parent=pos;
            pos++;
            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            destiempopr=destiempopr+data.destiempo_p;
            destiempoar=destiempoar+data.destiempo_a;
            TotalGlobal.total=TotalGlobal.total+data.total;
            TotalGlobal.pendiente=TotalGlobal.pendiente+data.pendiente;
            TotalGlobal.atendido=TotalGlobal.atendido+data.atendido;
            TotalGlobal.finalizo=TotalGlobal.finalizo+data.finalizo;
            TotalGlobal.destiempo_p=TotalGlobal.destiempo_p+data.destiempo_p;
            TotalGlobal.destiempo_a=TotalGlobal.destiempo_a+data.destiempo_a;
            html+="<tr class='treegrid-"+pos+" treegrid-parent-"+parent+"' ondblclick='selectTR(this,1)' data-rutaflujoid='"+parametros.ruta_flujo_id+"' data-norden='"+data.norden+"' data-fechaini='"+parametros.fecha_ini+"' data-fechafin='"+parametros.fecha_fin+"' data-length_norden='"+data.norden.length+"' data-pendiente='"+data.pendiente+"' data-atendido='"+data.atendido+"' data-finalizo='"+data.finalizo+"' data-destiempo_p='"+data.destiempo_p+"' data-destiempo_a='"+data.destiempo_a+"'>"+
            //            "<td>"+data.norden+"</td>"+
            "<td><span  data-toggle='tooltip' data-placement='left' title='"+data.detalle+"'>Actividad N° "+data.norden+"</span> - <span style='color:blue;'>("+data.detalle+")</span>"+
            '&nbsp;<button type="button" id="' + data.id + '" onclick="verOrdenTrabajoModal(this.id)"  data-toggle="modal" data-target="#modalOT' + data.id + '" class="btn btn-default btn-xs"><span class="fa fa-list fa-lg" aria-hidden="true"></span> Ordenes de Trabajo</button>'+
            "</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+' / <span  style="color:red;">'+data.destiempo_p+"</span></td>"+
            "<td>"+data.atendido+' / <span  style="color:red;">'+data.destiempo_a+"</span></td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";

        }else{
            pos++;
            //            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            destiempopr=destiempopr+data.destiempo_p;
            destiempoar=destiempoar+data.destiempo_a;
            TotalGlobal.pendiente=TotalGlobal.pendiente+data.pendiente;
            TotalGlobal.atendido=TotalGlobal.atendido+data.atendido;
            TotalGlobal.finalizo=TotalGlobal.finalizo+data.finalizo;
            TotalGlobal.destiempo_p=TotalGlobal.destiempo_p+data.destiempo_p;
            TotalGlobal.destiempo_a=TotalGlobal.destiempo_a+data.destiempo_a;
            html+="<tr class='treegrid-"+pos+" treegrid-parent-"+parent+"' ondblclick='selectTR(this,1)' data-rutaflujoid='"+parametros.ruta_flujo_id+"' data-norden='"+data.norden+"' data-fechaini='"+parametros.fecha_ini+"' data-fechafin='"+parametros.fecha_fin+"' data-length_norden='"+data.norden.length+"' data-pendiente='"+data.pendiente+"' data-atendido='"+data.atendido+"' data-finalizo='"+data.finalizo+"' data-destiempo_p='"+data.destiempo_p+"' data-destiempo_a='"+data.destiempo_a+"'>"+
            //            "<td>"+data.norden+"</td>"+
            "<td><span  data-toggle='tooltip' data-placement='left' title='"+data.detalle+"'>Actividad N° "+data.norden+"</span> - <span style='color:blue;'>("+data.detalle+")</span>"+
            '&nbsp;<button type="button" id="' + data.id + '" onclick="verOrdenTrabajoModal(this.id)"  data-toggle="modal" data-target="#modalOT' + data.id + '" class="btn btn-default btn-xs"><span class="fa fa-list fa-lg" aria-hidden="true"></span> Ordenes de Trabajo</button>'+
            "</td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+' / <span  style="color:red;">'+data.destiempo_p+"</span></td>"+
            "<td>"+data.atendido+' / <span  style="color:red;">'+data.destiempo_a+"</span></td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
        }
        
        if(data.cant_flujo>0){
            var dataG = [];
            var conexionG=[];
            var length_norden=(data.norden.length)+3;
            var indice=data.norden.length;
            dataG = {indice:indice,length_norden:length_norden,ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,fecha_ini: parametros.fecha_ini,fecha_fin: parametros.fecha_fin,norden:data.norden};
            conexionG={pos:pos,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,fecha_ini: parametros.fecha_ini,fecha_fin: parametros.fecha_fin};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);
            html+=detalle.html;
            pos=detalle.pos;
        }
    });
    html = html.replace(/totalr/g, totalr);
    html = html.replace(/pendienter/g, pendienter);
    html = html.replace(/atendidor/g, atendidor);
    html = html.replace(/finalizador/g, finalizador);
    html = html.replace(/destiempopr/g, destiempopr);
    html = html.replace(/destiempoar/g, destiempoar);
    $("#tb_tree").html(html);
    $('#t_tree').treegrid({
        onChange: function() {
            $("#tb_tree #"+$(this).attr("id")+" .oculto").effect("pulsate", { times:1 }, 3000);
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    html='';
    html+="<tr>"+
    "<td>"+TotalGlobal.total+"</td>"+
    "<td>"+TotalGlobal.pendiente+' / <span  style="color:red;">'+TotalGlobal.destiempo_p+"</span></td>"+
    "<td>"+TotalGlobal.finalizo+"</td>";
    html+="</tr>";
    $("#tb_resumen_tree").html(html);
};

HTMLPersonalizadoDetalle=function(datos,conexion){
    var html ='';
    var aux_id=0;
    var pos_2=conexion.pos;
    var parent=0;
    
    var totalr=0;
    var pendienter=0;
    var destiempopr=0;
    var atendidor=0;
    var destiempoar=0;
    var finalizador=0;
    $.each(datos,function(index,data){
        
        if(aux_id!==data.flujo_id){
            if(index>0){
                html = html.replace(/totalr/g, totalr);
                html = html.replace(/pendienter/g, pendienter);
                html = html.replace(/atendidor/g, atendidor);
                html = html.replace(/finalizador/g, finalizador);
                html = html.replace(/destiempopr/g, destiempopr);
                html = html.replace(/destiempoar/g, destiempoar);
            }
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+conexion.pos+"' ondblclick='selectTR(this,0)' id='"+pos_2+"' data-rutaflujoid='"+conexion.ruta_flujo_id+"' data-fechaini='"+conexion.fecha_ini+"' data-fechafin='"+conexion.fecha_fin+"' data-length_norden='"+data.norden.length+"' data-ruta_flujo_id_micro='"+data.ruta_flujo_id_micro+"' data-pendiente='pendienter' data-atendido='atendidor' data-finalizo='finalizador' data-destiempo_p='destiempopr' data-destiempo_a='destiempoar'>";
            html+="<td colspan='2'><b>"+data.flujo+"</b></td>"+
            "<td><b class='oculto'>totalr</b></td>"+
            "<td><b class='oculto'>pendienter / <span style='color:red;'>destiempopr</span></b></td>"+
            "<td><b class='oculto'>atendidor / <span style='color:red;'>destiempoar</span></b></td>"+
            "<td><b class='oculto'>finalizador</b></td>";
            html+="</tr>";
            
            totalr=0;
            pendienter=0;
            atendidor=0;
            finalizador=0;
            destiempopr=0;
            destiempoar=0;
            
            aux_id=data.flujo_id;
            parent=pos_2;
            pos_2++;
            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            destiempopr=destiempopr+data.destiempo_p;
            destiempoar=destiempoar+data.destiempo_a;
            TotalGlobal.pendiente=TotalGlobal.pendiente+data.pendiente;
            TotalGlobal.atendido=TotalGlobal.atendido+data.atendido;
            TotalGlobal.finalizo=TotalGlobal.finalizo+data.finalizo;
            TotalGlobal.destiempo_p=TotalGlobal.destiempo_p+data.destiempo_p;
            TotalGlobal.destiempo_a=TotalGlobal.destiempo_a+data.destiempo_a;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"' ondblclick='selectTR(this,1)' data-length_norden='"+data.norden.length+"' data-rutaflujoid='"+conexion.ruta_flujo_id+"' data-ruta_flujo_id_micro='"+data.ruta_flujo_id_micro+"' data-norden='"+data.norden+"' data-fechaini='"+conexion.fecha_ini+"' data-fechafin='"+conexion.fecha_fin+"' data-pendiente='"+data.pendiente+"' data-atendido='"+data.atendido+"' data-finalizo='"+data.finalizo+"' data-destiempo_p='"+data.destiempo_p+"' data-destiempo_a='"+data.destiempo_a+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td><span  data-toggle='tooltip' data-placement='left' title='"+data.detalle+"'>Actividad N° "+data.norden+"</span> - <span style='color:blue;'>("+data.detalle+")</span></td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+' / <span  style="color:red;">'+data.destiempo_p+"</span></td>"+
            "<td>"+data.atendido+' / <span  style="color:red;">'+data.destiempo_a+"</span></td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
       
        }else{
            pos_2++;
//            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            destiempopr=destiempopr+data.destiempo_p;
            destiempoar=destiempoar+data.destiempo_a;
            TotalGlobal.pendiente=TotalGlobal.pendiente+data.pendiente;
            TotalGlobal.atendido=TotalGlobal.atendido+data.atendido;
            TotalGlobal.finalizo=TotalGlobal.finalizo+data.finalizo;
            TotalGlobal.destiempo_p=TotalGlobal.destiempo_p+data.destiempo_p;
            TotalGlobal.destiempo_a=TotalGlobal.destiempo_a+data.destiempo_a;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"' ondblclick='selectTR(this,1)' data-length_norden='"+data.norden.length+"' data-rutaflujoid='"+conexion.ruta_flujo_id+"' data-ruta_flujo_id_micro='"+data.ruta_flujo_id_micro+"' data-norden='"+data.norden+"' data-fechaini='"+conexion.fecha_ini+"' data-fechafin='"+conexion.fecha_fin+"' data-pendiente='"+data.pendiente+"' data-atendido='"+data.atendido+"' data-finalizo='"+data.finalizo+"' data-destiempo_p='"+data.destiempo_p+"' data-destiempo_a='"+data.destiempo_a+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td><span  data-toggle='tooltip' data-placement='left' title='"+data.detalle+"'>Actividad N° "+data.norden+"</span> - <span style='color:blue;'>("+data.detalle+")</span></td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+' / <span  style="color:red;">'+data.destiempo_p+"</span></td>"+
            "<td>"+data.atendido+' / <span  style="color:red;">'+data.destiempo_a+"</span></td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";
        }
                    
        if(data.cant_flujo>0){
            var dataG = [];
            var conexionG=[];
            var length_norden=(data.norden.length)+3;
            var indice=data.norden.length;
            dataG = {indice:indice,length_norden:length_norden,ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: conexion.ruta_flujo_id, fechames: conexion.fechames,fecha_ini: conexion.fecha_ini,fecha_fin: conexion.fecha_fin,norden:data.norden};
            conexionG={pos:pos_2,ruta_flujo_id: conexion.ruta_flujo_id, fechames: conexion.fechames,fecha_ini: conexion.fecha_ini,fecha_fin: conexion.fecha_fin};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);
            html+=detalle.html;
            pos_2=detalle.pos;
        }

    });
    html = html.replace(/totalr/g, totalr);
    html = html.replace(/pendienter/g, pendienter);
    html = html.replace(/atendidor/g, atendidor);
    html = html.replace(/finalizador/g, finalizador);
    html = html.replace(/destiempopr/g, destiempopr);
    html = html.replace(/destiempoar/g, destiempoar);
    returnG={html:html,pos:pos_2};
    return returnG;
};

daysInMonth=function(humanMonth, year){
  return new Date(year || new Date().getFullYear(), humanMonth, 0).getDate();
};


verOrdenTrabajoModal = function(id) {
        
        $.ajax({
                url: 'reporte/verordenestrabajo',
                type:'POST',
                cache       : false,
                dataType    : 'json',
                data        : { ruta_detalle_id:id },
                success: function(obj)
                {
                    datos = obj.datos;
                    var html_pd = '';

                    $.each(datos, function (index, data) {
                        //var d_foto = data.archivo;
                                html_pd += '<tr class="cabecera">'+
                                                  '<th>'+data.personal+'</th>'+
                                                  '<th>'+data.actividad+'</th>'+
                                                  '<th>'+data.fecha_inicio+'</th>'+
                                                  '<th>'+data.dtiempo_final+'</th>'+
                                                '</tr>';
                    });
                    $(".tb_orden_trabajo").html(html_pd);       
                },
                error: function(jqXHR, textStatus, error)
                {
                  console.log(jqXHR.responseText);
                }
            });
                
        var html_modal = '<div class="modal fade" id="modalOT'+id+'" role="dialog">'+
                                          '<div class="modal-dialog modal-md">'+
                                            '<div class="modal-content">'+
                                              '<div class="modal-header" style="padding: 7px;">'+
                                                '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                                '<h4 class="modal-title text-center">ORDENES DE TRABAJO</h4>'+
                                              '</div>'+
                                              '<div class="modal-body" style="overflow: hidden;">'+
                                                  '<div id="d_ver_ot" class="col-md-12 box-body table-responsive no-padding" style="border: 1px solid #CCC">'+
                                                      '<table id="TableProveedor" class="table table-bordered table-hover">'+
                                                        '<thead>'+
                                                            '<tr class="cabecera">'+
                                                              '<th>Personal</th>'+
                                                              '<th>Actividad</th>'+
                                                              '<th>Fecha Inicio</th>'+
                                                              '<th>Fecha Final</th>'+
                                                            '</tr>'+
                                                        '</thead>'+
                                                        '<tbody class="tb_orden_trabajo">'+
                                                        '</tbody>'+
                                                        '<tfoot>'+
                                                            '<tr class="cabecera">'+
                                                              '<th>Personal</th>'+
                                                              '<th>Actividad</th>'+
                                                              '<th>Fecha Inicio</th>'+
                                                              '<th>Fecha Final</th>'+
                                                            '</tr>'+
                                                        '</tfoot>'+
                                                      '</table>'
                                                  '</div>'+
                                              '</div>'+
                                              '<div class="modal-footer" style="padding: 7px;">'+
                                                '<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>'+
                                              '</div>'+
                                            '</div>'+
                                          '</div>'+
                                        '</div>'+
                                      '</div>';

        $('#div_ver_orden_trabajo').html(html_modal);
    }

</script>
