<template>
    <div class="modal-body">
        <form>
            <div class="form-group">
                <label for="name" class="col-form-label">Name:</label>
                <input type="text" class="form-control" id="name" v-model="episode.name" required>
            </div>
            <div class="form-group">
                <label for="image" class="col-form-label">Image:</label>
                <input id="image" type="hidden" ref="image" class="form-control" name="image">
                <image-upload
                    :thumb="episode.image" />
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
                <date-picker v-model="episode.date_aired" format="yyyy/MM/dd" lang="en"></date-picker>
            </div>
            <div class="form-group text-right">
                <a type="button" class="btn btn-primary" @click="newEpisode">Create new episode!</a>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['show_id'],

    data: function() {
        return {
            episode: {
                id: '',
                name: '',
                show_id: '',
                season: '',
                number: '',
                synopsis: '',
                date_aired: '',
                image: '',
            }
        }
    },
    methods: {
        newEpisode() {
            this.episode.image = this.$refs.image.value
            this.episode.show_id = this.show_id
            this.episode.id = this.show_id + this.episode.season + this.episode.number
            this.episode.date_aired = this.episode.date_aired.toISOString().split('T')[0]
            let self = this
            axios.post('/api/shows/' + self.show_id + '/episodes', self.episode)
                .then(function (response) {
                    self.$notify({
                        type: 'success',
                        title: '<i class="fa fa-heart"></i> Yay! A new episode was created!',
                        text: 'The episode was included in the database!'
                    })
                    $('.close').click()
                    setTimeout(() => {
                        location.reload()
                    }, 1000)
                })
                .catch(function (error) {
                    self.$notify({
                        type: 'error',
                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        text: 'Try reloading the page or contact the support! Failed to create new episode.'
                    })
                })
        }
    }
}
</script>