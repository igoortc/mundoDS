<template>
    <div>
        <input type="text" v-model="search" v-on:keyup.enter="goTo" />
        <a type="button" :href="'/search/' + search" class="btn btn-primary" ref="clickSearch">Search!</a>
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