<template>
    <span>
        <notifications></notifications>
        <a href="#" v-if="isFollowed" @click.prevent="unfollow(following)">
            <i class="fa fa-heart"></i> <span>Followed!</span>
        </a>
        <a href="#" v-else @click.prevent="follow(following)">
            <i class="fa fa-heart-o"></i> <span>Follow this person!</span>
        </a>
        follower: {{ follower }}
        following: {{ following }}
    </span>
</template>

<script>
    export default {
        props: ['follower', 'following'],

        data: function() {
            return {
                isFollowed: '',
            }
        },

        mounted() {
            this.isFollowed = this.hasFollowed ? true : false;
        },

        computed: {
            hasFollowed() {
                return this.following;
            },
        },

        methods: {
            follow(following) {
                let self = this;
                console.log('/follow/'+following);
                axios.post('/follow/'+following)
                    .then(function (response) { 
                        self.isFollowed = true;
                        self.$notify({
                            type: 'success',
                            title: '<i class="fa fa-heart"></i> Yay! New friends!',
                            text: 'You followed this person!'
                        });
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to follow this person.'
                        });
                    });
            },
            unfollow(following) {
                let self = this;
                console.log('/unfollow/'+following);
                axios.post('/unfollow/'+following)
                    .then(function (response) {
                        self.isFollowed = false;
                        self.$notify({
                            type: 'warn',
                            title: '<i class="fa fa-meh-o"></i> Okay... Have a nice life!',
                            text: 'You unfollowed this person!'
                        });
                    })
                    .catch(function (error) { 
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to unfollow this person.'
                        });
                    });
            }
        }
    }
</script>