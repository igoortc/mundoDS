<template>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Manage reported content</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table v-if="comments.length > 0" style="width: 100%" class="manageContentTable">
                <thead>
                    <th>Comment</th>
                    <th>Author</th>
                    <th>Episode</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <tr v-for="(comment, index) in comments" :key="index">
                        <td>"{{ comment.comment }}"</td>
                        <td><a :href="'/user/' + comment.user_id.id">{{ comment.user_id.name }}</a></td>
                        <td class="text-center"><a :href="'/show/' + comment.episode_id.show_id + '/episode/' + comment.episode_id.id"><i class="fa fa-television"></i> <span class="hideMobile">Check</span></a></td>
                        <td class="text-center">
                            <a href="#" @click="destroySpam(comment.id)"><i class="fa fa-ban"></i> </a>  |  
                            <a href="#" @click="notSpam(comment)"><i class="fa fa-check"></i></a>
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
                parent_comment: '',
                page_id: '',
                users_id: ''
            },
            comments: []
        }
    },
    mounted() {
        this.getReportedContent()
    },
    methods: {
        getReportedContent() {
            axios.get('/spams')
                .then(response => {
                    this.comments = response.data.data
                })
                .catch(error => {
                    this.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to load comments. '
                    })
                })
        },
        destroySpam(comment) {
            axios.delete('/api/destroy_spam/' + comment)
                .then(response => {
                    this.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! The spam was deleted!',
                            text: 'The changes were updated in the database!'
                        })
                    setTimeout(() => {
                        window.location.href = "/"
                    }, 1000)
                })
                .catch(error => {
                    this.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to delete comment. '
                    })
                })
            this.getReportedContent()
        },
        notSpam(comment) {
            comment.spam = 0
            axios.put('/api/not_spam/' + comment.id, comment)
                .then(response => {
                    this.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! Not a spam!',
                            text: 'The comment was marked as not spam!'
                        })
                    setTimeout(() => {
                        window.location.href = "/"
                    }, 1000)
                })
                .catch(error => {
                    this.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to unflag comment. '
                    })
                })
            this.getReportedContent()
        }
    }
}
</script>