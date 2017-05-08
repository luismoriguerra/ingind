<script type="text/javascript">
$(document).ready(function() {
    
});

expedienteUnico = function(rd_id){
    $("#expedienteModal").modal('show');
    if(rd_id){
        Expediente.ExpedienteUnico({'ruta_id':rd_id},HTMLExpedienteUnico);
    }else{
        alert('Error');
    }
}

function HTMLExpedienteUnico(data){
    if(data.length > 0){
        var html ='';
        var cont = 0;
        var last_ref = 0;
        $.each(data,function(index, el) {
            cont+=1;
            parent = 0;child = 1;

            if(el.tipo=='r'){
                last_ref = cont;
            }
            else if(el.tipo == 's'){
                parent = last_ref;
                child = 2;
            }

            referido = (el.referido !=null) ? el.referido : '';
            fhora = (el.fecha_hora !=null) ? el.fecha_hora : '';
            proc =(el.proceso !=null) ? el.proceso : '';
            area =(el.area !=null) ? el.area : '';
            nord =(el.norden !=null) ? el.norden : '';

            html+="<tr data-id="+cont+" data-parent="+parent+" data-level="+child+">";
            html+=    "<td data-column=name>"+referido+"</td>";
            html+=    "<td>"+fhora+"</td>";
            html+=    "<td>"+proc+"</td>";
            html+=    "<td>"+area+"</td>";
            html+=    "<td>"+nord+"</td>";
            html+="</tr>";            
        });
        $("#tb_tretable").html(html);


        /*tree-table*/
        $(function () {
            var $table = $('#tree-table'),
            rows = $table.find('tr');

            rows.each(function (index, row) {
                var
                    $row = $(row),
                    level = $row.data('level'),
                    id = $row.data('id'),
                    $columnName = $row.find('td[data-column="name"]'),
                    children = $table.find('tr[data-parent="' + id + '"]');

                if (children.length) {
                    var expander = $columnName.prepend('' +
                        '<span class="treegrid-expander glyphicon glyphicon-chevron-right"></span>' +
                        '');

                    children.hide();

                    expander.on('click', function (e) {
                        var $target = $(e.target);
                        if ($target.hasClass('glyphicon-chevron-right')) {
                            $target
                                .removeClass('glyphicon-chevron-right')
                                .addClass('glyphicon-chevron-down');

                            children.show();
                        } else {
                            $target
                                .removeClass('glyphicon-chevron-down')
                                .addClass('glyphicon-chevron-right');

                            reverseHide($table, $row);
                        }
                    });
                }

                $columnName.prepend('' +
                    '<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
                    ''
                );
            });

            reverseHide = function (table, element) {
                var
                    $element = $(element),
                    id = $element.data('id'),
                    children = table.find('tr[data-parent="' + id + '"]');

                if (children.length) {
                    children.each(function (i, e) {
                        reverseHide(table, e);
                    });

                    $element
                        .find('.glyphicon-chevron-down')
                        .removeClass('glyphicon-chevron-down')
                        .addClass('glyphicon-chevron-right');

                    children.hide();
                }
            };
        });
    /*end tree-table*/

    }
    else{
        alert('no hay expediente unico');
    }
}

</script>
