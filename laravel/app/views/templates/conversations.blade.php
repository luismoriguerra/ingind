<template v-for="conversation in conversations">
    <div id="@{{conversation.name}}" class="row conversacion list-group-item" v-bind:class="{ active: conversation.current }"  @click.prevent="chat(conversation.name)">
        <div class="imagenPerfil">
            <template v-for="(item, index) in conversation.users">
                <img class="img-circle" style="height: 35px;width: 40px;margin-left:5px" :src="index.img">
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
            <p>@{{ conversation.last_message }}</p>
        </div>
    </div>
</template>