<template v-for="message in messages">
    <div class="message" style="margin-bottom: 10px">
        <div class="media msg ">
            
            <a class="pull-left" href="#">
                <img class="media-object img-circle" width="30" height="30" :src=" message.img ">
            </a>
            <div class="media-body">
                <span class="media-heading" style="font-size: 12px;font-weight: bold;">@{{ message.user_nombre+' ( '+message.area_nemonico+' )' }}</span>
                <small>@{{ message.body }}</small>
            </div>
        </div>
    </div>
</template>