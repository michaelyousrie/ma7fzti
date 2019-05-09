<template>
    <div id="sidebar">
        <br>
        <h3>Menu</h3>
        <hr><br>
        <ul class="list-group">
            <li class="list-group-item" @click="showIncomes">Incomes</li>
            <li class="list-group-item" @click="showExpenses">Expenses</li>
        </ul>
        <br>
        <hr class="bg-light">
        <p><b>Balance:</b> <i class="text-success">{{ user.getBalance() }}</i></p>
    </div>
</template>

<script>
export default {
    name: "Sidebar",

    props: ['user'],

    data() {
        return {

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
    #sidebar {
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        background-color: #F8F9FA;
        height: calc(100vh - 75px);
        width: 250px;
        text-align: center;
        border-right: 1px solid #e8e8e8;
        float: left;
    }

    .list-group-item:hover {
        cursor: pointer;
        background: #dddddd;
    }

    .list-group-item {
        border-top: none;
        border-left:none;
        border-right:none;
        margin-top: 10px;
        padding: 10px;
    }
</style>
