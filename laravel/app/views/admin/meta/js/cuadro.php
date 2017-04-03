<script type="text/javascript">
$(document).ready(function() {
    
    var datos={estado:1};
    slctGlobal.listarSlctFuncion('metacuadro','listarmeta','slct_meta','multiple',null,datos);

    $("#generar_area").click(function (){
        meta = $('#slct_meta').val();
        if ($.trim(meta)!=='') {
            data = {meta:meta};
            Usuario.mostrar(data);
        } else {
            alert("Seleccione Metas");
        }
    });
    
     $(document).on('click', '.btnDelete', function(event) {
        $(this).parent().parent().remove();
    }); 
    
    $('#listDocDigital').on('show.bs.modal', function (event) {
     	var button = $(event.relatedTarget); // captura al boton
	    var text = $.trim( button.data('texto') );
	    var id= $.trim( button.data('id') );
	    var camposP = {'nombre':text,'id':id};
        Usuario.Cargar(HTMLCargar,camposP);
    });

});
var ap=0;
AgregarAP = function(cont1,avance_id){
  ap++;
  var html='';
          html+="<tr>"+
             "<td>#"+
             "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='4'>"+
             "<input type='hidden' name='avance_id[]' id='avance_id' value='"+avance_id+"'></td></td> "+
            "<td>";
          html+='<input type="text"  readOnly class="form-control input-sm" id="pago_nombre'+ap+'""  name="pago_nombre[]" value="">'+
                    '<input type="text" style="display: none;" id="pago_archivo'+ap+'" name="pago_archivo[]">'+
                    '<label class="btn bg-olive btn-flat margin btn-xs">'+
                        '<i class="fa fa-file-pdf-o fa-lg"></i>'+
                        '<i class="fa fa-file-word-o fa-lg"></i>'+
                        '<i class="fa fa-file-image-o fa-lg"></i>'+
                        '<input type="file" style="display: none;" onchange="onPagos(event,'+ap+');" >'+
                    '</label>';
         html+="</td>"+
            '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        
  $("#t_aparchivo"+cont1).append(html);
  
};
var ad=0;
AgregarD = function(cont2,avance_id){
  ad++;
  var html='';
          html+="<tr>"+
             "<td>#"+
             "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='3'>"+
             "<input type='hidden' name='avance_id[]' id='avance_id' value='"+avance_id+"'></td></td> "+
            "<td>";
          html+='<input type="text"  readOnly class="form-control input-sm" id="pago_nombre'+ad+'""  name="pago_nombre[]" value="">'+
                    '<input type="text" style="display: none;" id="pago_archivo'+ad+'" name="pago_archivo[]">'+
                    '<label class="btn bg-olive btn-flat margin btn-xs">'+
                        '<i class="fa fa-file-pdf-o fa-lg"></i>'+
                        '<i class="fa fa-file-word-o fa-lg"></i>'+
                        '<i class="fa fa-file-image-o fa-lg"></i>'+
                        '<input type="file" style="display: none;" onchange="onPagos(event,'+ad+');" >'+
                    '</label>';
         html+="</td>"+
            '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        
  $("#t_darchivo"+cont2).append(html);
  
};

