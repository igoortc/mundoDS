<template>
    <span>
        <notifications></notifications>
        ({{ count }}) test
        <div v-if="followingInfo.length === 0">
            No following!
        </div>
        <div v-else v-for="(following, index) in followingInfo" :key="index" class="friendship">
            <div>
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
            this.getFollowing();
        },

        methods: {
            getFollowing() {
                let self = this;
                let following = [];
                axios.get('/api/user/' + self.user + '/following/')
                    .then(function (response) {
                        following = response.data.data;
                        for (let i = 0; i < following.length; i++) {
                            axios.get('/api/users/' + following[i].following_id)
                            .then(function (response) {
                                self.followingInfo.push(response.data.data);
                                self.count++;
                            })
                            .catch(function (error) {
                                self.$notify({
                                    type: 'error',
                                    title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                                    text: 'Try reloading the page or contact the support! Failed to load following.'
                                });
                            });
                        }
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load following.'
                        });
                    });
            }
        }
    }
</script>