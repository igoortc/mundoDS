<template>
<div class="comments-app">
    <h3><i class="fa fa-comments"></i> Discussion</h3>
    <!-- From -->
    <div class="comment-form" v-if="user">
        <!-- Comment Avatar -->
        <div class="comment-avatar">
            <img :src="user.photo">
        </div>

        <form class="form" name="form">
            <div class="form-row">
                <textarea class="input" placeholder="Write something..." required v-model="message"></textarea>
                <span class="input" v-if="errorComment" style="color:red">{{errorComment}}</span>
            </div>
            <div class="form-row">
                <input type="button" class="btn btn-success" @click="saveComment" value="Comment!">
            </div>
        </form>
    </div>
    <!-- Comments List -->
    <div class="comments" v-if="comments" v-for="(comment,index) in commentsData" :key="index">
        <!-- Comment -->
        <div v-if="!spamComments[index] || !comment.spam" class="comment">
            <!-- Comment Avatar -->
            <div class="comment-avatar">
                <img :src="comment.photo_url">
            </div>

            <!-- Comment Box -->
            <div class="comment-box">
                <div class="comment-text">{{comment.comment}}</div>
                <div class="comment-footer">
                    <div class="comment-info">
                        <span class="comment-author">
                                <em>{{ comment.name}}</em>
                            </span>
                        <span class="comment-date">{{ comment.date}}</span>
                    </div>

                    <div class="comment-actions">
                        <ul class="list">
                            <li>Votes: {{comment.votes}}
                                <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'up')"><i class="fa fa-thumbs-up"></i></a>
                                <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'down')"><i class="fa fa-thumbs-down"></i></a>
                            </li>
                            <li>
                                <a v-on:click="spamComment(comment.commentid,'directcomment',index,0)"><i class="fa fa-flag"></i> Report</a>
                            </li>
                            <li>
                                <a v-on:click="openComment(index)"><i class="fa fa-reply"></i> Reply</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- From -->
            <div class="comment-form comment-v" v-if="commentBoxs[index]">
                <!-- Comment Avatar -->
                <div class="comment-avatar">
                    <img :src="user.photo">
                </div>

                <form class="form" name="form">
                    <div class="form-row">
                        <textarea class="input" placeholder="Write something..." required v-model="message"></textarea>
                        <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                    </div>
                    <div class="form-row">
                        <input type="button" class="btn btn-success" v-on:click="replyComment(comment.commentid,index)" value="Reply!">
                    </div>
                </form>
            </div>
            <!-- Comment - Reply -->
            <div v-if="comment.replies">
                <div class="comments" v-for="(replies,index2) in comment.replies" :key="index2">
                    <div v-if="!spamCommentsReply[index2] || !replies.spam" class="comment reply">

                        <!-- Comment Avatar -->
                        <div class="comment-avatar">
                            <img :src="replies.photo_url">
                        </div>

                        <!-- Comment Box -->
                        <div class="comment-box" style="background: grey;">
                            <div class="comment-text" style="color: white">{{replies.comment}}</div>
                            <div class="comment-footer">
                                <div class="comment-info">
                                    <span class="comment-author">
                                            {{replies.name}}
                                        </span>
                                    <span class="comment-date">{{replies.date}}</span>
                                </div>

                                <div class="comment-actions">
                                    <ul class="list">
                                        <li>Total votes: {{replies.votes}}
                                            <a v-if="!replies.votedByUser" v-on:click="voteComment(replies.commentid,'replycomment',index,index2,'up')"><i class="fa fa-thumbs-up"></i></a>
                                            <a v-if="!replies.votedByUser" v-on:click="voteComment(comment.commentid,'replycomment',index,index2,'down')"><i class="fa fa-thumbs-down"></i></a>
                                        </li>
                                        <li>
                                            <a v-on:click="spamComment(replies.commentid,'replycomment',index,index2)"><i class="fa fa-flag"></i> Report</a>
                                        </li>
                                        <li>
                                            <a v-on:click="replyCommentBox(index2)"><i class="fa fa-reply"></i> Reply</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- From -->
                        <div class="comment-form reply" v-if="replyCommentBoxs[index2]">
                            <!-- Comment Avatar -->
                            <div class="comment-avatar">
                                <img :src="user.photo">
                            </div>

                            <form class="form" name="form">
                                <div class="form-row">
                                    <textarea class="input" placeholder="Write something..." required v-model="message"></textarea>
                                    <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                                </div>
                                <div class="form-row">
                                    <input type="button" class="btn btn-success" v-on:click="replyComment(comment.commentid,index)" value="Reply!">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
