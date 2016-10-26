<div id="newMessageModal" class="modal fade">
    <div class="modal-dialog">
        <form v-on:submit.prevent='sendConversation(this)'>
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
                     --}}
                    <select v-model="users" id="users" name="users[]" multiple class="form-control">
                        <option>Debe escoger una area primero</option>
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('body', 'Mensaje') }}
                    <textarea v-model="body" rows="6" class="form-control" name="body" cols="50" id="body"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {{ Form::submit('Enviar', array('class' => 'btn btn-danger')) }}
            </div>
        </div>
        </form>
    </div>
</div>
<style type="text/css">
    .boldoption { font-weight: bold; }
</style>
