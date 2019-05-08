<template>
    <div v-show="this.show">
        <h1>Expenses</h1>
    </div>
</template>
    
<script>
export default {
    name: "Expenses",

    data() {
        return {
            show: false,
        }
    },

    props: ['user'],

    methods: {
        
    }
}
</script>

<style>

</style>
