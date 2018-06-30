<template>
    <div class="edit-profile">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfile"><i class="fa fa-pencil-square-o"></i> Edit profile</button>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#closeAccount"><i class="fa fa-user-times"></i> Close account</button>
        <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="editUser" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><strong>Edit profile</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" v-model="user.name" required>
                            </div>
                            <div class="form-group">
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 np">
                                    <label for="photoProfile" class="col-form-label">Photo:</label>
                                    <input id="photoProfile" type="hidden" ref="photoProfile" class="form-control" name="photoProfile" v-model="user.photo">
                                    <image-upload></image-upload>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 np text-right">
                                    <img :src="user.photo" width="70px" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" v-model="user.email" disabled required>
                            </div>
                            <div class="form-group">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-l">
                                    <label for="city" class="col-form-label">City:</label>
                                    <input type="text" name="city" class="form-control" id="city" v-model="user.city">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-r">
                                    <label for="age" class="col-form-label">Date of birth:</label>
                                    <input type="text" class="form-control" id="email" v-model="user.age" disabled required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bio" class="col-form-label">Bio:</label>
                                <textarea class="form-control" id="bio"  v-model="user.bio" required></textarea>
                            </div>
                            <div class="form-group text-right">
                                <a type="button" class="btn btn-primary" @click="editUser">Edit profile!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="closeAccount" tabindex="-1" role="dialog" aria-labelledby="closeAccount" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Close your account?</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>We're sorry to see you go! <i class="fa fa-frown-o"></i></p>
                        <p>Are you sure you want to delete your account?</p>
                        <p>All of your information will be deleted and will not be available anymore.</p>
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
        data () {
            return {
                user: []
            }
        },
        mounted() {
            this.getUser();
        },
        methods: {
            getUser() {
                axios.get('/api/users/' + this.user_id)
                    .then(response => {
                        this.user = response.data.data
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load user information. '
                        })
                    })
            },
            editUser() {
                this.user.photo = this.$refs.photoProfile.value
                axios.put('/api/users/' + this.user_id, this.user)
                    .then(response => {
                        this.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! Your profile was updated!',
                            text: 'The changes were updated!'
                        })
                        $('.close').click()
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to update profile.'
                        })
                    })
            },
            deleteUser() {
                let self = this;
                axios.delete('/api/users/' + self.user_id)
                    .then(function (response) {
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-ban"></i> Wow! Bye!',
                            text: 'You deleted your profile!'
                        })
                        window.location.href = "/"
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to delete profile.'
                        })
                    })
            }
        }
    }
</script>