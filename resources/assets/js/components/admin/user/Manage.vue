<template>
    <div>
        <fieldset>
            <legend><i class="fa fa-user-secret"></i> Admin actions</legend>
            <ul>
                <li v-if="user.admin===0">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#makeAdmin">
                        <i class="fa fa-user-secret"></i> Make admin
                    </button>
                </li>
                <li v-else>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#removeAdmin">
                        <i class="fa fa-user"></i> Remove admin priviledges
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser">
                        <i class="fa fa-trash"></i> Delete user
                    </button>
                </li>
            </ul>
        </fieldset>
        <div class="modal fade" id="makeAdmin" tabindex="-1" role="dialog" aria-labelledby="makeAdmin" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Make "{{ user.name }}" admin?</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to make this user an admin?</p>
                    </div>
                    <div class="modal-footer">
                        <form>
                            <button type="button" class="btn btn-danger" @click="makeAdmin">Yes!</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="removeAdmin" tabindex="-1" role="dialog" aria-labelledby="removeAdmin" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Remove {{ user.name }}'s admin priviledges?</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove this user's admin priviledges?</p>
                    </div>
                    <div class="modal-footer">
                        <form>
                            <button type="button" class="btn btn-danger" @click="removeAdmin">Yes!</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Delete "{{ user.name }}"?</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>
                    </div>
                    <div class="modal-footer">
                        <form>
                            <button type="button" class="btn btn-danger" @click="deleteUser">Yes!</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        data: function() {
            return {
                user: {
                    name: '',
                    password: '',
                    photo: '',
                    city: '',
                    bio: '',
                    admin: ''
                }
            }
        },
        mounted() {
            this.getUser();
        },
        methods: {
            getUser() {
                let self = this;
                axios.get('/api/users/' + self.user_id)
                    .then(function (response) {
                        self.user = response.data.data
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load user. '
                        });
                    });
            },
            removeAdmin() {
                this.user.admin = 0
                let self = this
                console.log(self.user)
                axios.put('/api/users/' + self.user.id, self.user)
                    .then(function (response) {
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-heart"></i> Wow! You really removed the priviledges!',
                            text: 'This user is not an admin anymore!'
                        });
                        $('.close').click()
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to remove admin priviledges.'
                        });
                    });
            },
            makeAdmin() {
                this.user.admin = 1
                let self = this
                console.log(self.user)
                axios.put('/api/users/' + self.user.id, self.user)
                    .then(function (response) {
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! The user is now an admin!',
                            text: 'This user now has priviledges of admin!'
                        });
                        $('.close').click()
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to make user admin.'
                        });
                    });
            },
            deleteUser() {
                let self = this;
                axios.delete('/api/users/' + self.user.id)
                    .then(function (response) {
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-ban"></i> Wow! You really deleted the user!',
                            text: 'You deleted the user!'
                        });
                        window.location.href = "/all_users";
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to delete user.'
                        });
                    });
            }
        }
    }
</script>