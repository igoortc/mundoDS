<template>
    <div id="app" class="episodeList">
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
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            v-for="(episode, index) in episodes" 
                            :key="index"
                            v-if="episode.season===season">
                                <td>{{ episode.number }}</td>
                                <td>{{ episode.name }}</td>
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
                axios.get('/api/shows/'+ this.show + '/episodes')
                    .then(response => {
                        this.episodes = response.data.data;
                    });
            },
            getSeasons () {
                axios.get('/api/shows/'+ this.show)
                    .then(response => {
                        this.showSeasons = response.data.data.seasons;
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
            }
        }
    }
</script>