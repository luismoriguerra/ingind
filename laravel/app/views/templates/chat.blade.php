@extends('layouts/main')

@section('body')
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/chat">Chat</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="img-circle" width="30" height="30" src="img/user/{{ md5('u'.Auth::user()->id).'/'.Auth::user()->imagen }}"  alt="User Image" />

                            {{ Auth::user()->full_name }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Home</a></li>

                            <li class="divider"></li>
                            <li><a href="{{ action('AuthController@logout') }}">Cerrar  sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" id="chat">
        <div class="row">
            <div class="col-lg-3 new-message text-right">
                <a id="btnNewMessage" class="btn btn-sm btn-default" role="button"><i class="fa fa-plus"></i> Nuevo mensaje</a>
            </div>	        
        </div>
        <div class="row">
            <div id="conversationList">
                @include('templates/conversations', array('conversations' => $conversations, 'current_conversation' => $current_conversation))
            </div>
            <div class="col-lg-8">
                @if($current_conversation)
                    <div class="panel panel-default">
                        <div id="messageList" class="panel-body messages-panel">
                            @include('templates/messages', array('messages' => $current_conversation->messages))
                        </div>
                    </div>
                    {{ Form::open(array('action' => 'MessageController@store')) }}
                        <textarea id="messageBox" class="form-control send-message" rows="3" placeholder="Escribe una respuesta..."></textarea>
                        <div class="send-message">
                            <a id="btnSendMessage" class="text-right btn btn-sm btn-danger pull-right" role="button"><i class="fa fa-send"></i> Enviar mensaje</a>
                        </div>
                    {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        var 
            current_conversation = "{{ Session::get('current_conversation') }}",
            user_id   = "{{ Auth::user()->id }}";
        var vm = new Vue({
            http: {
                root: '/root'
            },
            el: '#chat',
            data: {
                usuarioSession:[]
            },
            ready: function () {
                //this.doSomething('dHnqtGQosAcKVhL6e0lVsUGzrjRKZf');
                $('#areas').change(function(){
                    vm.getUsuarioSession($(this).val());
                });
                this.conversations = {{ json_encode($conversations) }};
            },
            methods: {
                /*doSomething: function (conversationName) {
                    this.$http.get('/chat?conversation='+conversationName, function (data) {
                        this.$set('messages', data);
                        this.messages=data;
                    });
                },*/
                getArea: function (area_id){
                    this.$http.get("/areas/"+area_id+"/users",function(data) {
                        $('#users').empty();
                        $.each(data, function(key, element) {
                            if (vm.usuarioSession.indexOf( key )>=0) {
                                $('#users').append("<option class='boldoption' value='" + key + "'>" + element + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&bull;)</option>");
                            } else {
                                $('#users').append("<option value='" + key + "'>" + element + "</option>");
                            }
                        });
                    });
                },
                getUsuarioSession: function(area_id){
                    this.$http.post("/usuario/consession",function(data) {
                        vm.usuarioSession=data.split(",")
                        this.getArea(area_id);
                    });
                }
            }
        });
    </script>
    <script src="{{ asset('/js/chat.js')}}"></script>
@stop

@include('templates/new_message_modal', array('areas' => $areas))
