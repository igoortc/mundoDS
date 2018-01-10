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
                <table class="table" v-if="hasEpisodes(season)">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th><i class="fa fa-star"></i></th>
                            <th>Date aired</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            v-for="(episode, index) in episodes" 
                            :key="index"
                            v-if="episode.season===season">
                                <td>{{ episode.number }}</td>
                                <td><a :href="'/show/' + episode.show_id + '/episode/' + episode.id">{{ episode.name }}</a></td>
                                <td>{{ average[index] }}</td>
                                <td>{{ episode.date_aired }}</td>
                                <td>
                                    <watched
                                        :episode="episode.id"
                                        :user="user"
                                    ></watched>
                                </td>
                        </tr>
                    </tbody>
                </table>
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
            this.getEpisodes();
            this.getSeasons();
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
                console.log('yayyy')
                console.log(episode)
                let self = this
                console.log('/avgEpisode/' + episode)
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