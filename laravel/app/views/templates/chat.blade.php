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
                            <img class="img-circle" width="30" height="30" src="{{ Auth::user()->img }}"  alt="User Image" />
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
                <a id="btnNewMessage" @click.prevent="showModal" class="btn btn-sm btn-default" role="button"><i class="fa fa-plus"></i> Nuevo mensaje</a>
            </div>	        
        </div>
        <div class="row">
            <div id="conversationList">
                @include('templates/conversations', array('conversations' => $conversations))
            </div>
            <div class="col-lg-8">
                @if($current_conversation)
                    <div class="panel panel-default">
                        <div id="messageList" class="panel-body messages-panel">
                            @include('templates/messages', array('messages' => $current_conversation->messages))
                        </div>
                    </div>
                    {{ Form::open(array('action' => 'MessageController@store')) }}
                        <textarea @keyup.prevent="handleKeypress" id="messageBox" class="form-control send-message" rows="3" placeholder="Escribe una respuesta..."></textarea>
                        <div class="send-message">
                            <a @click.prevent="sendMessage" class="text-right btn btn-sm btn-danger pull-right" role="button"><i class="fa fa-send"></i> Enviar mensaje</a>
                        </div>
                    {{ Form::close() }}
                @endif
            </div>
        </div>
        @include('templates/new_message_modal', array('areas' => $areas))
    </div>
@stop

@section('scripts')
    <script>
        var user_id   = "{{ Auth::user()->id }}";
        var current_conversation = "{{ Session::get('current_conversation') }}";
        var vm = new Vue({
            http: {
                root: '/root'
            },
            el: '#chat',
            data: {
                areas:[],
                usuarioSession:[],
                conversations:[],
                messages:[],
                current_conversation:[],
                //messageList  : [],
                $conversation : [],
                message      : [],
                user_id : [],
                from_user_id : [],
                conversation : [],
            },
            ready: function () {
                //socket = io('http://ingind:3000');
                socket = io('http://procesos.munindependencia.pe:3000'),
                this.$http.get("/users/" + user_id + '/conversations',function(response) {
                    if(response.success && response.result.length > 0) {
                        $.each(response.result, function(index, conversation) {
                            socket.emit('join', { room:  conversation.name });
                        });
                    }
                });
                socket.on('chat.messages', function(data) {
                    //vm.messageList  = $("#messageList");
                    vm.$conversation = $("#" + data.room);
                    vm.message      = data.message.body;
                    vm.from_user_id = data.message.user_id;
                    vm.conversation = data.room;
                    vm.getMessages(vm.conversation);
                });
                socket.on('chat.conversations', function(data) {
                    var $conversationList = $("#conversationList");
                    vm.getConversations(current_conversation);
                });
                this.chat();
                $('#areas').change(function(){
                    vm.getUsuarioSession($(this).val());
                });
            },
            methods: {
                handleKeypress: function(event) {
                    if (event.keyCode == 13 && event.shiftKey) {
                    } else if (event.keyCode == 13){
                        var $messageBox  = $("#messageBox");
                        if ($messageBox.val().trim()=='') return;
                        this.sendMessage();
                    }
                },
                chat : function (conversation) {
                    data={conversation: conversation };
                    this.$http.post("/chat",data,function(response) {
                        if (response.current_conversation==null) {
                            this.current_conversation = '';
                        } else {
                            this.current_conversation= response.current_conversation.name;
                        }

                        this.conversations= response.conversations;
                        this.messages= response.messages;
                        this.areas= response.areas;
                        this.scrollToBottom();
                    });
                },
                sendMessage: function() {
                    var $messageBox  = $("#messageBox");
                    data=  { 
                        body: $messageBox.val() ,
                        conversation: this.current_conversation,
                        user_id: user_id 
                    };
                    var $messageBox  = $("#messageBox");
                    if ($messageBox.val().trim()=='') return;
                    this.$http.post("/messages",data,function(data) {
                        $("#messageBox").val('');
                        $("#messageBox").focus();
                    });
                },
                getMessages: function(conversation) {
                    data= { conversation: conversation };
                    this.$http.get("/messages",data,function(response) {
                        this.$conversation.find('small').text(this.message);
                        if(this.conversation === this.current_conversation) {
                            this.messages=response.messages;
                            this.scrollToBottom();
                        }
                        if(this.from_user_id !== user_id && this.conversation !== this.current_conversation) {
                            this.updateConversationCounter(this.$conversation);
                        }
                    });
                },
                getConversations: function(current_conversation) {
                    data= { conversation: current_conversation };
                    this.$http.get("/conversations",data,function(response) {
                        this.conversations=response.conversations;
                    });
                },
                sendConversation: function(env){
                    data={
                        body:this.body,
                        users:this.users
                    };
                    this.$http.post("/conversations",data,function(data) {
                        this.getConversations(current_conversation);
                        $('#newMessageModal').modal('hide');
                    });
                },
                getArea: function (area_id){
                    this.$http.get("/areas/"+area_id+"/users",function(data) {
                        $('#users').empty();
                        $.each(data, function(key, element) {
                            if (vm.usuarioSession.indexOf( parseInt(key) )>=0) {
                                $('#users').append("<option class='boldoption' value='" + key + "'>" + element + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&bull;)</option>");
                            } else if (vm.usuarioSession.indexOf( key )>=0) {
                                $('#users').append("<option class='boldoption' value='" + key + "'>" + element + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&bull;)</option>");
                            } else {
                                $('#users').append("<option value='" + key + "'>" + element + "</option>");
                            }
                        });
                    });
                },
                getUsuarioSession: function(area_id){
                    this.$http.post("/usuario/consession",function(data) {
                        if(typeof data == 'number')
                            vm.usuarioSession = [data];
                        else
                            vm.usuarioSession=data.split(",")
                        this.getArea(area_id);
                    });
                },
                updateConversationCounter: function($conversation) {
                    var
                        $badge  = $conversation.find('.badge'),
                        counter = Number($badge .text());

                    if($badge.length) {
                        $badge.text(counter + 1);
                    } else {
                        $conversation.prepend('<span class="badge">1</span>');
                    }
                },
                showModal: function (){
                    $('#newMessageModal').modal('show');
                },
                scrollToBottom: function() {
                    this.handle = setInterval( ( ) => {
                        var $messageList  = $("#messageList");

                        if($messageList.length) {
                            $messageList.animate({scrollTop: $messageList[0].scrollHeight}, 500);
                        }
                        clearInterval(this.handle);
                    },1);
                }
            }
        });
    </script>
@stop
