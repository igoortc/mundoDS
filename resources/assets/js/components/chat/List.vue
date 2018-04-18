<template>
    <div>
        <div class="chat-list">
            <div v-if="friends.length === 0">
                <p>You don't have any friends yet. <a href="all_users">Find some</a>! <i class="fa fa-smile-o"></i></p>
            </div>
            <div v-else v-for="(friend, index) in friends" :key="index">
                <img @click="toggleChat(friend.id)" :src="friend.photo"/>
            </div>
        </div>
        <div class="chat-wrapper">
            <div v-for="(chat, index) in openChats" :key="index" class="chat-individual">
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
                let index = this.openChats.indexOf(friend)
                if (index !== -1) {
                    this.openChats.splice(index, 1);
                }
                else {
                    this.openChats.push(friend)
                }
            }
        }
    }
</script>