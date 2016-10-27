<div class="list-group col-lg-3">
    <template v-for="conversation in conversations">
        <a id="@{{conversation.name}}" v-if="current_conversation==conversation.name" @click.prevent="chat(conversation.name)" class="list-group-item active">
        <div class="pull-left user-picture">
                <template v-for="(item, index) in conversation.users">
                    <img class="media-object img-circle" width="30" height="30" :src="index.img">@{{ index.full_name +' ( '+index.area +')' }}
                    <template v-if="index.count!=item + 1">,</template>
                </template>
            </div>
            <template v-if="conversation.messages_notifications_count">
                <span class="badge">@{{ conversation.messages_notifications_count }}</span>
            </template>
            <p class="list-group-item-text"><small> @{{ conversation.body }} </small></p>
        </a>

        <a id="@{{conversation.name}}" v-if="current_conversation!=conversation.name" @click.prevent="chat(conversation.name)" class="list-group-item ">
            <div class="pull-left user-picture">
                <template v-for="(item, index) in conversation.users">
                    <img class="media-object img-circle" width="30" height="30" :src="index.img">@{{ index.full_name +' ( '+index.area +')' }}
                    <template v-if="index.count!=item + 1">,</template>
                </template>
            </div>
            <template v-if="conversation.messages_notifications_count">
                <span class="badge">@{{ conversation.messages_notifications_count }}</span>
            </template>
            <p class="list-group-item-text"><small> @{{ conversation.body }} </small></p>
        </a>
    </template>
</div>
