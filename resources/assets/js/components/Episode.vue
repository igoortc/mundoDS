<template>
    <div id="app" class="episodeList">
        llll
        <ul>
            <li v-for="episode in episodes">
                {{ episode.season }} x {{ episode.number }} - {{ episode.name }}
            </li>
        </ul>            
    </div>
</template>

<script>
    export default {
        props: ['show'],

        data: function() {
            return {
                episode: {
                    id: '',
                    name: '',
                    season: '',
                    number: '',
                    synopsis: '',
                    date: ''
                },
                episodes: []
            }
        },
        mounted() {
            this.getEpisodes();
        },
        methods: {
            getEpisodes()
            {
                console.log('show'+this.show);
                axios.get('/api/shows/'+ this.show + '/episodes')
                    .then(response => {
                        console.log('/api/shows/'+ this.show + '/episodes');
                        console.log(response.data);
                        this.episodes = response.data;
                        console.log(this.episodes);
                    });
            }
        }
    }
</script>