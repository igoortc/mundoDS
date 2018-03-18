<template>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Manage reported content</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table>
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
                        <td>{{ comment.comment }}</td>
                        <td><a :href="'/users/' + comment.users_id">Check</a></td>
                        <td><a :href="'/show/' + comment.page_id.charAt(0) + '/episode/' + comment.page_id">Check</a></td>
                        <td>
                            <a type="button" class="btn btn-danger" @click="destroySpam"><i class="fa fa-ban"></i></a>
                            <a type="button" class="btn btn-primary" @click="notSpam"><i class="fa fa-check"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        this.getUser();
    },
    methods: {
        getUser() {
            let self = this;
            axios.get('/spam_comments')
                .then(function (response) {
                    console.log(response.data)
                    self.comments = response.data
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Failed to load comments. '
                    });
                });
        }
    }
}
</script>