var aa=0;
AgregarA = function(cont3,avance_id){
  aa++;
  var html='';
          html+="<tr>"+
             "<td>#"+
             "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='2'>"+
             "<input type='hidden' name='avance_id[]' id='avance_id' value='"+avance_id+"'></td></td> "+
            "<td>";
          html+='<input type="text"  readOnly class="form-control input-sm" id="pago_nombre'+aa+'""  name="pago_nombre[]" value="">'+
                    '<input type="text" style="display: none;" id="pago_archivo'+aa+'" name="pago_archivo[]">'+
                    '<label class="btn bg-olive btn-flat margin btn-xs">'+
                        '<i class="fa fa-file-pdf-o fa-lg"></i>'+
                        '<i class="fa fa-file-word-o fa-lg"></i>'+
                        '<i class="fa fa-file-image-o fa-lg"></i>'+
                        '<input type="file" style="display: none;" onchange="onPagos(event,'+aa+');" >'+
                    '</label>';
         html+="</td>"+
            '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        
  $("#t_aarchivo"+cont3).append(html);
  
};
var am=0;
AgregarM = function(cont4,avance_id){
    am++;
  var html='';
          html+="<tr>"+
             "<td>#"+
             "<input type='hidden' name='tipo_avance[]' id='tipo_avance' value='1'>"+
             "<input type='hidden' name='avance_id[]' id='avance_id' value='"+avance_id+"'></td></td> "+
            "<td>";
          html+='<input type="text"  readOnly class="form-control input-sm" id="pago_nombre'+am+'""  name="pago_nombre[]" value="">'+
                    '<input type="text" style="display: none;" id="pago_archivo'+am+'" name="pago_archivo[]">'+
                    '<label class="btn bg-olive btn-flat margin btn-xs">'+
                        '<i class="fa fa-file-pdf-o fa-lg"></i>'+
                        '<i class="fa fa-file-word-o fa-lg"></i>'+
                        '<i class="fa fa-file-image-o fa-lg"></i>'+
                        '<input type="file" style="display: none;" onchange="onPagos(event,'+am+');" >'+
                    '</label>';
         html+="</td>"+
            '<td><a id="btnDelete"  name="btnDelete" class="btn btn-danger btn-xs btnDelete">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        
  $("#t_marchivo"+cont4).append(html);
  
};

