<template v-for="message in current_conversation.messages">
    <div id="message" class="message row" style="padding: 5px 15px 5px 20px">
        <div class="media msg ">
            {{-- <small class="pull-right time"><i class="fa fa-clock-o"></i> @{{ message.created_at }}</small> --}}            
            <a class="pull-left" href="#" data-toggle="tooltip" data-placement="bottom" title="message.created_at">
                <img class="media-object img-circle" width="30" height="30" :src="message.img">
            </a>
            <div class="media-body">
                <span class="media-heading" style="font-size: 11px;font-weight: bold;">@{{ message.user.nombre + " " + message.user.paterno + " "  + message.user.materno}}</span>
                <br>
                <small>@{{ message.body }}</small>
            </div>
        </div>
    </div>
</template>