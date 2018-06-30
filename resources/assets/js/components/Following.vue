<template>
    <span>
        <notifications></notifications>
        ({{ count }})
        <div class="thumbnails">
            <div v-if="followingInfo.length === 0">
                No following! <i class="fa fa-frown-o"></i>
            </div>
            <div v-else v-for="(following, index) in followingInfo" :key="index">
                <a :href="'/user/' + following.id"> <img :src="following.photo"/></a>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        props: ['user'],

        data: function() {
            return {
                following: [],
                followingInfo: [],
                count: 0
            }
        },

        mounted()  {
            this.getFollowing()
        },

        methods: {
            getFollowing() {
                let following = []
                axios.get('/api/user/' + this.user + '/following/')
                    .then(response => {
                        following = response.data.data;
                        following.forEach(f => {
                            this.followingInfo.push(f.following)
                            this.count++
                        })
                    })
                    .catch(error => {
                        this.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load following.'
                        })
                    })
            }
        }
    }
</script>