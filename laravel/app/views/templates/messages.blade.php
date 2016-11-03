<template v-for="message in messages">
    <div class="message" style="margin-bottom: 10px">
        <div class="media msg ">
            
            <a class="pull-left" href="#">
                <img class="media-object img-circle" width="30" height="30" :src=" message.img ">
            </a>
            <div class="media-body">
                <h3 class="media-heading">@{{ message.user_nombre+' ( '+message.area_nemonico+' )' }}</h3>
                <small>@{{ message.body }}</small>
            </div>
        </div>
    </div>
</template>