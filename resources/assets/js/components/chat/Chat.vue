<template>
    <div class="chat">
        <div class="messages-wrapper">
            <div class="user-header row">
                <img :src="friend_resource.photo" />
                <span>{{friend_resource.name}}</span>
            </div>
            <!-- <div v-if="messages.length === 0">
                <p>You and {{friend_resource.name}} have not started a conversation yet.</p>
                <p>Go ahead and send a message! <i class="fa fa-smile-o"></i></p>
            </div> -->
            <div class="messages" v-chat-scroll>
                <div v-for="(message, index) in messages" :key="index">
                    <div class="speech-bubble-user" v-if="message.user.id === user">
                        <span>{{ message.message }}</span><br/>
                        <p class="chat-date">{{ message.date }}</p>
                    </div>
                    <div class="speech-bubble-friend" v-else>
                        <span>{{ message.message }}</span><br/>
                        <p class="chat-date">{{ message.date }}</p>
                    </div>
                </div>
            </div>
            <form class="form sender" @submit.prevent="sendMessage">
                <div class="form-row">
                    <input class="input" placeholder="Write something, then hit Enter..." required v-model="chat.message" @keyup.enter.native="sendMessage()" />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['friend', 'user'],
        data () {
            return {
                messages: [],
                chat: {
                    message: '',
                    user: '',
                    friend: ''
                },
                friend_resource: []
            }
        },
        methods: {
            getMessages () {
                axios.get('/api/chat/' + this.user + '/friend/' + this.friend)
                    .then(response => {
                        this.messages = response.data.data
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load messages. '
                        });
                    });
            },
            sendMessage () {
                this.chat.user = this.user
                this.chat.friend = this.friend
                axios.post('/api/chat/' + this.user + '/friend/' + this.friend, this.chat)
                    .then(response => {
                        this.$emit('messagesent', this.chat)
                        this.chat.message = ''
                        this.getMessages()
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to send message. '
                        });
                    });
            },
            getFriend () {
                axios.get('/api/users/' + this.friend)
                    .then(response => {
                        this.friend_resource = response.data.data
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load user. '
                        });
                    });
            }
        },
        created () {
            Echo.private('chat')
                .listen('MessageSent', (e) => {
                    console.log('cheguei', e)
                    // if (e.chat.user === this.friend && e.chat.friend === this.user) {
                    //     this.messages.push({
                    //         message: e.chat.message,
                    //         user: e.chat.user,
                    //         friend: e.chat.friend
                    //     })
                    // }
                    if (e.chat.user === this.friend && e.chat.friend === this.user) {
                        this.getMessages()
                    }
                })
        },
        mounted () {
            this.getMessages()
            this.getFriend()
        }
    }
</script>