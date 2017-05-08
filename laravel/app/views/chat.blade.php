<div id="chat">
    <a class="open-chat-button tooltips hidden" @click.prevent="show" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="" data-original-title="Info Chat"><i class="fa fa-wechat"></i></a>
                    
    <a class="open-chat-button-active tooltips hidden" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="" data-original-title="Info Chat"><i class="fa fa-wechat"></i></a>
    <div class="live-chat" style="display:none">
        <form action="#" id="form-chat" class="sky-form">
            <header>
                <span>Chat</span>
                <span class="nuevo-chat btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nuevo Mensaje" @click.prevent="nuevoMensaje"><i class="glyphicon glyphicon-edit"></i></span>
                <span type="button" class="btn-sm" aria-hidden="true" @click.prevent="ocultar('live-chat')"><i class="fa fa-minus"></i></span>
            </header>
            <fieldset class="myscroll"> 
                <div id="conversationList">
                    @include('templates/conversations')
                </div>
            </fieldset>
        </form>
    </div>
    <div class="chatonline" style="display:none">
        <header>
            <span id="spanNombre">Chat</span>
            <span type="button" class="btn-sm" aria-hidden="true" @click.prevent="ocultar('chatonline')" style="float:right;"><i class="fa fa-minus"></i></span>
        </header>
        <fieldset>
            <div id="messageList" class="conversation myscroll">
                @include('templates/messages')
            </div>
            <footer>
                <div class="row bodyBottom">
                    <div class="contComments hacerComentario" style="margin-bottom: 5px"> 
                        <div class="replicate">
                            <img class="comentarioPropio" src="img/web/btnEnviarcomentario.png" @click.prevent="sendMessage">
                            <textarea @keyup.prevent="handleKeypress" id="messageBox" class="comentariohacer" placeholder="Escribe una respuesta..."></textarea>
                        </div>
                    </div>
                </div>
            </footer>
        </fieldset>
    </div>
    <div class="nuevomensaje" style="display:none">
        <header>
            <span id="spanNombre">Nuevo Mensaje</span>
            <span type="button" class="btn-sm" aria-hidden="true" @click.prevent="ocultar('nuevomensaje')" style="float:right;"><i class="fa fa-minus"></i></span>
        </header>
        <fieldset>
            <form v-on:submit.prevent='sendConversation(this)'>
                <div class="row area">
                    <div class="col-md-12 col-sm-12 col-xs-12 left">
                    <span>Seleccione area:</span>
                       {{ Form::select('areas[]', $areas, null, array("id"=>"areas","style"=>"border-radius: 5px !important","class" => "form-control")) }}
                     </div>
                </div>
                <div class="row usuario">
                    <div class="col-md-12 col-sm-12 col-xs-12 left">
                    <span>Seleccione usuario:</span>
                        <select class="form-control" id="users" name="users" v-model="users_id" style="border-radius: 5px !important">
                          <option v-for="(key, val) in users" v-bind:value="key">@{{ val }}</option>
                        </select>
                     </div>
                </div>
                <div class="row mensaje">
                    <div class="col-md-12 col-sm-12 col-xs-12 left">
                        <span>Mensaje:</span>
                        <textarea v-model="body" rows="4" class="form-control" name="body"  id="body" style="border-radius: 5px !important"></textarea>
                    </div>
                </div>
                <div class="row enviar" style="margin-top:5px">
                    <div class="col-md-12 col-sm-12 col-xs-12 left">
                        {{ Form::submit('Enviar', array('class' => 'btn btn-primary btn-sm','style'=>'float:right')) }}
                    </div>
                </div>
            </form>
        </fieldset> 
    </div>

</div>
{{ HTML::script('lib/socket/socket1.2.js') }}
{{ HTML::script('lib/cloudflare/coudflare-vue-1.0.24.js') }}
{{ HTML::script('lib/cloudflare/coudflare-vue-0.7.2.js') }}
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
            users_id : {},
            users : {},
            from_user_id : [],
            conversation : [],
        },
        ready: function () {
            //var socket = io('http://ingind:3000');
            var socket = io('http://proceso.munindependencia.pe:3000');
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
                    /*this.scrollToBottom();*/ 

                    if(response.messages.length > 9){
                        this.scrollToBottom();
                    }                  
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
                var usuarios;
                if (!Array.isArray(this.users_id)){
                    usuarios = [this.users_id];
                }else{
                    usuarios = this.users_id;
                }

                data={
                    body:this.body,
                    users:usuarios
                };
                this.$http.post("/conversations",data,function(data) {
                    this.getConversations(current_conversation);
                    $('#newMessageModal').modal('hide');
                    $('.nuevomensaje').css('display', 'none');
                });
            },
            getArea: function (area_id){
                this.$http.get("/areas/"+area_id+"/users",function(data) {
                    //vm.users=data;
                    this.users=data;
                    /*$('#users').empty();
                    $.each(data, function(key, element) {
                        if (vm.usuarioSession.indexOf( parseInt(key) )>=0) {
                            $('#users').append("<option class='boldoption' value='" + key + "'>" + element + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&bull;)</option>");
                        } else if (vm.usuarioSession.indexOf( key )>=0) {
                            $('#users').append("<option class='boldoption' value='" + key + "'>" + element + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&bull;)</option>");
                        } else {
                            $('#users').append("<option value='" + key + "'>" + element + "</option>");
                        }
                    });*/
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
            },
            show:function(){
                $('.live-chat').css('display', 'block');
            },
            ocultar:function(element){
                $('.'+element).css('display', 'none');
                //si es chat online
                if ('chatonline'==element) {
                    this.current_conversation=[];
                }
            },
            nuevoMensaje:function(){
                $('.nuevomensaje').css('display', 'block');
            },
        }
    });
</script>
