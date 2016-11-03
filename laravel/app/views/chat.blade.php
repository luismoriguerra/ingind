<a class="open-chat-button tooltips" onClick="show()" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="" data-original-title="Info Chat"><i class="fa fa-wechat"></i></a>
                
<a class="open-chat-button-active tooltips" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="" data-original-title="Info Chat"><i class="fa fa-wechat"></i></a>

<div class="live-chat" id="chat">
    <form action="#" id="form-chat" class="sky-form">
        <header>
        <span>Chat</span>

        <span class="nuevo-chat btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nuevo Mensaje" onclick="nuevoMensaje()"><i class="glyphicon glyphicon-edit"></i></span>

        <span type="button" class="btn-sm" aria-hidden="true" onclick="ocultar(this,'live-chat')"><i class="fa fa-minus"></i></span>
        </header>
        <fieldset class="myscroll"> 

            <div id="conversationList">
                @include('templates/conversations', array('conversations' => $conversations))
            </div>
        </fieldset>
    </form>


    <!-- Default Panel -->
    <div class="panel panel-u" style="display:none">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-comment"></i> Talk to us!
                <button type="button" class="close-chat-button" aria-hidden="true"><i class="fa fa-times"></i></button>
                <button type="button" class="minimize-chat-button" aria-hidden="true"><i class="fa fa-minus"></i></button>
            </h3>
        </div>
        <div class="panel-body c-body">
            <div class="alert alert-warning" style="margin:15px">
               <strong>Hello my dear!</strong> A coordinator will be attending in a few minutes. Just wait or leave us a message and we will soon answer...
            </div>                              
        </div>
        <div class="panel-footer">
            <form class="sky-form">
                <label class="input">
                    <button id="btn-send" class="btn-u icon-append"><i class="glyphicon glyphicon-play"></i></button>
                    <input type="hidden" id="chat_id">
                    <input type="text" id="in-message" placeholder="Type here...">
                </label>
            </form>
            
        </div>
    </div>
    <!-- End Default Panel -->
</div>



<div class="chatonline">
    <header>
        <span id="spanNombre">Fabio Franco Venero Carra</span>
        <span type="button" class="btn-sm" aria-hidden="true" onclick="ocultar(this,'chatonline')" style="float:right;"><i class="fa fa-minus"></i></span>
    </header>                            
    <fieldset> 
        <div class="conversation myscroll">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 left">
                    <div class="imagenPerfil">
                        <img src="{{asset('img/user/u5.jpg')}}" class="img-circle" style="height:40px;width:40px">
                    </div>                               
                    <div class="datosPerfil">
                        <h3 class="nombre">
                               Fabio Franco Venero Carra
                            </h3>
                        <p>mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje</p>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 left">
                    <div class="imagenPerfil">
                        <img src="{{asset('img/user/u5.jpg')}}" class="img-circle" style="height:40px;width:40px">
                    </div>                               
                    <div class="datosPerfil">
                        <h3 class="nombre">
                               Fabio Franco Venero Carra
                            </h3>
                        <p>mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje mensaje</p>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="row bodyBottom">
                <div class="contComments hacerComentario" style="margin-bottom: 5px"> 
                    <div class="replicate">
                        <img class="comentarioPropio" src="http://www.e-quipu.pe/static/img/btnEnviarcomentario.png" publicacion="3384" publicante="Pedro Williamz Solano Francia" usuario="1938" usuarioimg="SALUD.jpg" activity="13001">
                        <textarea class="comentariohacer" idactividad="13001" type="text" placeholder="ingresa tu comentario"></textarea>
                    </div>
                </div>
            </div>
        </footer>
    </fieldset> 
</div>

<div class="nuevomensaje">
    <header>
        <span id="spanNombre">Nuevo Mensaje</span>
        <span type="button" class="btn-sm" aria-hidden="true" onclick="ocultar(this,'nuevomensaje')" style="float:right;"><i class="fa fa-minus"></i></span>
    </header>                            
    <fieldset>                       
        <div class="row area">
            <div class="col-md-12 col-sm-12 col-xs-12 left">
            <span>Seleccione area:</span>
               <select class="form-control" name="cboArea" id="cboArea" style="border-radius: 5px !important">
                   
               </select>
             </div>
        </div>
        <div class="row usuario">
            <div class="col-md-12 col-sm-12 col-xs-12 left">
            <span>Seleccione usuario:</span>
               <select class="form-control" name="cboUsuario" id="cboUsuario" style="border-radius: 5px !important">
                   
               </select>
             </div>
        </div>
        <div class="row mensaje">
            <div class="col-md-12 col-sm-12 col-xs-12 left">
                <span>Mensaje:</span>
                <textarea class="form-control" style="border-radius: 5px !important" name="txtmensaje" id="txtmensaje" rows="8" placeholder="mensaje"></textarea>
            </div>
        </div>
        <div class="row enviar" style="margin-top:5px">
            <div class="col-md-12 col-sm-12 col-xs-12 left">
                <span class="btn btn-primary btn-sm" style="float:right;">Enviar</span>  
            </div>
        </div>
    </fieldset> 
</div>


    <!-- End Default Panel -->
</div>


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
    {{ HTML::script('https://cdn.socket.io/socket.io-1.2.0.js') }}
    {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.min.js') }}
    {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.2/vue-resource.min.js') }}
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
                var socket = io('http://ingind:3000');
                //var socket = io('http://procesos.munindependencia.pe:3000');
                socket.on('welcome', function (data) {
                    console.log(data.message);
                    socket.emit('join', { room:  user_id });
                });

                socket.on('joined', function(data) {
                    console.log(data.message);
                });
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
                    if (conversation) {
                        $('.chatonline').css('display', 'block');
                    }
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