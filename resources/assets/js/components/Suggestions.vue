<template>
    <span>
        <notifications></notifications>
        <div class="thumbnails">
            <h4>Related shows</h4>
            <div v-if="suggestions.length === 0">
                No related shows were found! <i class="fa fa-frown-o"></i>
            </div>
            <div v-else v-for="(suggestion, index) in suggestions" :key="index">
                <a :href="'/show/' + suggestion.suggestion[0].id"> <img :src="suggestion.suggestion[0].poster"/></a>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        props: ['show_id'],

        data: function() {
            return {
                suggestions: []
            }
        },

        mounted()  {
            this.getSuggestions()
        },

        methods: {
            getSuggestions() {
                axios.get('/api/suggestions/' + this.show_id)
                    .then((response) => {
                        this.suggestions = response.data.data
                    })
                    .catch(function (error) {
                        console.log('error', error)
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load suggestions.'
                        })
                    })
            }
        }
    }
</script>