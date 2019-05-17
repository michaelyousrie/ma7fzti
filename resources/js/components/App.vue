<template>
    <div>
        <Navbar></Navbar>

        <Sidebar :balance="getBalance"
            @showIncomes="showIncomes(true)" 
            @hideIncomes="showIncomes(false)" 
            @showExpenses="showExpenses(true)"
            @hideExpenses="showExpenses(false)"
        >
        </Sidebar>

        <div class="content">
            <Incomes v-show="incomesTab.show" @updateBalance="updateBalance" :incomes="getIncomes" :currency="getCurrency" :totalIncome="getTotalIncome" :incomeCategories="getIncomeCategories"></Incomes>
            <Expenses v-show="expensesTab.show"></Expenses>
        </div>
    </div>
</template>

<script>

export default {
    name: "App",

    data() {
        return {
            incomesTab: {
                show: true
            },

            expensesTab: {
                show: false
            },

            balance: 0,
            totalIncome: 0,
            currency: null,
            incomes: [],
            expenses: [],
            incomeCategories: []
        }
    },

    methods: {
        showIncomes(bool) {
            this.incomesTab.show = bool;
        },

        showExpenses(bool) {
            this.expensesTab.show = bool;
        },

        getUser() {
            window.axios.get( window.makeUrl("userForFrontEnd") ).then(resp => {
                window.user = this.user = window.updateUserObject( resp.data.data.user );

                this.incomes = this.user.incomes;
                this.expenses = this.user.expenses;
                this.balance = this.user.balance;
                this.currency = this.user.currency;
                this.incomeCategories = this.user.income_categories;
                this.totalIncome = this.user.getTotalIncome();
            });
        },

        updateBalance(payload) {
            this.balance = payload.balance;
        }
    },

    computed: {
        getBalance() {
            return this.balance;
        },

        getIncomes() {
            return this.incomes;
        },

        getExpenses() {
            return this.expenses;
        },

        getCurrency() {
            return this.currency;
        },

        getTotalIncome() {
            return this.totalIncome;
        },

        getIncomeCategories() {
            return this.incomeCategories;
        }
    },

    created() {
        this.getUser();
    }
}
</script>


<style>
    .error-feedback-span {
        color: red;
    }
</style>
