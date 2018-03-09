<template>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create new show</h5>
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
                    <label for="poster" class="col-form-label">Poster:</label>
                    <input id="poster" type="hidden" ref="poster" class="form-control" name="poster">
                    <image-upload></image-upload>
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
                    <a type="button" class="btn btn-primary" @click="newShow">Create new show!</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import End from '../../end'
export default {
    data: function() {
        return {
            show: {
                id: '',
                name: '',
                poster: '',
                synopsis: '',
                seasons: '',
                status: '',
                netflix: '',
                imdb: '',
                date: '',
            }
        }
    },
    methods: {
        newShow() {
            this.show.poster = this.$refs.poster.value
            let self = this;
            axios.post(End.endpoint().api_default + '/api/shows/', self.show)
                .then(function (response) {
                    self.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Yay! A new show was created!',
                        text: 'The show was included in the database!'
                    });
                    $('.close').click()
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to create new show.'
                    });
                });
        }
    }
}
</script>