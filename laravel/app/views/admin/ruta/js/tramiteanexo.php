<script type="text/javascript">
temporalBandeja=0;
valposg=0;
var areasG=[]; // texto area
var areasGId=[]; // id area
var theadArea=[]; // cabecera area
var tbodyArea=[]; // cuerpo area
var tfootArea=[]; // pie area

var tiempoGId=[]; // id posicion del modal en base a una area.
var tiempoG=[];
var verboG=[];
var posicionDetalleVerboG=0;

var RolIdG='';
var UsuarioId='';
var fechaAux="";
$(document).ready(function() {
    /*Inicializar tramites*/
    var data={estado:1};
    Bandeja.MostrarTramites(data,HTMLTramites);
    /*end Inicializar tramites*/
});

HTMLTramites = function(data){
    if(data){
        var html ='';
        $.each(data,function(index, el) {
            html+="<tr id-tramite="+el.id+" onClick='seleccionado(this),mostrarAnexos(this)'>"+
                "<td>"+el.id_union +"</td>"+
                "<td>"+el.proceso+"</td>"+
                "<td>"+el.fecha_inicio+"</td>"+
                "<td>"+el.persona+"</td>"+
                "<td>"+el.estado_ruta+"</td>"+
                "<td>"+el.norden+"</td>"+
                "<td><span class='btn btn-primary btn-sm' data-toggle='modal' data-target='#anexos'>Listar</span></td>"+
                "<td><span class='btn btn-primary btn-sm' data-toggle='modal' data-target='#estadoTramite'>Listar</span></td>"+
            "</tr>";            
        });
        $("#tb_reporte").html(html);
        $("#t_reporte").dataTable(
            {
                "order": [[ 0, "asc" ],[1, "asc"]],
            }
        ); 
        $("#t_reporte").show();
    }else{
        alert('no hay nada');
    }
}

seleccionado = function(obj){
    if(obj){
        var tr = document.querySelectorAll("#t_reporte tr");
        for (var i = 0; i < tr.length; i++) {
            tr[i].setAttribute("style","background-color:#f9f9f9;");
        }
        obj.setAttribute("style","background-color:#9CD9DE;");
    }
}

mostrarAnexos = function(obj){
    var div = document.querySelector(".anexo");
    div.classList.remove("hidden");
    var idtramite = obj.getAttribute("id-tramite");
    var data={'idtramite':idtramite};
    Bandeja.MostrarAnexos(data);
}
   
</script>
