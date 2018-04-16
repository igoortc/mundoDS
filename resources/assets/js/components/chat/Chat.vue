<template>
    <div class="messages-wrapper">
        <div class="user-header row">
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 np-r">
                <img :src="friend_resource.photo" />
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7 text-left np">
                <span>{{friend_resource.name}}</span>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1 np text-right">
                <i class="fa fa-minus-square"></i>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 np-l text-right">
                <i class="fa fa-times"></i>
            </div>
        </div>
        <div class="messages">
            <div v-for="(message, index) in messages" :key="index">
                <p v-if="message.user.id === user" style="float: right">
                    {{ message.user.name }}
                    {{ message.message }}
                </p>
                <p v-else style="float: left">
                    {{ message.user.name }}
                    {{ message.message }}
                </p>
            </div>
        </div>
        <form class="form sender">
            <div class="form-row">
                <textarea class="input" placeholder="Write something..." required v-model="chat.message"/>
            </div>
            <div class="form-row">
                <input type="button" class="btn btn-primary" @click="sendMessage()" value="Send!">
            </div>
        </form>
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
                        console.log(response.data.data)
                        this.friend_resource = response.data.data
                        console.log(this.friend_resource)
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load user. '
                        });
                    });
            },
        },
        mounted () {
            this.getMessages()
            this.getFriend()
        }
    }
</script>