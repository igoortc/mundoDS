<template>
    <div class="row">
        <div class="chat-list col-md-4 col-sm-12">
            <p v-if="friends.length === 0">
                You don't have any friends yet. <a href="all_users">Find some</a>! <i class="fa fa-smile-o"></i>
            </p>
            <div v-else v-for="(friend, index) in friends" :key="index">
                <img @click="toggleChat(friend.id)" :src="friend.photo"/>
                <span>{{friend.name}}</span>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div v-for="(chat, index) in openChats" :key="index">
                <chat 
                    :friend="chat"
                    :user="user"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['friends', 'user'],
        data () {
            return {
                openChats: []
            }
        },
        methods: {
            toggleChat (friend) {
                if (this.openChats.length > 0) {
                    this.openChats = []
                }
                let self = this
                setTimeout(() => { 
                    this.openChats.push(friend)
                }, 300)
            }
        }
    }
</script>