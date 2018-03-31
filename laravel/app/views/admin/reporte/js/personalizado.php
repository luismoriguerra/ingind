<script type="text/javascript">

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
	grey: 'rgb(201, 203, 207)'
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

selectTR=function(boton){
    
    var tr = boton;
    var trs = tr.parentNode.children;
    for (var i = 0; i < trs.length; i++)
        trs[i].style.backgroundColor = "#f9f9f9";
    tr.style.backgroundColor = "#9CD9DE";
    var dataG={fechames:$(boton).data("fechames"),ruta_flujo_id:$(boton).data("rutaflujoid"),norden:$(boton).data("norden")};
    Personalizado.GraficoData(dataG);
};

HTMLPersonalizado=function(datos,parametros){
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
                html = html.replace("totalr", totalr);
                html = html.replace("pendienter", pendienter);
                html = html.replace("atendidor", atendidor);
                html = html.replace("finalizador", finalizador);
                html = html.replace("destiempopr", destiempopr);
                html = html.replace("destiempoar", destiempoar);
            }
            pos++;
            html+="<tr class='treegrid-"+pos+"' onClick='selectTR(this)' id='"+pos+"'>";
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
            html+="<tr class='treegrid-"+pos+" treegrid-parent-"+parent+"' onClick='selectTR(this)' data-rutaflujoid='"+parametros.ruta_flujo_id+"' data-norden='"+data.norden+"' data-fechames='"+parametros.fechames+"'>"+
//            "<td>"+data.norden+"</td>"+
            "<td><span  data-toggle='tooltip' data-placement='left' title='"+data.detalle+"'>Actividad N° "+data.norden+"</span> - <span style='color:blue;'>("+data.detalle+")</span></td>"+
            "<td>"+data.area+"</td>"+
            "<td>"+data.total+"</td>"+
            "<td>"+data.pendiente+' / <span  style="color:red;">'+data.destiempo_p+"</span></td>"+
            "<td>"+data.atendido+' / <span  style="color:red;">'+data.destiempo_a+"</span></td>"+
            "<td>"+data.finalizo+"</td>";
            html+="</tr>";

        }else{
            pos++;
            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            destiempopr=destiempopr+data.destiempo_p;
            destiempoar=destiempoar+data.destiempo_a;
            html+="<tr class='treegrid-"+pos+" treegrid-parent-"+parent+"' onClick='selectTR(this)' data-rutaflujoid='"+parametros.ruta_flujo_id+"' data-norden='"+data.norden+"' data-fechames='"+parametros.fechames+"'>"+
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
            dataG = {indice:indice,length_norden:length_norden,ruta_flujo_id_dep:data.ruta_flujo_id_dep,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,fecha_ini: parametros.fecha_ini,fecha_fin: parametros.fecha_fin,norden:data.norden};
            conexionG={pos:pos,ruta_flujo_id: parametros.ruta_flujo_id, fechames: parametros.fechames,fecha_ini: parametros.fecha_ini,fecha_fin: parametros.fecha_fin};
            detalle=Personalizado.ReportePersonalizadoDetalle(dataG,conexionG);
            html+=detalle.html;
            pos=detalle.pos;
        }
    });
    html = html.replace("totalr", totalr);
    html = html.replace("pendienter", pendienter);
    html = html.replace("atendidor", atendidor);
    html = html.replace("finalizador", finalizador);
    html = html.replace("destiempopr", destiempopr);
    html = html.replace("destiempoar", destiempoar);
    $("#tb_tree").html(html);
    $('#t_tree').treegrid({
        onChange: function() {
            $("#tb_tree #"+$(this).attr("id")+" .oculto").effect("pulsate", { times:1 }, 3000);
        }
    });
    $('[data-toggle="tooltip"]').tooltip();   

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
                html = html.replace("totalr", totalr);
                html = html.replace("pendienter", pendienter);
                html = html.replace("atendidor", atendidor);
                html = html.replace("finalizador", finalizador);
                html = html.replace("destiempopr", destiempopr);
                html = html.replace("destiempoar", destiempoar);
            }
            pos_2++;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+conexion.pos+"' onClick='selectTR(this)' id='"+pos_2+"'>";
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
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"' onClick='selectTR(this)' data-rutaflujoid='"+conexion.ruta_flujo_id+"' data-norden='"+data.norden+"' data-fechames='"+conexion.fechames+"'>"+
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
            totalr=totalr+data.total;
            pendienter=pendienter+data.pendiente;
            atendidor=atendidor+data.atendido;
            finalizador=finalizador+data.finalizo;
            destiempopr=destiempopr+data.destiempo_p;
            destiempoar=destiempoar+data.destiempo_a;
            html+="<tr class='treegrid-"+pos_2+" treegrid-parent-"+parent+"' onClick='selectTR(this)' data-rutaflujoid='"+conexion.ruta_flujo_id+"' data-norden='"+data.norden+"' data-fechames='"+conexion.fechames+"'>"+
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
    html = html.replace("totalr", totalr);
    html = html.replace("pendienter", pendienter);
    html = html.replace("atendidor", atendidor);
    html = html.replace("finalizador", finalizador);
    html = html.replace("destiempopr", destiempopr);
    html = html.replace("destiempoar", destiempoar);
    returnG={html:html,pos:pos_2};
    return returnG;
};

</script>
