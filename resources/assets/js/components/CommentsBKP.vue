<template>
    <div class="comments-app">
       <h1>Comments</h1>
       <div class="comment-form" v-if="user">
           <div class="comment-avatar">
               <img src="http://phpstack-21306-71265-194078.cloudwaysapps.com/lc/public/storage/commentbox.png">
           </div>
            <!-- Comentário inicial com usuário -->
           <form class="form" name="form">
               <div class="form-row">
                   <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                   <span class="input" v-if="errorComment" style="color:red">{{errorComment}}</span>
               </div>
               <div class="form-row">
                   <input class="input" placeholder="Email" type="text" disabled :value="user">
               </div>
               <div class="form-row">
                   <input type="button" class="btn btn-success" @click="saveComment" value="Add Comment">
               </div>
           </form>
       </div>
    <!-- Comentário sem usuário -->
       <div class="comment-form" v-else>
           <div class="comment-avatar">
               <img src="http://phpstack-21306-71265-194078.cloudwaysapps.com/lc/public/storage/commentbox.png">
           </div>
           <form class="form" name="form">
               <div class="form-row">
                   <a href="login"><textarea class="input" placeholder="Add comment..." required></textarea></a>
               </div>
           </form>
       </div>

       <div class="comments" v-if="comments" v-for="(comment,index) in commentsData" :key="index">
           <div v-if="!spamComments[index] || !comment.spam" class="comment">
               <div class="comment-avatar">
                   <img src="http://phpstack-21306-71265-194078.cloudwaysapps.com/lc/public/storage/commentbox.png">
               </div>
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
                               <li>Votes: {{comment.votes}}</li>
                               <li> | <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'up')">Up Votes</a></li>
                               <li> | <a v-if="!comment.votedByUser" v-on:click="voteComment(comment.commentid,'directcomment',index,0,'down')">Down Votes</a></li>
                               <li> | <a v-on:click="spamComment(comment.commentId,'directcomment',index,0)">Spam</a></li>
                               <li> | <a v-on:click="openComment(index)">Reply</a></li>
                           </ul>
                       </div>
                   </div>
               </div>
               <div class="comment-form comment-v" v-if="commentBoxs[index]">
                   <div class="comment-avatar">
                       <img src="http://phpstack-21306-71265-194078.cloudwaysapps.com/lc/public/storage/commentbox.png">
                   </div>
                   <form class="form" name="form">
                       <div class="form-row">
                           <textarea class="input" placeholder="Add a reply..." required v-model="reply"></textarea>
                           <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                       </div>
                       <div class="form-row">
                           <input type="button" class="btn btn-success" v-on:click="replyComment(comment.commentid,index)" value="Add reply">
                       </div>
                   </form>
               </div>
               <div v-if="comment.replies">
                   <div class="comments" v-for="(replies, index2) in comment.replies" :key="index2">
                       <div v-if="!spamCommentsReply[index2] || !replies.spam" class="comment reply">
                           <div class="comment-avatar">
                               <img src="http://phpstack-21306-71265-194078.cloudwaysapps.com/lc/public/storage/commentbox.png">
                           </div>
                           <div class="comment-box" style="background: grey;">
                               <div class="comment-text" style="color: white">{{replies.comment}}</div>
                               <div class="comment-footer">
                                   <div class="comment-info">
                                       <span class="comment-author">{{replies.name}}</span>
                                       <span class="comment-date">{{replies.date}}</span>
                                   </div>
                                   <div class="comment-actions">
                                       <ul class="list">
                                            <li>Total votes: {{replies.votes}}</li>
                                            <li> | <a v-if="!replies.votedByUser" v-on:click="voteComment(replies.commentid,'replycomment',index,index2,'up')">Up Votes</a></li>
                                            <li> | <a v-if="!replies.votedByUser" v-on:click="voteComment(comment.commentid,'replycomment',index,index2,'down')">Down Votes</a></li>
                                            <li> | <a v-on:click="spamComment(replies.commentid,'replycomment',index,index2)">Spam</a></li>
                                            <li> | <a v-on:click="replyCommentBox(index2)">Reply</a></li>
                                        </ul>
                                   </div>
                               </div>
                           </div>
                           <div class="comment-form reply" v-if="replyCommentBoxs[index2]">
                               <div class="comment-avatar">
                                   <img src="http://phpstack-21306-71265-194078.cloudwaysapps.com/lc/public/storage/commentbox.png">
                               </div>
                               <form class="form" name="form">
                                   <div class="form-row">
                                       <textarea class="input" placeholder="Add comment..." required v-model="message"></textarea>
                                       <span class="input" v-if="errorReply" style="color:red">{{errorReply}}</span>
                                   </div>
                                   <div class="form-row">
                                       <input class="input" placeholder="Email" type="text" :value="user">
                                   </div>
                                   <div class="form-row">
                                       <input type="button" class="btn btn-success" v-on:click="replyComment(comment.commentid,index)" value="Add Reply">
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
                episode_id: 0,
                users_id: '',
                date: ''
            },
            replied: {
                id: '',
                comment: '',
                votes: 0,
                spam: 0,
                reply_id: 0,
                episode_id: 0,
                users_id: '',
                date: ''
            },
            comments: [],
            commentreplies: [],
            comments: 0,
            commentBoxs: [],
            message: null,
            reply: null,
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
           'X-CSRF-TOKEN': window.csrf
       }
   },
    created : function() {
        this.fetchComments();
    },
   methods: {
        fetchComments() {
            self = this;
            axios.get('/comments/' + self.commenturl).then(res => {
                self.commentsData = _.orderBy(res.data, ['date'], ['desc']);
                self.comments = 1;
            });
        },
       showComments(index) {
           if (!this.viewcomment[index]) {
               Vue.set(this.show, index, "hide");
               Vue.set(this.viewcomment, index, 1);
           } else {
               Vue.set(this.show, index, "view");
               Vue.set(this.viewcomment, index, 0);
           }
       },
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
            if (this.message != null && this.message != ' ' && this.message != '') {
                this.errorComment = null;
                this.commented.episode_id = this.commenturl;
                this.commented.comment = this.message;
                this.commented.users_id = this.user;
                let self = this;
                axios.post('/comments', self.commented)
                    .then(function (response) {
                        self.$notify({
                            type: 'success',
                            title: "<i class='fa fa-smile-o'></i> Yay! You're talking about the show!",
                            text: 'You commented the episode!'
                        });
                        axios.get('/comments/' + self.commenturl).then(res => {
                            self.commentsData = _.orderBy(res.data, ['date'], ['desc']);
                            self.comments = 1;
                        });         
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to comment.'
                        });
                    });
           } else {
                self.$notify({
                    type: 'error',
                    title: "<i class='fa fa-frown-o'></i> You haven't written anything!",
                    text: 'Write something and submit again.'
                });
           }
       },
       replyComment(commentId, index) {
           if (this.reply != null && this.reply != ' ' && this.reply != '') {
                this.errorReply = null;
                this.replied.comment = this.reply;
                this.replied.users_id = this.user;
                this.replied.reply_id = commentId;
                this.replied.episode_id = this.commenturl;
                let self = this;
                axios.post('/comments', self.replied)
                    .then(function (response) {
                        if (!this.commentsData[index].reply) {
                           this.commentsData[index].replies.push({ "commentid": res.data.commentId, "name": this.user, "comment": this.message, "votes": 0 });
                           this.commentsData[index].reply = 1;
                           Vue.set(this.replyCommentBoxs, index, 0);
                           Vue.set(this.commentBoxs, index, 0);
                       } else {
                           this.commentsData[index].replies.push({ "commentid": res.data.commentId, "name": this.user, "comment": this.message, "votes": 0 });
                           Vue.set(this.replyCommentBoxs, index, 0);
                           Vue.set(this.commentBoxs, index, 0);
                       }
                       this.message = null;
                        self.$notify({
                            type: 'success',
                            title: "<i class='fa fa-smile-o'></i> Yay! You're interacting with other fans!",
                            text: 'You replied to the comment!'
                        });
                        axios.get('/comments/' + self.commenturl).then(res => {
                            self.commentsData = _.orderBy(res.data, ['date'], ['desc']);
                            self.comments = 1;
                        });         
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to comment.'
                        });
                    });
           } else {
                self.$notify({
                    type: 'error',
                    title: "<i class='fa fa-frown-o'></i> You haven't written anything!",
                    text: 'Write something and submit again.'
                });
           }
       },
       voteComment(commentId, commentType, index, index2, voteType) {
           if (this.user) {
               axios.post('/comments/' + commentId + '/vote', {
                   users_id: this.user.id,
                   vote: voteType
               }).then(res => {
                   if (res.data) {
                       if (commentType == 'directcomment') {
                           if (voteType == 'up') {
                               this.commentsData[index].votes++;
                           } else if (voteType == 'down') {
                               this.commentsData[index].votes--;
                           }
                       } else if (commentType == 'replycomment') {
                           if (voteType == 'up') {
                               this.commentsData[index].replies[index2].votes++;
                           } else if (voteType == 'down') {
                               this.commentsData[index].replies[index2].votes--;
                           }
                       }
                   }
               });
           }
       },
       spamComment(commentId, commentType, index, index2) {
           if (this.user) {
               axios.post('/comments/' + commentId + '/spam', {
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
}
</script>