<template>
    <div class="show-admin-actions">
        <fieldset>
            <legend><i class="fa fa-user-secret"></i> Admin actions</legend>
            <ul class="text-center">
                <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editShow"><i class="fa fa-pencil-square-o"></i> Edit show</button></li>
                <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewEpisode"><i class="fa fa-plus-square"></i> New episode</button></li>
                <li><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteShow"><i class="fa fa-trash"></i> Delete show</button></li>
            </ul>
        </fieldset>
        <div class="modal fade" id="editShow" tabindex="-1" role="dialog" aria-labelledby="editShow" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><strong>Edit "{{ show.name }}"</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" v-model="show.name" required>
                            </div>
                            <div class="form-group">
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 np">
                                    <label for="poster" class="col-form-label">Poster:</label>
                                    <input id="poster" type="hidden" ref="poster" class="form-control" name="poster" v-model="show.poster">
                                    <image-upload></image-upload>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 np text-right">
                                    <img :src="show.poster" width="50px" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="synopsis" class="col-form-label">Synopsis:</label>
                                <textarea class="form-control" id="synopsis"  v-model="show.synopsis" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-l">
                                    <label for="seasons" class="col-form-label">Seasons:</label>
                                    <input type="number" class="form-control" id="seasons" v-model="show.seasons" required>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-r">
                                    <label for="status" class="col-form-label">Status:</label>
                                    <select id="status" class="form-control"  v-model="show.status" required>
                                        <option selected>Choose...</option>
                                        <option value="E">On air</option>
                                        <option value="F">Finished</option>
                                        <option value="W">To be released</option>
                                        <option value="B">Binge</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-l">
                                    <label for="seasons" class="col-form-label">Netflix:</label>
                                    <input type="text" class="form-control" id="netflix"  v-model="show.netflix">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-r">
                                    <label for="status" class="col-form-label">IMDb:</label>
                                    <input type="text" class="form-control" id="imdb" v-model="show.imdb">
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <a type="button" class="btn btn-primary" @click="editShow">Edit show!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewEpisode" tabindex="-1" role="dialog" aria-labelledby="addNewEpisode" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><strong>Add new episode to "{{ show.name }}"</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <episode-create :show_id="show.id"></episode-create>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteShow" tabindex="-1" role="dialog" aria-labelledby="deleteShow" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Delete "{{ show.name }}"?</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this show?</p>
                    </div>
                    <div class="modal-footer">
                        <form>
                            <button type="button" class="btn btn-danger" @click="deleteShow">Yes!</button>
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
        props: ['show_id'],
        data: function() {
            return {
                show: []
            }
        },
        mounted() {
            this.getShows();
        },
        methods: {
            getShows() {
                let self = this;
                axios.get('/api/shows/' + self.show_id)
                    .then(function (response) {
                        self.show = response.data.data
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load show. '
                        });
                    });
            },
            editShow() {
                this.show.poster = this.$refs.poster.value
                let self = this;
                axios.put('/api/shows/' + self.show_id, self.show)
                    .then(function (response) {
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! The show was updated!',
                            text: 'The changes were updated in the database!'
                        });
                        $('.close').click()
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to update show.'
                        });
                    });
            },
            deleteShow() {
                let self = this;
                axios.delete('/api/shows/' + self.show_id)
                    .then(function (response) {
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-ban"></i> Wow! You really deleted it!',
                            text: 'You deleted the show!'
                        });
                        window.location.href = "/all_shows";
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to delete show.'
                        });
                    });
            }
        }
    }
</script>