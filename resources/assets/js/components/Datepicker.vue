<template>
    <div>
        <date-picker lang="en" v-model="dob" format="yyyy/MM/dd"></date-picker>
    </div>
</template>

<script>
    export default  {
        data () {
            return {
                dob: ''
            }
        },
        watch: { 
            'dob': function() {
                $('#dob').val(this.dob.toISOString().slice(0,10))
            } 
        }
    }

</script>