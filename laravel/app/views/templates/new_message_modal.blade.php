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
