<template>
    <span>
        <notifications></notifications>
        <a href="#" v-if="isWatched" @click.prevent="unwatch(episode)">
            <i class="fa fa-eye-slash"></i>
        </a>
        <a href="#" v-else @click.prevent="watch(episode)">
            <i class="fa fa-eye"></i>
        </a>
        <label 
            class="star" 
            v-for="(rating, index) in ratings"
            :key="index"
            :class="{'is-selected': ((value >= rating) && value != null), 'disabledStar': !isWatched}"
            v-on:mouseover="star_over(rating)" 
            v-on:mouseout="star_out">
            <input 
                class="radioStar" 
                type="radio" 
                :value="rating"
                @click="set(rating, episode)"
                v-model="value"><i class="fa" :class="{'fa-star': ((value >= rating) && value != null), 'fa-star-o': ((value < rating) || value == null)}"></i>
        </label>
    </span>
</template>

<script>
    export default {
        props: ['episode', 'user'],

        data: function() {
            return {
                watched: {
                    id: '',
                    user_id: '',
                    episode_id: '',
                    rating: '',
                    date: '',
                },
                isWatched: '',
                ratings: [1, 2, 3, 4, 5],
                value: null,
                watchedEpisodes: [],
                isRated: ''
            }
        },
        created : function() {
            this.getWatched()
        },
        mounted () {
            database.ref('/watches').on('value', snapshot => {
                this.getWatched()
            })
        },
        methods: {
            watch (episode) {
                this.watched.user_id = this.user
                this.watched.episode_id = episode
                this.watched.rating = 0
                axios.post('/api/users/'+ this.watched.user_id + '/watches', this.watched)
                    .then(response => {
                        this.isWatched = true
                        this.$notify({
                            type: 'success',
                            title: '<i class="fa fa-smile-o"></i> Yay! This show seems awesome!',
                            text: 'You watched the episode!'
                        });
                    })
                    .catch(error => {
                        console.log(error)
                        // this.$notify({
                        //     type: 'error',
                        //     title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        //     text: 'Try reloading the page or contact the support! Watch the episode failed.'
                        // })
                    })
                this.getWatched()
            },
            unwatch (episode) {
                let watched_id = ''
                for (let i = 0; i < this.watchedEpisodes.length; i++) {
                    if (this.watchedEpisodes[i].episode_id === episode) {
                        watched_id = this.watchedEpisodes[i].id;
                    }
                }
                this.value = null;
                axios.delete('/api/users/'+ this.user + '/watches/' + watched_id)
                    .then(response => { 
                        this.isWatched = false
                        this.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-ban"></i> You hated so much you even unwatched it?',
                            text: 'You unwatched the episode!'
                        })
                    })
                    .catch(error => {
                        console.log(error)
                        // this.$notify({
                        //     type: 'error',
                        //     title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        //     text: 'Try reloading the page or contact the support! Unwatch the episode failed.'
                        // })
                    })
            },
            getWatched () {
                axios.get('/api/users/' + this.user + '/watches/')
                    .then(response => {
                        this.watchedEpisodes = response.data.data;
                        for (let i = 0; i < this.watchedEpisodes.length; i++) {
                            if (this.watchedEpisodes[i].episode_id === this.episode) {
                                this.watched = this.watchedEpisodes[i];
                                this.value = this.watchedEpisodes[i].rating;
                                this.isWatched = true;
                            }
                        }
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load watched episodes.'
                        })
                    })
            },
            star_over (index) {
                this.temp_value = this.value
                return this.value = index
            },
            star_out () {
                return this.value = this.temp_value
            },
            set (value, episode) {
                this.temp_value = value;
                // let watched_id = ''
                // for (let i = 0; i < this.watchedEpisodes.length; i++) {
                //     if (this.watchedEpisodes[i].episode_id === episode) {
                //         watched_id = this.watchedEpisodes[i].id
                //     }
                // }
                // console.log(this.watched, episode, watched_id)
                this.watched.rating = value
                axios.put('/api/users/'+ this.user + '/watches/' + this.watched.id, {rating: this.watched.rating})
                    .then(response => {
                        this.isRated = true
                        this.$notify({
                            type: 'success',
                            title: '<i class="fa fa-star"></i> Stars... stars everywhere!',
                            text: 'You rated the episode!'
                        })
                    })
                    .catch(error => {
                        console.log(error)
                        // this.$notify({
                        //     type: 'error',
                        //     title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                        //     text: 'Try reloading the page or contact the support! Rating episode failed.'
                        // })
                    })
                return this.value = value;
            }
        }
    }
</script>


