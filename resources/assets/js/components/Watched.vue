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
            v-on:click="set(rating, episode)" 
            v-on:mouseover="star_over(rating)" 
            v-on:mouseout="star_out">
            <input 
                class="radioStar" 
                type="radio" 
                :value="rating"
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
            this.getWatched();
        },
        methods: {
            watch(episode) {
                this.watched.user_id = this.user;
                this.watched.episode_id = episode;
                this.watched.rating = 0;
                let self = this;
                axios.post('/api/users/'+ self.watched.user_id + '/watches', self.watched)
                    .then(function (response) {
                        self.isWatched = true
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-smile-o"></i> Yay! This show seems awesome!',
                            text: 'You watched the episode!'
                        });
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Watch the episode failed.'
                        });
                    });
                this.getWatched();
            },
            unwatch(episode) {
                let watched_id = '';
                for (let i = 0; i < this.watchedEpisodes.length; i++) {
                    if (this.watchedEpisodes[i].episode_id === episode) {
                        watched_id = this.watchedEpisodes[i].id;
                    }
                }
                this.value = null;
                let self = this;
                axios.delete('/api/users/'+ self.user + '/watches/' + watched_id)
                    .then(function (response) { 
                        self.isWatched = false
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-ban"></i> You hated so much you even unwatched it?',
                            text: 'You unwatched the episode!'
                        });
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Unwatch the episode failed.'
                        });
                    });
            },
            getWatched() {
                let self = this;
                axios.get('/api/users/' + self.user + '/watches/')
                    .then(function (response) {
                        self.watchedEpisodes = response.data.data;
                        for (let i = 0; i < self.watchedEpisodes.length; i++) {
                            if (self.watchedEpisodes[i].episode_id === self.episode) {
                                self.watched = self.watchedEpisodes[i];
                                self.value = self.watchedEpisodes[i].rating;
                                self.isWatched = true;
                            }
                        }
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load watched episodes.'
                        });
                    });
            },
            star_over: function(index) {
                let self = this;
                this.temp_value = this.value;
                return this.value = index;
            },
            star_out: function() {
                let self = this;
                return this.value = this.temp_value;
            },
            set: function(value, episode) {
                this.temp_value = value;
                let watched_id = '';
                for (let i = 0; i < this.watchedEpisodes.length; i++) {
                    if (this.watchedEpisodes[i].episode_id === episode) {
                        watched_id = this.watchedEpisodes[i].id;
                    }
                }
                this.watched.rating = value;
                let self = this;
                axios.put('/api/users/'+ self.user + '/watches/' + watched_id + '?rating=' + self.watched.rating)
                    .then(function (response) {
                        self.isRated = true
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-star"></i> Stars... stars everywhere!',
                            text: 'You rated the episode!'
                        });
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Rating episode failed.'
                        });
                    });
                return self.value = value;
            }
        }
    }
</script>


