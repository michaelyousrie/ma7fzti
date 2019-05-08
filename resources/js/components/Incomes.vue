<template>
    <div v-show="this.show">
        <h1>Incomes</h1>
    </div>
</template>

<script>
export default {
    name: "Incomes",

    props: ['user'],
    
    data() {
        return {
            show: true,
        }
    },

    methods: {
        
    }
}
</script>

<style>

</style>
