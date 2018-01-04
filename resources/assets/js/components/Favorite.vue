<template>
    <span class="favorites">
        <a href="#" v-if="isFavorited" @click.prevent="unFavorite(show)">
            <i class="fa fa-heart"></i> <span>Favorited!</span>
        </a>
        <a href="#" v-else @click.prevent="favorite(show)">
            <i class="fa fa-heart-o"></i> <span>Favorite this show!</span>
        </a>
    </span>
</template>

<script>
    export default {
        props: ['show', 'favorited'],

        data: function() {
            return {
                isFavorited: '',
            }
        },

        mounted() {
            this.isFavorited = this.isFavorite ? true : false;
        },

        computed: {
            isFavorite() {
                return this.favorited;
            },
        },

        methods: {
            favorite(show) {
                axios.post('/favorite/'+show)
                    .then(response => this.isFavorited = true)
                    .catch(response => console.log(response.data));
            },

            unFavorite(show) {
                axios.post('/unfavorite/'+show)
                    .then(response => this.isFavorited = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>