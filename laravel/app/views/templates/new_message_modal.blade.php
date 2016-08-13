{{ HTML::script('lib/jquery-2.1.3.min.js') }}
<div id="newMessageModal" class="modal fade">
    <div class="modal-dialog">
        {{ Form::open( array('action' => 'ConversationController@store')) }}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Mensaje</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('areas', 'Area') }}
                    {{ Form::select('areas[]', $areas, null, array("id"=>"areas","class" => "form-control")) }}

                    {{ Form::label('users', 'Usuario') }}
                    {{-- {{ Form::select('users[]', $recipients, null, array("id"=>"users","multiple" => "multiple", "class" => "form-control")) }}
                     --}}<select id="users" name="users[]" multiple class="form-control">
                        <option>Debe escoger una area primero</option>
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('body', 'Mensaje') }}
                    {{ Form::textarea('body', null, array("rows" => "6", "class" => "form-control")) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {{ Form::submit('Enviar', array('class' => 'btn btn-danger')) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
<style type="text/css">
    .boldoption { font-weight: bold; }
</style>
<script>
    $(document).ready(function(){
        var usuarioSession = [];
        $('#areas').change(function(){
            var area_id=$(this).val();
            $.post("usuario/consession",function(data) {
                //usuarioSession=data;
                usuarioSession=data.split(",")
                //usuarios segun areas
                $.get("areas/"+area_id+"/users",function(data) {
                    $('#users').empty();
                    $.each(data, function(key, element) {
                        //validar con session
                        if (usuarioSession.indexOf( key )>=0) {
                            $('#users').append("<option class='boldoption' value='" + key + "'>" + element + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&bull;)</option>");
                        } else {
                            $('#users').append("<option value='" + key + "'>" + element + "</option>");
                        }
                    });
                });
            });
        });
    });
</script>