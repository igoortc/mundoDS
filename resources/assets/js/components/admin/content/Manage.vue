<template>
    <div class="modal-content">
        <notifications></notifications>
        <div class="modal-header">
            <h5 class="modal-title">Manage reported content</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table v-if="comments.length > 0" style="width: 100%">
                <thead>
                    <th>#</th>
                    <th>Comment</th>
                    <th>Author</th>
                    <th>Episode</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <tr v-for="comment in comments">
                        <td>{{ comment.id }}</td>
                        <td>"{{ comment.comment }}"</td>
                        <td><a :href="'/user/' + comment.users_id">Check</a></td>
                        <td><a :href="'/show/' + comment.page_id.charAt(0) + '/episode/' + comment.page_id">Check</a></td>
                        <td>
                            <a href="#" @click="destroySpam(comment.id)"><i class="fa fa-ban"></i> Destroy</a>  |  
                            <a href="#" @click="notSpam(comment)"><i class="fa fa-check"></i> Restore</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>There are no reported comments <i class="fa fa-smile-o"></i></p>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            comment: {
                id: '',
                comment: '',
                votes: '',
                spam: '',
                reply_id: '',
                page_id: '',
                users_id: ''
            },
            comments: []
        }
    },
    mounted() {
        this.getReportedContent();
    },
    methods: {
        getReportedContent() {
            let self = this;
            axios.get('/spam_comments')
                .then(function (response) {
                    self.comments = response.data
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to load comments. '
                    });
                });
        },
        destroySpam(comment) {
            axios.delete('/destroy_spam/' + comment)
                .then(function (response) {
                    self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! The spam was deleted!',
                            text: 'The changes were updated in the database!'
                        });
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to delete comment. '
                    });
                });
                // window.location.href = "/";
        },
        notSpam(comment) {
            console.log(comment)
            comment.spam = 0
            axios.put('/not_spam/' + comment.id, comment)
                .then(function (response) {
                    self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! Not a spam!',
                            text: 'The comment was marked as not spam!'
                        });
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to delete comment. '
                    });
                });
        }
    }
}
</script>