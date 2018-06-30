<template>
    <span>
        <notifications></notifications>
        ({{ count }})
        <div class="thumbnails">
            <div v-if="followersInfo.length === 0">
                No followers! <i class="fa fa-frown-o"></i>
            </div>
            <div v-else v-for="(follower, index) in followersInfo" :key="index">
                <a :href="'/user/' + follower.id"> <img :src="follower.photo"/> </a>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        props: ['user'],

        data: function() {
            return {
                followers: [],
                followersInfo: [],
                count: 0
            }
        },

        mounted()  {
            this.getFollowers()
        },

        methods: {
            getFollowers() {
                let followers = []
                axios.get('/api/user/' + this.user + '/followers/')
                    .then(response => {
                        followers = response.data.data
                        followers.forEach(f => {
                            this.followersInfo.push(f.user)
                            this.count++
                        })
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load followers.'
                        })
                    })
            }
        }
    }
</script>