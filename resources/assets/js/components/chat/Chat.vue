<template>
    <div class="chat">
        <div class="messages-wrapper">
            <div class="user-header row">
                <img :src="friend_resource.photo" />
                <a :href="'/user/' + friend_resource.id"><span>{{friend_resource.name}}</span></a>
            </div>
            <!-- <div v-if="messages.length === 0">
                <p>You and {{friend_resource.name}} have not started a conversation yet.</p>
                <p>Go ahead and send a message! <i class="fa fa-smile-o"></i></p>
            </div> -->
            <div class="messages" v-chat-scroll>
                <div v-for="(message, index) in messages" :key="index">
                    <div class="speech-bubble-user" v-if="message.user.id === user" @click="clicked = !clicked">
                        <span>{{ message.message }}</span><br/>
                        <p v-if="clicked" class="chat-date">{{ message.date }}</p>
                    </div>
                    <div class="speech-bubble-friend" v-else @click="clicked = !clicked">
                        <span>{{ message.message }}</span><br/>
                        <p v-if="clicked" class="chat-date">{{ message.date }}</p>
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
  data() {
    return {
        chat: {
            message: '',
            user: '',
            friend: ''
        },
        clicked: false,
        messages: [],
        friend_resource: []
        }
  },
  mounted() {
    this.getMessages()
    this.getFriend()
    database.ref('/chats').on('value', snapshot => {
      this.getMessages()
    })
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
            text: 'Failed to load messages.'
          })
        })
    },
    sendMessage () {
      this.chat.user = this.user
      this.chat.friend = this.friend
      axios.post('/api/chat/' + this.user + '/friend/' + this.friend, this.chat)
        .then(response => {
          this.chat.message = ''
        })
        .catch(error => {
          this.$notify({
            type: 'error',
            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
            text: 'Failed to send message.'
          })
        })
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
            text: 'Failed to load user.'
          })
        })
    }
  }
}
</script>