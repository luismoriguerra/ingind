<template v-for="message in current_conversation.messages">
    <div class="message row" style="padding: 5px 15px 5px 20px">
        <div class="media msg ">
            {{-- <small class="pull-right time"><i class="fa fa-clock-o"></i> @{{ message.created_at }}</small> --}}
            <a class="pull-left" href="#">
                <img class="media-object img-circle" width="30" height="30" :src="message.img" data-toggle="tooltip" data-placement="bottom" title="{{ message.user.username }}">
            </a>
            <div class="media-body">
                <span class="media-heading" style="font-size: 12px;font-weight: bold;">@{{ message.user.username }}</span>
                <small>@{{ message.body }}</small>
            </div>
        </div>
    </div>
</template>