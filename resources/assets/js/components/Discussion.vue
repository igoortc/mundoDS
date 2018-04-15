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
                    <input type="button" class="btn btn-primary" @click="saveComment" value="Comment!">
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
                        <div v-if="edit[index]">
                            <textarea v-model="com.comment" class="input"></textarea>
                            <div class="form-row text-right">
                                <input type="button" class="btn btn-primary" @click="editComment(index)" value="Edit!">
                            </div>
                        </div>
                        <div v-else>
                            {{com.comment}}
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-right">
                        <ul class="comment-actions">
                            <li>
                                <a href="#" v-if="loved[index]" @click.prevent="unlove(com.id, index)">
                                    <i class="fa fa-heart"></i>
                                </a>
                                <a href="#" v-else @click.prevent="love(com.id, index)">
                                    <i class="fa fa-heart-o"></i>
                                </a> 
                                {{com.votes}}
                                <span v-if="com.user_id.id != user.id">
                                     | <span @click="flagComment(index)"><i class="fa fa-flag"></i> Report</span>
                                </span>
                                <span v-else>
                                     | <span v-if="edit[index]" @click="openEditBox(index)"><i class="fa fa-times"></i> Cancel</span>
                                       <span v-else @click="openEditBox(index)"><i class="fa fa-pencil-square-o"></i> Edit</span>
                                     | <i class="fa fa-trash" @click="deleteComment(index)"></i>
                                </span>
                            </li>
                            <li v-if="reply[index]">
                                <i class="fa fa-times"></i> <span @click="openReplyBox(index)">Close</span>
                            </li>
                            <li v-else>
                                <i class="fa fa-reply"></i> <span @click="openReplyBox(index)">Reply</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <a v-if="com.user_id.id != user.id" :href="'/user/' + com.user_id.id">{{ com.user_id.name}}</a>
                        <a v-else href="/my_profile">{{ com.user_id.name}}</a>
                        <span> | {{ com.date}}</span>
                    </div>
                    
                </div>
            </div>
            <div class="replies" v-if="com.reply_id">
                <div class="comment-reply" v-for="(rep, index2) in com.reply_id" :key="index2">
                    INDEX2 {{ index2 }}
                    <div v-if="rep.user_id.id != user.id" class="comment-avatar">
                        <a :href="'/user/' + rep.user_id.id"><img :src="rep.user_id.photo" /></a>
                    </div>
                    <div v-else class="comment-avatar">
                        <a href="/my_profile"><img :src="rep.user_id.photo" /></a>
                    </div>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                <div v-if="edit[index2]">
                                    <textarea v-model="rep.comment" class="input"></textarea>
                                    <div class="form-row text-right">
                                        <input type="button" class="btn btn-primary" @click="editComment(index2)" value="Edit!">
                                    </div>
                                </div>
                                <div v-else>
                                    {{rep.comment}}
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-right">
                                <ul class="comment-actions">
                                    <li>
                                        <a href="#" v-if="loved[index2]" @click.prevent="unlove(rep.id, index2)">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                        <a href="#" v-else @click.prevent="love(rep.id, index2)">
                                            <i class="fa fa-heart-o"></i>
                                        </a> 
                                        {{rep.votes}}
                                        <span v-if="rep.user_id.id != user.id">
                                            | <span @click="flagComment(index2)"><i class="fa fa-flag"></i> Report</span>
                                        </span>
                                        <span v-else>
                                            | <span v-if="edit[index2]" @click="openEditBox(index2)"><i class="fa fa-times"></i> Cancel</span>
                                            <span v-else @click="openEditBox(index2)"><i class="fa fa-pencil-square-o"></i> Edit</span>
                                            | <i class="fa fa-trash" @click="deleteComment(index2)"></i>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <a v-if="rep.user_id.id != user.id" :href="'/user/' + rep.user_id.id">{{ rep.user_id.name}}</a>
                                <a v-else href="/my_profile">{{ rep.user_id.name}}</a>
                                <span> | {{ rep.date}}</span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-form reply row" v-if="reply[index]">
                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                    <form class="form">
                        <div class="form-row">
                            <textarea class="input" placeholder="Write something..." required v-model="comment.comment"></textarea>
                        </div>
                        <div class="form-row text-right">
                            <input type="button" class="btn btn-primary" @click="replyComment(com.id)" value="Reply!">
                        </div>
                    </form>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <div class="comment-avatar text-right">
                        <img :src="user.photo">
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
                        self.isLove(self.comments[i].id, i)
                    }
                    console.log(self.comments)
            })
            this.edit.fill(0)
        },
        saveComment () {
            this.comment.user_id = this.user.id
            this.comment.episode_id = this.episode_id
            let self = this
            axios.post('/api/episodes/' + self.episode_id + '/discussion', self.comment)
                .then(function (response) {
                    self.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Yay! Your comment was posted!',
                        text: 'It is now available for others to see!'
                    })
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to comment.'
                    })
                })
            this.getComments()
        },
        replyComment (discussion) {
            this.comment.user_id = this.user.id
            this.comment.parent_comment = discussion
            let self = this
            axios.post('/api/discussion/' + discussion + '/replies', self.comment)
                .then(function (response) {
                    self.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Yay! Your reply was posted!',
                        text: 'It is now available for others to see!'
                    })
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to reply comment.'
                    })
                })
            this.getComments()
        },
        editComment(index) {
            let self = this
            self.comments[index].user_id = self.comments[index].user_id.id
            self.comments[index].episode_id = self.comments[index].episode_id.id
            axios.put('/api/episodes/' + self.episode_id + '/discussion/' + self.comments[index].id, self.comments[index])
                .then(function (response) {
                    self.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Done! You edited the comment!',
                        text: 'The comment was updated!'
                    });
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to edit comment.'
                    });
                });
            this.getComments()
            Vue.set(this.edit, index, 0)
            this.editing = false
        },
        openReplyBox (index) {
            if (this.reply[index]) {
                Vue.set(this.reply, index, 0)
                this.replying = false
            } else {
                this.reply.fill(0)
                Vue.set(this.reply, index, 1)
                this.replying = true
            }
        },
        flagComment(index) {
            let self = this
            self.comments[index].spam = 1
            self.comments[index].user_id = self.comments[index].user_id.id
            self.comments[index].episode_id = self.comments[index].episode_id.id
            axios.put('/api/episodes/' + self.episode_id + '/discussion/' + self.comments[index].id, self.comments[index])
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
        openEditBox (index) {
            if (this.edit[index]) {
                Vue.set(this.edit, index, 0)
                this.editing = false
            } else {
                this.edit.fill(0)
                Vue.set(this.edit, index, 1)
                this.editing = true
            }
        },
        deleteComment(index) {
            let self = this
            axios.delete('/api/episodes/' + self.episode_id + '/discussion/' + self.comments[index].id)
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
        love (discussion, index) {
            let self = this;
            axios.post('/love_discussion/' + discussion)
                .then(function (response) {
                    Vue.set(self.loved, index, 1)
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
        unlove (discussion, index) {
            let self = this;
            axios.post('/unlove_discussion/' + discussion)
                .then(function (response) {
                    Vue.set(self.loved, index, 0)
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
        isLove(discussion, index) {
            axios.get('/user/' + this.user.id + '/discussion/' + discussion + '/hasLoved')
                .then(response => {
                    if (response.data.data) {
                        Vue.set(this.loved, index, 1)
                        return true
                    } else {
                        Vue.set(this.loved, index, 0)
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
        // this.isLoved = this.isLove ? true : false
    }
}
</script>