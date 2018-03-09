<template>
    <div class="row">
        <div class="favoritesSlider" v-if="shows.length">
            <div v-for="show in shows">
                <a :href="'/show/' + show.id" ><img :src="show.poster" /></a>
            </div>
        </div>
        <div v-else class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <p>You have no favorite shows!</p>
            <p>Start <a href="/all_shows">browsing</a>!</p>
        </div>
    </div>
</template>

<script>
    import End from '../end'
    export default {
        props: ['user'],
        data: function() {
            return {
                shows: []
            }
        },
        mounted() {
            this.getFavorites();
        },
        methods: {
            getFavorites()
            {
                let self = this;
                axios.get(End.endpoint().api_default + '/dashFavorites/' + this.user)
                    .then(function (response) {
                        self.shows = response.data
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load the favorite shows. '
                        });
                    });
            }
        }
    }
</script>