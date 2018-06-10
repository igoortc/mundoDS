<template>
    <div id="app" class="episodeList">
        <notifications></notifications>
        <ul class="nav nav-pills">
            <li 
                v-for="(season, index) in showSeasons"
                :key="index" 
                :class="{ active: isActive('T' + season) }" 
                @click="setActive('T' + season)">
                    <a data-toggle="pill" :href="'#T' + season">T {{ season }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div 
                v-for="(season, index) in showSeasons" 
                :key="index" 
                :id="'T' + season" 
                class="tab-pane" 
                :class="{ active: isActive('T' + season) }">
                <div class="seasonEpisodes" v-if="hasEpisodes(season)">
                    <div class="row header">
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <strong>#</strong>
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-9">
                            <strong>Title</strong>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-2 text-center">
                            <strong><i class="fa fa-star"></i></strong>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 hideMobile">
                            <strong>Date</strong>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-4 hideMobile">
                            <strong>Actions</strong>
                        </div>
                    </div>
                    <div 
                        class="row body"
                        v-for="(episode, index) in episodes" 
                        :key="index"
                        v-if="episode.season===season">
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <span>{{ episode.number }}</span>
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-9">
                            <span><a :href="'/show/' + episode.show_id + '/episode/' + episode.id">{{ episode.name }}</a></span>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-2 text-center">
                            <span>{{ average[index] }}</span>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-4 offset-1-mob">
                            <span>{{ episode.date_aired }}</span>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-7">
                            <span>
                                <watched
                                    :episode="episode.id"
                                    :user="user"
                                ></watched>
                            </span>
                        </div>
                    </div>
                </div>
                <span v-else>No episodes of this season have aired yet!</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['show', 'user'],

        data: function() {
            return {
                episode: {
                    id: '',
                    name: '',
                    season: '',
                    number: '',
                    synopsis: '',
                    date: '',
                },
                average: [],
                episodes: [],
                showSeasons: '',
                activeSeason: 'T1',
            }
        },
        mounted() {
            this.getEpisodes()
            this.getSeasons()
        },
        created() {
          this.startSeason();  
        },
        methods: {
            getEpisodes()
            {
                let self = this;
                axios.get('/api/shows/'+ this.show + '/episodes')
                    .then(function (response) {
                        self.episodes = response.data.data
                        for (let i = 0; i< self.episodes.length; i++) {
                            axios.get('/avgEpisode/' + self.episodes[i].id)
                                .then(function (response) {
                                    self.average.push(response.data)
                                })
                                .catch(function (error) {
                                    self.$notify({
                                        type: 'error',
                                        title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                                        text: 'Try reloading the page or contact the support! Failed to load the episodes. '
                                    });
                                });
                        }
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load the episodes. '
                        });
                    });
            },
            getSeasons () {
                let self = this;
                axios.get('/api/shows/'+ this.show)
                    .then(function (response) {
                        self.showSeasons = response.data.data.seasons;
                    })
                    .catch(function (error) { 
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load the seasons of the show.'
                        });
                    });
            },
            isActive (menuItem) {
                return this.activeSeason === menuItem
            },
            setActive (menuItem) {
                this.activeSeason = menuItem
            },
            startSeason () {
                this.activeSeason = 'T1'
            },
            hasEpisodes (season) {
                for (let i = 0; i < this.episodes.length; i++) {
                    if (this.episodes[i].season === season) {
                        return true;
                    }
                }
            },
            getAverage (episode, index) {
                let self = this
                axios.get('/avgEpisode/' + episode)
                    .then(function (response) {
                        self.average[index] = response.data.data
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load the episodes. '
                        });
                    });
            }
        }
    }
</script>