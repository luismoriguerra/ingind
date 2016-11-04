<template v-for="conversation in conversations">
    <div class="row conversacion" id="@{{conversation.name}}" v-if="current_conversation==conversation.name" @click.prevent="chat(conversation.name)" class="list-group-item active">
        {{-- <div class="col-md-12 col-sm-12 col-xs-12 left"> --}}
            <div class="imagenPerfil">
                <template v-for="(item, index) in conversation.users">
                    <img class="img-circle" style="height: 35px;width: 40px;margin-left:5px" :src="index.img">
                    <template v-if="index.count!=item + 1">,</template>
                </template>
            </div>
            <div class="datosPerfil">
                <template v-for="(item, index) in conversation.users">
                    <h3 class="nombre">@{{ index.full_name }}</h3>
                    <p>@{{ index.area }}</p>
                </template>
                <template v-if="conversation.messages_notifications_count">
                    <span class="badge">@{{ conversation.messages_notifications_count }}</span>
                </template>
                <p>@{{ conversation.body }}</p>
            </div>
       {{--  </div> --}}
    </div>

    <div class="row conversacion" id="@{{conversation.name}}" v-if="current_conversation!=conversation.name" @click.prevent="chat(conversation.name)" class="list-group-item ">
      {{--   <div class="col-md-12 col-sm-12 col-xs-12 left"> --}}
            <div class="imagenPerfil">
                <template v-for="(item, index) in conversation.users">
                    <img class="img-circle" style="height: 35px;width: 40px;margin-left:5px" :src="index.img">
                    <template v-if="index.count!=item + 1">,</template>
                </template>
            </div>
            <div class="datosPerfil">
                <template v-for="(item, index) in conversation.users">
                    <h3 class="nombre">@{{ index.full_name }}</h3>
                    <p>@{{ index.area }}</p>
                </template>
                <template v-if="conversation.messages_notifications_count">
                    <span class="badge">@{{ conversation.messages_notifications_count }}</span>
                </template>
                <p>@{{ conversation.body }}</p>
            </div>
       {{--  </div> --}}
    </div>
</template>
