<template>
    <div>
        <Navbar :user="getUser"></Navbar>
        <Sidebar :user="getUser" 
            @showIncomes="showIncomes(true)" 
            @hideIncomes="showIncomes(false)" 
            @showExpenses="showExpenses(true)"
            @hideExpenses="showExpenses(false)"
        >
        </Sidebar>

        <div class="content">
            <Incomes :user="getUser" v-show="incomes.show" @updateUser="updateUser"></Incomes>
            <Expenses :user="getUser" v-show="expenses.show"></Expenses>
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

        updateUser() {
            this.user = window.user;
        }
    },

    computed: {
        getUser() {
            return window.updateUserObject( this.user );
        }
    },

    props: ['user']
}
</script>


<style>

</style>