HTMLreporte=function(datos){
    var html="";
    pos=0; 
    
    n=1;a=1;b=1;c=1;
    n1=1;a1=1;b1=1;c1=1;
    
    aux_meta_id='';
    aux_meta_cuadro_id='';
    aux_id_d='';
    aux_id_p='';
    
    aux_meta_id1='';
    aux_meta_cuadro_id1='';
    aux_id_d1='';
    aux_id_p1='';
    
    cont1=0; cont2=0; cont3=0; cont4=0;
    
    $.each(datos,function(index,data){

        html+='<tr>';
        if(aux_meta_id!==data.meta_id){
         aux_meta_id=data.meta_id;
         if(index>0){
          html= html.replace("rowspann","rowspan='"+n+"'");
         }
         html+='<td rowspann >'+data.nombre+'</td>';
         n=1;
        }
        else { n++;}
        
        if(aux_meta_cuadro_id!==data.meta_cuadro_id){ 
         aux_meta_cuadro_id=data.meta_cuadro_id;
          if(index>0){ 
              html= html.replace("rowspana","rowspan='"+a+"'");
         }
         html+='<td rowspana >'+data.actividad+'</td>'; 
         a=1;
        }
        else { a++;}
        
        if(aux_id_d!==data.id_d){ 
         aux_id_d=data.id_d;
         if(index>0){
             html= html.replace(/rowspanb/g,"rowspan='"+b+"'");
            //  html= html.split('rowspanb').join("rowspan='"+b+"'");
         }
         html+='<td rowspanb >'+data.d+'</td>';
         html+='<td rowspanb >'+data.df+'</td>'; 
         b=1;
        }
        else { b++;}
        
        if(aux_id_p!==data.id_p){ 
        aux_id_p=data.id_p;
         if(index>0){
             html= html.replace(/rowspanc/g,"rowspan='"+c+"'");
         }
        html+='<td rowspanc >'+data.p+'</td>';
        html+='<td rowspanc >'+data.pf+'</td>'; 
        c=1;
        }
        else { c++;}
        
        if(aux_id_p1!==data.id_p){ 
        aux_id_p1=data.id_p;
         if(index>0){
             html= html.replace(/rowspanc1/g,"rowspan='"+c1+"'");
         }
        cont1++;

        html+='<td rowspanc1 >'+
              '<div>'+
              '<form name="form_aparchivo'+cont1+'" id="form_aparchivo'+cont1+'" enctype=”multipart/form-data”>'+
              
               '<table id="t_aparchivo'+cont1+'" class="table table-bordered" >'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>N°</th>'+
                                                '<th>Archivo</th>'+
                                                '<th><a class="btn btn-success btn-xs" title="Agregar Archivo"'+
                                                         'onclick="AgregarAP('+cont1+','+data.id_p+')"><i class="fa fa-plus fa-lg"></i></a></th>'+
                                           ' </tr>'+
                                       ' </thead>'+
                                       ' <tbody id="tb_aparchivo'+cont1+'">';
        if(data.a_p!=null){
        var a_p = data.a_p.split('|');
        var a_p_nombre=a_p[0].split(',');
        var a_p_id=a_p[1].split(',');
        pos_ap=1;
        for(i=0;i<a_p_nombre.length;i++){
        var nombre=a_p_nombre[i].split('/');
        html+="<tr>"+
             "<td>"+pos_ap+"<input type='hidden' name='c_id[]' id='c_id' value='"+a_p_id[i]+"'></td></td> "+
            "<td><a target='_blank' href='file/meta/"+a_p_nombre[i]+"'>"+nombre[1]+"</a></td>"+
            '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\''+a_p_id[i]+'\',\''+nombre[0]+'\',\''+nombre[1]+'\',this)">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        pos_ap++;
        }
        }
      
                                        html+=' </tbody>'+
                                                    '</table>'+
                                                    '</form>'+
                                    '<a class="btn btn-success btn-xs" id="guardar"  style="width: 100%;margin-top:10px;margin-bottom:10px" onClick="Guardar(\'#form_aparchivo'+cont1+'\')">'+
                                    '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar'+
                                '</a>'+
                                '</div>'+
                                
              '<div>'+
              '<form name="form_aparchivo'+cont1+'" id="form_aparchivo'+cont1+'" enctype=”multipart/form-data”>'+
              
               '<table id="t_aparchivo'+cont1+'" class="table table-bordered" >'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>N°</th>'+
                                                '<th>Documento</th>'+
                                                '<th><span class="btn btn-success btn-xs" data-toggle="modal" data-target="#listDocDigital" id="btn_list_digital" data-texto="txt_codigo" data-id="txt_doc_digital_id">'+
                                                                '<i class="glyphicon glyphicon-file"></i>'+
                                                            '</span></th>'+
                                           ' </tr>'+
                                       ' </thead>'+
                                       ' <tbody id="tb_aparchivo'+cont1+'">';
        if(data.d_p!=null){
        var d_p = data.d_p.split('|');
        var d_p_nombre=d_p[0].split(',');
        var d_p_id=d_p[1].split(',');
        pos_ap=1;
        for(i=0;i<d_p_nombre.length;i++){

        html+="<tr>"+
             "<td>"+pos_ap+"<input type='hidden' name='c_id[]' id='c_id' value='"+d_p_id[i]+"'></td></td> "+
            "<td>"+d_p_nombre[i]+"</td>"+
            '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\''+d_p_id[i]+'\',\''+nombre[0]+'\',\''+nombre[1]+'\',this)">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        pos_ap++;
        }
        }
      
                                        html+=' </tbody>'+
                                                    '</table>'+
                                                    '</form>'+
                                    '<a class="btn btn-success btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="Guardar(\'#form_aparchivo'+cont1+'\')">'+
                                    '<i class="fa fa-save fa-lg"></i>&nbsp;Guardar'+
                                '</a>'+
                                '</div>'+
                                                    '</td>';
        
        c1=1;
        }
        else { c1++;}
        
        if(aux_id_d1!==data.id_d){ 
         aux_id_d1=data.id_d;
         if(index>0){
             html= html.replace(/rowspanb1/g,"rowspan='"+b1+"'");
         }
         cont2++;
         html+='<td rowspanb1 >'+
                             '<form name="form_darchivo'+cont2+'" id="form_darchivo'+cont2+'" enctype=”multipart/form-data”>'+
               '<table id="t_darchivo'+cont2+'" class="table table-bordered">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>N°</th>'+
                                                '<th>Archivo</th>'+
                                                '<th><a class="btn btn-success btn-xs"'+
                                                         'onclick="AgregarD('+cont2+','+data.id_d+')"><i class="fa fa-plus fa-lg"></i></a></th>'+
                                           ' </tr>'+
                                       ' </thead>'+
                                       ' <tbody id="tb_darchivo'+cont2+'">';

        if(data.a_d!=null){
        var a_d = data.a_d.split('|');
        var a_d_nombre=a_d[0].split(',');
        var a_d_id=a_d[1].split(',');
        pos_ad=1;
        for(i=0;i<a_d_nombre.length;i++){
        var nombre=a_d_nombre[i].split('/');
        html+="<tr>"+
             "<td>"+pos_ad+"<input type='hidden' name='c_id[]' id='c_id' value='"+a_d_id[i]+"'></td></td> "+
            "<td><a target='_blank' href='file/meta/"+a_d_nombre[i]+"'>"+nombre[1]+"</a></td>"+
            '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\''+a_d_id[i]+'\',\''+nombre[0]+'\',\''+nombre[1]+'\',this)">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        pos_ad++;
        }
        }
                                        html+=' </tbody>'+
                                                    '</table>'+
                                                    '</form>'+
                                    '<a class="btn btn-success btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="Guardar(\'#form_darchivo'+cont2+'\')">'+
                                    '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar'+
                                '</a>'+                                      

                                                    '</td>';

         b1=1;
        }
        else { b1++;}
        
        if(aux_meta_cuadro_id1!==data.meta_cuadro_id){ 
         aux_meta_cuadro_id1=data.meta_cuadro_id;
          if(index>0){ 
              html= html.replace("rowspana1","rowspan='"+a1+"'");
         }
         cont3++;
         html+='<td rowspana1 >'+
                '<form name="form_aarchivo'+cont3+'" id="form_aarchivo'+cont3+'" enctype=”multipart/form-data”>'+
               '<table id="t_aarchivo'+cont3+'" class="table table-bordered">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>N°</th>'+
                                                '<th>Archivo</th>'+
                                                '<th><a class="btn btn-success btn-xs"'+
                                                         'onclick="AgregarA('+cont3+','+data.meta_cuadro_id+')"><i class="fa fa-plus fa-lg"></i></a></th>'+
                                           ' </tr>'+
                                       ' </thead>'+
                                       ' <tbody id="tb_aarchivo'+cont3+'">';
        if(data.a_a!=null){
        var a_a = data.a_a.split('|');
        var a_a_nombre=a_a[0].split(',');
        var a_a_id=a_a[1].split(',');
        pos_aa=1;
        for(i=0;i<a_a_nombre.length;i++){
         var nombre=a_a_nombre[i].split('/');
        html+="<tr>"+
             "<td>"+pos_aa+"<input type='hidden' name='c_id[]' id='c_id' value='"+a_a_id[i]+"'></td></td> "+
            "<td><a target='_blank' href='file/meta/"+a_a_nombre[i]+"'>"+nombre[1]+"</a></td>"+
            '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\''+a_a_id[i]+'\',\''+nombre[0]+'\',\''+nombre[1]+'\',this)">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        pos_aa++;
        }
        }
                                        html+=' </tbody>'+
                                                    '</table>'+
                                                    '</form>'+
                                    '<a class="btn btn-success btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="Guardar(\'#form_aarchivo'+cont3+'\')">'+
                                    '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar'+
                                '</a>'+                                      
                                                    '</td>';
         a1=1;
        }
        else { a1++;}
        
        if(aux_meta_id1!==data.meta_id){
         aux_meta_id1=data.meta_id;
         if(index>0){
          html= html.replace("rowspann1","rowspan='"+n1+"'");
         }
         cont4++;
         html+='<td rowspann1 >'+
                                 '<form name="form_marchivo'+cont4+'" id="form_marchivo'+cont4+'" enctype=”multipart/form-data”>'+
               '<table id="t_marchivo'+cont4+'" class="table table-bordered">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>N°</th>'+
                                                '<th>Archivo</th>'+
                                                '<th><a class="btn btn-success btn-xs"'+
                                                         'onclick="AgregarM('+cont4+','+data.meta_id+')"><i class="fa fa-plus fa-lg"></i></a></th>'+
                                           ' </tr>'+
                                       ' </thead>'+
                                       ' <tbody id="tb_marchivo'+cont4+'">';
        if(data.a_m!=null){
        var a_m = data.a_m.split('|');
        var a_m_nombre=a_m[0].split(',');
        var a_m_id=a_m[1].split(',');
        pos_am=1;
        for(i=0;i<a_m_nombre.length;i++){
        var nombre=a_m_nombre[i].split('/');
        html+="<tr>"+
             "<td>"+pos_am+"<input type='hidden' name='c_id[]' id='c_id' value='"+a_m_id[i]+"'></td></td> "+
            "<td><a target='_blank' href='file/meta/"+a_m_nombre[i]+"'>"+nombre[1]+"</a></td>"+
            '<td><a id="c_Delete"  name="c_Delete" class="btn btn-danger btn-xs" onClick="Eliminar(\''+a_m_id[i]+'\',\''+nombre[0]+'\',\''+nombre[1]+'\',this)">'+
                                          '<i class="fa fa-trash fa-lg"></i>'+
                                        '</a></td>';
        html+="</tr>";
        pos_am++;
        }
        }
                                        html+=' </tbody>'+
                                                    '</table>'+
                                                    '</form>'+
                                    '<a class="btn btn-success btn-xs" id="guardar"  style="width: 100%;margin-top:10px" onClick="Guardar(\'#form_marchivo'+cont4+'\')">'+
                                    '<i class="fa fa-save fa-lg">    </i>&nbsp;Guardar'+
                                '</a>'+                                      
                                                    '</td>';
         n1=1;
        }
        else { n1++;}
        html+='</tr>';

    });
    html= html.replace("rowspann","rowspan='"+n+"'");
    html= html.replace("rowspana","rowspan='"+a+"'");
    html= html.replace(/rowspanb/g,"rowspan='"+b+"'");
    html= html.replace(/rowspanc/g,"rowspan='"+c+"'");
    
    html= html.replace(/rowspanc1/g,"rowspan='"+c1+"'");
    html= html.replace(/rowspanb1/g,"rowspan='"+b1+"'");
    html= html.replace("rowspana1","rowspan='"+a1+"'");
    html= html.replace("rowspann1","rowspan='"+n+"'");

    $("#tb_reporte").html(html); 
    $("#reporte").show(); 
};


