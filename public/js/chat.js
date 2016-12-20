var vm = new Vue({
    http: {
        root: '/root'
    },
    el: '#chat',
    data: {
        nuevoMensaje:false,
        live_chat:false,
        chat_online:true,
        conversations:[],
        consesion:[],
        current_conversation:[],
        messages:[],
        areas:[],
        users:[],
        user_id: user_id,
        socket:socket,
        messageBox:'',
        body:''
    },
    ready: function () {
        this.scrollToBottom();

        this.conexionSocket();
        /***
            Socket.io Events
        ***/
        this.socket.on('welcome', function (data) {
            vm.socket.emit('join', { room:  user_id });
        });
        this.socket.on('joined', function(data) {
            //console.log(data.message);
        });
        this.socket.on('chat.messages', function(data) {
            vm.chat(vm.current_conversation.name);
        });
        this.socket.on('chat.conversations', function(data) {
           vm.chat(data.conversation_name);
           vm.conexionSocket();
        });

        this.getAreas();
        this.chat();
    },
    methods: {
        conexionSocket: function(){
            //esta peticion se dbe ejcutr cada vez que se crea una nueva conversacion
            this.$http.get("/users/" + user_id + '/conversations',function(response) {
                if(response.success && response.result.length > 0) {
                    $.each(response.result, function(index, conversation) {
                        vm.socket.emit('join', { room:  conversation.name });
                    });
                }
            });
        },
        changeArea: function(){
            this.$http.get("/areas/"+this.area_id+"/users",function(response) {
                this.users=response.users;
                this.consesion=response.consesion;
            });
        },
        changeUser: function(){
            this.body='';
            $('#new_message').focus();
        },
        getAreas: function(){
            this.$http.get("/areas",function(response) {
                vm.areas=response.areas;
            });
        },
        chat: function (conversation) {
            var request={conversation: conversation };
            this.$http.post("/chat",request,function(response) {
                this.current_conversation = response.current_conversation;
                this.conversations= response.conversations;
                this.scrollToBottom();
            });
        },
        sendMessage: function() {
            data=  {
                body: this.messageBox ,
                conversation: this.current_conversation.name,
                user_id: this.user_id
            };
            if (this.messageBox.trim()==='') return;
            this.$http.post("/messages",data,function(data) {
                this.messageBox='';
            });
        },
        sendConversation: function(){
            var usuarios;
            if (this.users_id=='Seleccione usuario') {
                return;
            }
            if (!Array.isArray(this.users_id)){
                usuarios = [this.users_id];
            } else {
                usuarios = this.users_id;
            }
            request={
                body:this.body,
                users:usuarios
            };
            this.$http.post("/conversations",request,function(response) {
                this.chat(response.conversation);
                this.conexionSocket();
                this.body='';
                //$('#newMessageModal').modal('hide');
                vm.nuevoMensaje=false;
            });
        },
        handleKeypress: function(event) {
            if (event.keyCode == 13 && event.shiftKey) {
            } else if (event.keyCode == 13){
                if (this.messageBox.trim()==='') return;
                this.sendMessage();
            }
        },
        handleKeypressModal: function(event) {
            if (event.keyCode == 13 && event.shiftKey) {
            } else if (event.keyCode == 13){
                if (this.body.trim()==='') return;
                this.sendConversation();
            }
        },
        scrollToBottom: function() {
            this.handle = setInterval( ( ) => {
                var $messageList  = $("#messageList");
                if($messageList.length) {
                    $messageList.animate({scrollTop: $messageList[0].scrollHeight}, 500);
                }
                clearInterval(this.handle);
            },1);
            this.messageBox='';
            $('#message').focus();
        }
    }
});