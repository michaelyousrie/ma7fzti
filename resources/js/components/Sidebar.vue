<template>
    <div id="sidebar">
        <br>
        <h3 class="title">Menu</h3>
        <br>
        <ul class="list-group">
            <li class="list-group-item" @click="showIncomes">Incomes</li>
            <li class="list-group-item" @click="showExpenses">Expenses</li>
            <li class="list-group-item">Income Categories</li>
            <li class="list-group-item">Expense Catgories</li>
            <!-- <br> -->
        </ul>
    </div>
</template>

<script>
export default {
    name: "Sidebar",

    props: ['balance', 'currency'],

    data() {
        return {
            // 
        }
    },

    methods: {
        showIncomes() {
            this.$emit("showIncomes");
            this.$emit("hideExpenses");
        },

        showExpenses() {
            this.$emit("hideIncomes");
            this.$emit("showExpenses");
        }
    }
}
</script>

<style>

</style>
