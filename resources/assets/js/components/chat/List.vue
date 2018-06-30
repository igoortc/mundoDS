<template>
    <div class="row">
        <div class="chat-list col-md-4 col-sm-12">
            <p v-if="friends.length === 0">
                You don't have any friends yet. <a href="all_users">Find some</a>! <i class="fa fa-smile-o"></i>
            </p>
            <div v-else v-for="(friend, index) in friends" :key="index">
                <img @click="toggleChat(friend.following.id)" :src="friend.following.photo"/>
                <span>{{friend.following.name}}</span>
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
        props: ['user'],
        data () {
            return {
                openChats: [],
                friends: []
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
            },
            getFriends () {
                axios.get('/friends/' + this.user)
                    .then(response => {
                        this.friends = response.data.data
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load friends. '
                        });
                    });
            },
        },
        created () {
            this.getFriends()
        }
    }
</script>