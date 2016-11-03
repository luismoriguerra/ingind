<template v-for="message in messages">
    <div class="message">
        <div class="media msg ">
            
            <a class="pull-left" href="#">
                <img class="media-object img-circle" width="30" height="30" :src=" message.img ">
            </a>
            <div class="media-body">
                <h5 class="media-heading">@{{ message.user_nombre+' ( '+message.area_nemonico+' )' }}</h5>
                <small>@{{ message.body }}</small>
            </div>
        </div>
    </div>
</template>