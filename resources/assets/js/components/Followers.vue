<template>
    <span>
        <notifications></notifications>
        ({{ count }})
        <div v-if="followersInfo.length === 0">
            No followers! <i class="fa fa-frown-o"></i>
        </div>
        <div v-else v-for="(follower, index) in followersInfo" :key="index" class="friendship">
            <div>
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
            this.getFollowers();
        },

        methods: {
            getFollowers() {
                let self = this;
                let followers = [];
                this.$http.get('/api/user/' + self.user + '/followers/')
                    .then(function (response) {
                        followers = response.data.data;
                        for (let i = 0; i < followers.length; i++) {
                            this.$http.get('/api/users/' + followers[i].user_id)
                            .then(function (response) {
                                self.followersInfo.push(response.data.data);
                                self.count++;
                            })
                            .catch(function (error) {
                                self.$notify({
                                    type: 'error',
                                    title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                                    text: 'Try reloading the page or contact the support! Failed to load followers.'
                                });
                            });
                        }
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load followers.'
                        });
                    });
            }
        }
    }
</script>