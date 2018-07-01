<template>
    <div class="show-admin-actions">
        <fieldset>
            <legend><i class="fa fa-user-secret"></i> Admin actions</legend>
            <ul class="text-center">
                <li><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editEpisode"><i class="fa fa-pencil-square-o"></i> Edit episode</button></li>
                <li><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteEpisode"><i class="fa fa-trash"></i> Delete episode</button></li>
            </ul>
        </fieldset>
        <div class="modal fade" id="editEpisode" tabindex="-1" role="dialog" aria-labelledby="editEpisode" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><strong>Edit "{{ episode.name }}"</strong></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" v-model="episode.name" required>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-form-label">Image:</label>
                                <input id="image" type="hidden" ref="image" class="form-control" name="image" v-model="episode.image">
                                <image-upload 
                                    :thumb="episode.image"/>
                            </div>
                            <div class="form-group">
                                <label for="synopsis" class="col-form-label">Synopsis:</label>
                                <textarea class="form-control" id="synopsis"  v-model="episode.synopsis" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-l">
                                    <label for="seasons" class="col-form-label">Season:</label>
                                    <input type="number" class="form-control" id="seasons" v-model="episode.season" required>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 form-group np-r">
                                    <label for="status" class="col-form-label">Number:</label>
                                    <input type="number" class="form-control" id="number" v-model="episode.number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date_aired" class="col-form-label">Date aired:</label>
                                <input type="text" class="form-control" id="date_aired" disabled v-model="episode.date_aired">
                            </div>
                            <div class="form-group text-right">
                                <a type="button" class="btn btn-primary" @click="editEpisode">Edit episode!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteEpisode" tabindex="-1" role="dialog" aria-labelledby="deleteEpisode" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Delete "{{ episode.name }}"?</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this episode?</p>
                    </div>
                    <div class="modal-footer">
                        <form>
                            <button type="button" class="btn btn-danger" @click="deleteEpisode">Yes!</button>
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
        props: ['episode_id', 'show_id'],
        data: function() {
            return {
                episode: []
            }
        },
        mounted() {
            this.getEpisode();
        },
        methods: {
            getEpisode() {
                let self = this;
                axios.get('/api/shows/' + self.show_id + '/episodes/' + self.episode_id)
                    .then(function (response) {
                        self.episode = response.data.data
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Failed to load episode. '
                        });
                    });
            },
            editEpisode() {
                this.episode.image = this.$refs.image.value
                let self = this;
                axios.put('/api/shows/' + self.show_id + '/episodes/' + self.episode_id, self.episode)
                    .then(function (response) {
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! The episode was updated!',
                            text: 'The changes were updated in the database!'
                        });
                        $('.close').click()
                        setTimeout(() => {
                            location.reload()
                        }, 1000)
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to update episode.'
                        });
                    });
            },
            deleteEpisode() {
                let self = this;
                axios.delete('/api/shows/' + self.show_id + '/episodes/' + self.episode_id)
                    .then(function (response) {
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-ban"></i> Wow! You really deleted it!',
                            text: 'You deleted the episode!'
                        });
                        window.location.href = "/show/"+self.show_id;
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to delete episode.'
                        });
                    });
            }
        }
    }
</script>