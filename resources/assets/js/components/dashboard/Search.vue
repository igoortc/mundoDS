<template>
    <div class="search">
        <input type="text" v-model="search" v-on:keyup.enter="goTo" />
        <a :href="'/search/' + search" ref="clickSearch"><i class="fa fa-search"></i></a>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                search: ''
            }
        },

        methods: {
            goTo() {
                this.$refs.clickSearch.click()
            }
        }
    }
</script>