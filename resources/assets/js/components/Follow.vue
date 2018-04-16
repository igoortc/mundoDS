<template>
    <span>
        <notifications></notifications>
        <a href="#" v-if="isFollowed" @click.prevent="unfollow(user_id)">
            <i class="fa fa-heart"></i> <span>Followed!</span>
        </a>
        <a href="#" v-else @click.prevent="follow(user_id)">
            <i class="fa fa-heart-o"></i> <span>Follow!</span>
        </a>
    </span>
</template>

<script>
    export default {
        props: ['user_id', 'following_id'],

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
                return this.following_id;
            },
        },

        methods: {
            follow(user_id) {
                let self = this;
                axios.post('/follow/'+user_id)
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
            unfollow(user_id) {
                let self = this;
                axios.post('/unfollow/'+user_id)
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