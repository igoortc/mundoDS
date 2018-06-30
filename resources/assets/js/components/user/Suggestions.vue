<template>
    <span>
        <notifications></notifications>
        <div class="thumbnails" v-if="shows.length">
            <div v-for="(show, index) in shows" :key="index">
                <a :href="'/show/' + show.suggestion[0].id" ><img :src="show.suggestion[0].poster" /></a>
            </div>
        </div>
        <div v-else class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <p>We don't have any suggestions for you! <i class="fa fa-frown-o"></i></p>
            <p>Try favoriting some <a href="/all_shows">shows</a>!</p>
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
            this.getSuggestions();
        },
        methods: {
            getSuggestions()
            {
                axios.get('/user_suggestions/' + this.user)
                    .then(response => {
                        this.shows = response.data.data
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load suggestions. '
                        })
                    })
            }
        }
    }
</script>