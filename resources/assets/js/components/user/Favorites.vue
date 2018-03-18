<template>
    <span>
        <notifications></notifications>
        <div class="friendship">
            <div v-if="shows.length === 0">
                No favorite shows! <i class="fa fa-frown-o"></i>
            </div>
            <div v-else v-for="show in shows">
                <a :href="'/show/' + show.id" ><img :src="show.poster" /></a>
            </div>
        </div>
    </span>
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