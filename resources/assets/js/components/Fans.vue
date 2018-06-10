<template>
    <span>
        <notifications></notifications>
        <div class="thumbnails">
            <h4>Fans</h4>
            <div v-if="fans.length === 0">
                This show does not have fans yet! <i class="fa fa-frown-o"></i>
            </div>
            <div v-else v-for="(fan, index) in fans" :key="index">
                <a :href="'/user/' + fan.user.id"> <img :src="fan.user.photo"/></a>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        props: ['show_id'],

        data: function() {
            return {
                fans: []
            }
        },

        mounted()  {
            this.getFans()
        },

        methods: {
            getFans() {
                axios.get('/fans/' + this.show_id)
                    .then((response) => {
                        this.fans = response.data.data
                    })
                    .catch(function (error) {
                        self.$notify({
                            type: 'error',
                            title: '<i class="fa fa-frown-o"></i> Uh oh! Error: ' + error.response.status + ' - ' + error.response.statusText,
                            text: 'Try reloading the page or contact the support! Failed to load fans.'
                        })
                    })
            }
        }
    }
</script>