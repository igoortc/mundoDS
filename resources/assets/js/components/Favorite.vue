<template>
    <span class="favorites">
        <notifications></notifications>
        <a href="#" v-if="isFavorited" @click.prevent="unFavorite(show)">
            <i class="fa fa-heart"></i> <span>Favorited!</span>
        </a>
        <a href="#" v-else @click.prevent="favorite(show)">
            <!-- <div class="row">
                <vue-star animate="animated bounceIn" color="#F05654">
                    <i slot="icon" class="fa fa-heart"></i>
                </vue-star> 
            </div> -->
            <i class="fa fa-heart-o"></i> <span>Favorite this show!</span>
        </a>
    </span>
</template>

<script>
    import End from './end'
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
                let self = this;
                axios.post(End.endpoint().api_default + '/favorite/'+show)
                    .then(function (response) { 
                        self.isFavorited = true;
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! A new favorite!',
                            text: 'You favorited this show!'
                        });
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to favorite the show.'
                        });
                    });
            },
            unFavorite(show) {
                let self = this;
                axios.post(End.endpoint().api_default + '/unfavorite/'+show)
                    .then(function (response) {
                        self.isFavorited = false;
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-meh-o"></i> Okay... Have a nice life!',
                            text: 'You unfavorited this show!'
                        });
                    })
                    .catch(function (error) { 
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to unfavorite the show.'
                        });
                    });
            }
        }
    }
</script>