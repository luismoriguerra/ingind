<template v-for="message in messages">
    <div class="message">
        <div class="media msg ">
            <small class="pull-right time"><i class="fa fa-clock-o"></i> @{{ message.created_at.date }}</small>
            <a class="pull-left" href="#">
                <img class="media-object img-circle" width="30" height="30" :src=" message.imagen ">
            </a>
            <div class="media-body">
                <h5 class="media-heading">@{{ message.user_nombre+' ( '+message.area_nemonico+' )' }}</h5>
                <small>@{{ message.body }}</small>
            </div>
        </div>
    </div>
</template>