ActPest=function(nro){
    Pest=nro;
};

activarTabla=function(){
    $("#t_detalles").dataTable(); // inicializo el datatable    
};
eventoSlctGlobalSimple=function(slct,valores){
};

Guardar=function(form){
    var datos=$(form).serialize().split("txt_").join("").split("slct_").join("");
    Usuario.Crear(datos);
};

Eliminar=function(id,carpeta,nombre,tr){

     var datos={id:id,carpeta:carpeta,nombre:nombre};
     var c= confirm("¿Está seguro de Eliminar el archivo?");
     if(c){$(tr).parent().parent().remove();
       Usuario.Eliminar(datos); 
       
     }
    
};

onPagos=function(event,item){
    var files = event.target.files || event.dataTransfer.files;
    if (!files.length)
      return;
    var image = new Image();
    var reader = new FileReader();
    reader.onload = (e) => {
        $('#pago_archivo'+item).val(e.target.result);
    };
    reader.readAsDataURL(files[0]);
    $('#pago_nombre'+item).val(files[0].name);
    console.log(files[0].name);
};
HTMLCargar=function(datos,campos){
	var c_text = campos.nombre;
	var c_id = campos.id;

        console.log(datos);
    var html="";
    $('#t_doc_digital').dataTable().fnDestroy();
    $.each(datos,function(index,data){
        
        if($.trim(data.ruta) == 0 && $.trim(data.rutadetallev) == 0){
            html+="<tr class='danger'>";
        }else{
            html+="<tr class='success'>";
        }
      
        html+="<td>"+data.titulo+"</td>";
        html+="<td>"+data.asunto+"</td>";
        html+="<td>"+data.plantilla+"</td>";
        html+="<td><a class='btn btn-success btn-sm' c_text='"+c_text+"' c_id='"+c_id+"'  id='"+data.id+"' title='"+data.titulo+"' onclick='SelectDocDig(this)'><i class='glyphicon glyphicon-ok'></i> </a></td>";
        if($.trim(data.ruta) != 0  || $.trim(data.rutadetallev) != 0){
            html+="<td><a class='btn btn-primary btn-sm' id='"+data.id+"' onclick='openPrevisualizarPlantilla(this,0)'><i class='fa fa-eye'></i> </a></td>";
        }else{
             html+="<td></td>";
        }
        html+="</tr>";
    });
    $("#tb_doc_digital").html(html);
    $("#t_doc_digital").dataTable();
};

SelectDocDig = function(obj,id){	
	var id = obj.getAttribute('id');
	var nombre = obj.getAttribute('title');
	$("#"+obj.getAttribute('c_text')).val(nombre);
	$("#"+obj.getAttribute('c_id')).val(id);
	$("#listDocDigital").modal('hide');
}

</script>
