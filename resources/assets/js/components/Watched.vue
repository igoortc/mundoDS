<template>
    <span>
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
                axios.post('/api/users/'+ this.watched.user_id + '/watches', this.watched)
                    .then(response => this.isWatched = true)
                    .catch(response => console.log(response.data));
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
                axios.delete('/api/users/'+ this.user + '/watches/' + watched_id)
                    .then(response => this.isWatched = false)
                    .catch(response => console.log(response.data));
            },
            getWatched() {
                let self = this;
                axios.get('/api/users/' + self.user + '/watches/').then(response => {
                        self.watchedEpisodes = response.data.data;
                        for (let i = 0; i < self.watchedEpisodes.length; i++) {
                            if (self.watchedEpisodes[i].episode_id === self.episode) {
                                self.watched = self.watchedEpisodes[i];
                                self.value = self.watchedEpisodes[i].rating;
                                self.isWatched = true;
                            }
                        }
                    });
            },
            star_over: function(index) {
                var self = this;
                this.temp_value = this.value;
                return this.value = index;
            },
            star_out: function() {
                var self = this;
                return this.value = this.temp_value;
            },
            set: function(value, episode) {
                var self = this;
                this.temp_value = value;
                let watched_id = '';
                for (let i = 0; i < this.watchedEpisodes.length; i++) {
                    if (this.watchedEpisodes[i].episode_id === episode) {
                        watched_id = this.watchedEpisodes[i].id;
                    }
                }
                this.watched.rating = value;
                axios.put('/api/users/'+ this.user + '/watches/' + watched_id + '?rating=' + this.watched.rating)
                    .then(response => this.isRated = true)
                    .catch(response => console.log(response.data));
                return this.value = value;
            }
        }
    }
</script>


