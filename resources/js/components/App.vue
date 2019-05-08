<template>
    <div>
        <Navbar :user="this.getUser()"></Navbar>
        <Sidebar :user="this.getUser()" 
            @showIncomes="showIncomes(true)" 
            @hideIncomes="showIncomes(false)" 
            @showExpenses="showExpenses(true)"
            @hideExpenses="showExpenses(false)"
        >
        </Sidebar>

        <div class="content">
            <Incomes :user="this.getUser()" v-show="incomes.show"></Incomes>
            <Expenses :user="this.getUser()" v-show="expenses.show"></Expenses>
        </div>
    </div>
</template>

<script>

export default {
    name: "App",

    data() {
        return {
            incomes: {
                show: true
            },

            expenses: {
                show: false
            },

        }
    },

    methods: {
        showIncomes(bool) {
            this.incomes.show = bool;
        },

        showExpenses(bool) {
            this.expenses.show = bool;
        },

        getUser() {
            this.user.getBalance = function() {
                return this.currency + " " + this.balance;
            }

            return this.user;
        }
    },

    props: ['user']
}
</script>


<style>

</style>
