<template>
    <span>
        <a href="#" v-if="isWatched" @click.prevent="unwatch(episode)">
            <i  class="fa fa-eye-slash"></i>
        </a>
        <a href="#" v-else @click.prevent="watch(episode)">
            <i  class="fa fa-eye"></i>
        </a>
    </span>
</template>

<script>
    export default {
        props: ['episode', 'watched'],

        data: function() {
            return {
                isWatched: '',
            }
        },

        mounted() {
            this.isWatched = this.hasWatched ? true : false;
        },

        computed: {
            hasWatched() {
                return this.watched;
            },
        },

        methods: {
            watch(episode) {
                axios.post('/watch/'+episode)
                    .then(response => this.isWatched = true)
                    .catch(response => console.log(response.data));
            },

            unwatch(episode) {
                axios.post('/unwatch/'+episode)
                    .then(response => this.isWatched = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>