var _ = require('lodash');
export default {
    props: ['commenturl', 'user'],
    data() {
        return {
            commented: {
                id: '',
                comment: '',
                votes: 0,
                spam: 0,
                reply_id: 0,
                page_id: 0,
                users_id: '',
                date: ''
            },
            comments: [],
            commentreplies: [],
            comments: 0,
            commentBoxs: [],
            message: null,
            replyCommentBoxs: [],
            commentsData: [],
            viewcomment: [],
            show: [],
            spamCommentsReply: [],
            spamComments: [],
            errorComment: null,
            errorReply: null
        }
    },
    http: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    },
    methods: {
        fetchComments() {
            self = this;
            axios.get('/comments/' + self.commenturl).then(res => {
                self.commentsData = _.orderBy(res.data, ['date'], ['desc']);
                self.comments = 1;
            });
        },
        // showComments(index) {
        //     if (!this.viewcomment[index]) {
        //         Vue.set(this.show, index, "hide");
        //         Vue.set(this.viewcomment, index, 1);
        //     } else {
        //         Vue.set(this.show, index, "view");
        //         Vue.set(this.viewcomment, index, 0);
        //     }
        // },
        openComment(index) {
            if (this.user) {
                if (this.commentBoxs[index]) {
                    Vue.set(this.commentBoxs, index, 0);
                } else {
                    Vue.set(this.commentBoxs, index, 1);
                }
            }

        },
        replyCommentBox(index) {
            if (this.user) {
                if (this.replyCommentBoxs[index]) {
                    Vue.set(this.replyCommentBoxs, index, 0);
                } else {
                    Vue.set(this.replyCommentBoxs, index, 1);
                }
            }

        },
        saveComment() {
            if (this.message != null && this.message != ' ') {
                this.errorComment = null;
                this.commented.page_id = this.commenturl;
                this.commented.comment = this.message;
                this.commented.users_id = this.user.id;
                this.$http.post('/comments', this.commented).then(res => {
                    if (res.data.status) {
                        this.commentsData.push({ "commentid": res.data.commentId, "name": this.user.name, "comment": this.message, "votes": 0, "reply": 0, "replies": [] });
                        this.message = null;
                    }
                });
            } else {
                this.errorComment = "Please enter a comment to save";
            }
        },
        replyComment(commentId, index) {
            if (this.message != null && this.message != ' ') {
                this.errorReply = null;
                let self = this;
                this.$http.post('/comments', {
                    comment: self.message,
                    users_id: self.user.id,
                    reply_id: commentId
                }).then(res => {
                    self.commentsData[index].replies.push({ "commentid": res.data.commentId, "name": self.user.name, "comment": self.message, "votes": 0 });
                    self.commentsData[index].reply = 1;
                    Vue.set(self.replyCommentBoxs, index, 0);
                    Vue.set(self.commentBoxs, index, 0);
                    self.message = null;
                });
            } else {
                this.errorReply = "Please enter a comment to save";
            }
        },
        voteComment(commentId, commentType, index, index2, voteType) {
            if (this.user) {
                let self = this;
                this.$http.post('/comments/' + commentId + '/vote', {
                    users_id: self.user.id,
                    vote: voteType
                }).then(res => {
                    if (commentType == 'directcomment') {
                        if (voteType == 'up') {
                            self.commentsData[index].votes++;
                        } else if (voteType == 'down') {
                            self.commentsData[index].votes--;
                        }
                    } else if (commentType == 'replycomment') {
                        if (voteType == 'up') {
                            self.commentsData[index].replies[index2].votes++;
                        } else if (voteType == 'down') {
                            self.commentsData[index].replies[index2].votes--;
                        }
                    }
                });
            }

        },
        spamComment(commentId, commentType, index, index2) {
            if (this.user) {
                this.$http.post('/comments/' + commentId + '/spam', {
                    users_id: this.user.id,
                }).then(res => {
                    if (commentType == 'directcomment') {
                        Vue.set(this.spamComments, index, 1);
                        Vue.set(this.viewcomment, index, 1);
                    } else if (commentType == 'replycomment') {
                        Vue.set(this.spamCommentsReply, index2, 1);
                    }
                });
            }
        },
    },
    mounted () {
        this.fetchComments();
    }
}
</script>