<template>
    <div class="row">
        <div class="favoritesSlider">
            <div v-for="show in shows">
                <a :href="'/show/' + show.id" ><img :src="show.poster" /></a>
            </div>
        </div>
    </div>
</template>

<script>
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
                axios.get('/dashFavorites/' + this.user)
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