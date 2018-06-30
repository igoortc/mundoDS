<template>
    <div class="discussion">
        <h3><i class="fa fa-comments"></i> Discussion</h3>
        <div class="comment-form" v-if="!replying">
            <div class="comment-avatar">
                <img :src="user.photo">
            </div>
            <form class="form">
                <div class="form-row">
                    <textarea class="input" placeholder="Write something..." required v-model="comment.comment"></textarea>
                </div>
                <div class="form-row">
                    <input type="button" class="btn btn-primary" @click="saveComment(0)" value="Comment!">
                </div>
            </form>
        </div>
        <div class="comment" v-for="(com, index) in comments" :key="index">
            <div v-if="com.user_id.id != user.id" class="comment-avatar">
                <a :href="'/user/' + com.user_id.id"><img :src="com.user_id.photo" /></a>
            </div>
            <div v-else class="comment-avatar">
                <a href="/my_profile"><img :src="com.user_id.photo" /></a>
            </div>
            <div class="comment-box">
                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                        <div v-if="edit[com.id]">
                            <textarea v-model="com.comment" class="input"></textarea>
                            <div class="form-row text-right">
                                <input type="button" class="btn btn-primary" @click="editComment(com.id, com.comment)" value="Edit!">
                            </div>
                        </div>
                        <div v-else>
                            {{com.comment}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-right">
                        <ul class="comment-actions">
                            <li>
                                <a href="#" v-if="loved[com.id]" @click.prevent="unlove(com.id)">
                                    <i class="fa fa-heart"></i>
                                </a>
                                <a href="#" v-else @click.prevent="love(com.id)">
                                    <i class="fa fa-heart-o"></i>
                                </a> 
                                {{com.votes}}
                                <span v-if="com.user_id.id != user.id">
                                     | <span @click="flagComment(com.id)"><i class="fa fa-flag"></i> Report</span>
                                </span>
                                <span v-else>
                                     | <span v-if="edit[com.id]" @click="toggleEditBox(com.id)"><i class="fa fa-times"></i> Cancel</span>
                                       <span v-else @click="toggleEditBox(com.id)"><i class="fa fa-pencil-square-o"></i> Edit</span>
                                     | <i class="fa fa-trash" @click="deleteComment(com.id)"></i>
                                </span>
                            </li>
                            <li v-if="reply[com.id]">
                                <i class="fa fa-times"></i> <span @click="toggleReplyBox(com.id)">Close</span>
                            </li>
                            <li v-else>
                                <i class="fa fa-reply"></i> <span @click="toggleReplyBox(com.id)">Reply</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <a v-if="com.user_id.id != user.id" :href="'/user/' + com.user_id.id">{{ com.user_id.name}}</a>
                        <a v-else href="/my_profile">{{ com.user_id.name}}</a>
                        <span> | {{ com.date}}</span>
                    </div>
                </div>
            </div>
            <div class="replies" v-if="com.reply_id">
                <div class="comment-reply" v-for="(rep, index2) in com.reply_id" :key="index2">
                    <div v-if="rep.user_id.id != user.id" class="comment-avatar">
                        <a :href="'/user/' + rep.user_id.id"><img :src="rep.user_id.photo" /></a>
                    </div>
                    <div v-else class="comment-avatar">
                        <a href="/my_profile"><img :src="rep.user_id.photo" /></a>
                    </div>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                <div v-if="edit[rep.id]">
                                    <textarea v-model="rep.comment" class="input"></textarea>
                                    <div class="form-row text-right">
                                        <input type="button" class="btn btn-primary" @click="editComment(rep.id, rep.comment)" value="Edit!">
                                    </div>
                                </div>
                                <div v-else>
                                    {{rep.comment}}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-right">
                                <ul class="comment-actions">
                                    <li>
                                        <a href="#" v-if="loved[rep.id]" @click.prevent="unlove(rep.id)">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                        <a href="#" v-else @click.prevent="love(rep.id)">
                                            <i class="fa fa-heart-o"></i>
                                        </a> 
                                        {{rep.votes}}
                                        <span v-if="rep.user_id.id != user.id">
                                            | <span @click="flagComment(rep.id)"><i class="fa fa-flag"></i> Report</span>
                                        </span>
                                        <span v-else>
                                            | <span v-if="edit[rep.id]" @click="toggleEditBox(rep.id)"><i class="fa fa-times"></i> Cancel</span>
                                            <span v-else @click="toggleEditBox(rep.id)"><i class="fa fa-pencil-square-o"></i> Edit</span>
                                            | <i class="fa fa-trash" @click="deleteComment(rep.id)"></i>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <a v-if="rep.user_id.id != user.id" :href="'/user/' + rep.user_id.id">{{ rep.user_id.name}}</a>
                                <a v-else href="/my_profile">{{ rep.user_id.name}}</a>
                                <span> | {{ rep.date}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-form reply row" v-if="reply[com.id]">
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <form class="form">
                        <div class="form-row">
                            <textarea class="input" placeholder="Write something..." required v-model="comment.comment"></textarea>
                        </div>
                        <div class="form-row text-right">
                            <input type="button" class="btn btn-primary" @click="saveComment(com.id)" value="Reply!">
                        </div>
                    </form>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <div class="reply-actions pull-right">
                        <span @click="toggleReplyBox(com.id)"><i class="fa fa-times"></i> <span>Close</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['episode_id', 'user'],
    data () {
        return {
            comments: [],
            comment: {
                id: '',
                comment: '',
                votes: 0,
                spam: 0,
                reply_id: 0,
                parent_comment: '',
                episode_id: '',
                user_id: '',
                date: ''
            },
            reply: [],
            replying: false,
            loved: [],
            edit: [],
            editing: false
        }
    },
    methods: {
        getComments () {
            let self = this
            axios.get('/api/episodes/' + self.episode_id + '/discussion')
                .then(response => {
                    self.comments = response.data.data
                    for (let i = 0; i < self.comments.length; i++) {
                        self.isLove(self.comments[i].id)
                        for (let j = 0; j < self.comments[i].reply_id.length; j++) {
                            self.isLove(self.comments[i].reply_id[j].id)
                        }
                    }
            })
            this.edit.fill(0)
        },
        saveComment (parent_comment) {
            this.comment.user_id = this.user.id
            this.comment.episode_id = this.episode_id
            this.comment.parent_comment = parent_comment
            let self = this
            axios.post('/api/episodes/' + this.episode_id + '/discussion', this.comment)
                .then(response => {
                    this.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Yay! Your comment was posted!',
                        text: 'It is now available for others to see!'
                    })
                })
                .catch(error => {
                    this.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to comment.'
                    })
                })
            setTimeout(() => {
                this.comment.comment = '' 
            }, 500)
            this.getComments()
            if (parent_comment) {
                setTimeout(() => {
                    this.toggleReplyBox(parent_comment)
                }, 1000)
            }
        },
        editComment(comment_id, comment) {
            axios.put('/api/episodes/' + this.episode_id + '/discussion/' + comment_id, {comment: comment})
                .then(response => {
                    this.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Done! You edited the comment!',
                        text: 'The comment was updated!'
                    })
                    this.getComments()
                })
                .catch(error => {
                    this.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to edit comment.'
                    })
                })
            Vue.set(this.edit, comment_id, 0)
            this.editing = false
        },
        toggleReplyBox (index) {
            if (this.reply[index]) {
                Vue.set(this.reply, index, 0)
                this.replying = false
            } else {
                this.reply.fill(0)
                Vue.set(this.reply, index, 1)
                this.replying = true
            }
        },
        flagComment(comment_id) {
            let self = this
            axios.put('/api/episodes/' + self.episode_id + '/discussion/' + comment_id, {spam: 1})
                .then(function (response) {
                    self.getComments()
                    self.$notify({
                        type: 'warn',
                        title: "<i class='fa fa-fire-extinguisher'></i> Oh, no! We'll take a look at this comment!",
                        text: 'The comment was reported and it will be analyzed by our team!'
                    })
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to report comment.'
                    })
                })
        },
        toggleEditBox (index) {
            if (this.edit[index]) {
                Vue.set(this.edit, index, 0)
                this.editing = false
            } else {
                this.edit.fill(0)
                Vue.set(this.edit, index, 1)
                this.editing = true
            }
        },
        deleteComment(comment_id) {
            let self = this
            axios.delete('/api/episodes/' + self.episode_id + '/discussion/' + comment_id)
                .then(function (response) {
                    self.getComments()
                    self.$notify({
                        type: 'warn',
                        title: '<i class="fa fa-ban"></i> Wow! You really deleted it!',
                        text: 'You deleted the comment!'
                    })
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to delete comment.'
                    })
                })
        },
        love (discussion) {
            let self = this;
            axios.post('/love_discussion/' + discussion)
                .then(function (response) {
                    Vue.set(self.loved, discussion, 1)
                    self.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Yay! Good stuff!',
                        text: 'You loved this comment!'
                    })
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to love the comment.'
                    })
                })
            this.getComments()
        },
        unlove (discussion) {
            let self = this;
            axios.post('/unlove_discussion/' + discussion)
                .then(function (response) {
                    Vue.set(self.loved, discussion, 0)
                    self.$notify({
                        type: 'warn',
                        title: '<i class="fa fa-meh-o"></i> Okay... Have a nice life!',
                        text: 'You unloved this comment!'
                    })
                })
                .catch(function (error) { 
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to unlove the comment.'
                    })
                })
            this.getComments()
        },
        isLove(discussion) {
            axios.get('/user/' + this.user.id + '/discussion/' + discussion + '/hasLoved')
                .then(response => {
                    if (response.data.data) {
                        Vue.set(this.loved, discussion, 1)
                        return true
                    } else {
                        Vue.set(this.loved, discussion, 0)
                        return false
                    }
                })
                .catch(error => {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to load loves.'
                    })
                })
        }
    },
    mounted () {
        this.getComments()
    }
}
</script>