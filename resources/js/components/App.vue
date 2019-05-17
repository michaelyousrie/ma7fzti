<template>
    <div>
        <Loader v-show="showLoadingScreen"></Loader>

        <Navbar></Navbar>

        <Sidebar 
            @showIncomes="showIncomes(true)" @hideIncomes="showIncomes(false)"  @showExpenses="showExpenses(true)" @hideExpenses="showExpenses(false)"
            :balance="getBalance" 
        >
        </Sidebar>

        <div class="content">
            <Incomes 
                v-show="incomesTab.show" 
                @updateUser="updateUser" @showLoader="showLoader(true)" @hideLoader="showLoader(false)"
                :incomes="getIncomes" :currency="getCurrency" :totalIncome="getTotalIncome" :incomeCategories="getIncomeCategories"
            >
            </Incomes>

            <Expenses 
                v-show="expensesTab.show"
            >
            </Expenses>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            showLoadingScreen: true,

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
            var that = this;

            that.showLoader(true);

            window.axios.get( window.makeUrl("userForFrontEnd") ).then(resp => {
                window.user = this.user = window.updateUserObject( resp.data.data.user );

                this.incomes = this.user.incomes;
                this.expenses = this.user.expenses;
                this.balance = this.user.balance;
                this.currency = this.user.currency;
                this.incomeCategories = this.user.income_categories;
                this.totalIncome = this.user.getTotalIncome();

                that.showLoader(false);
            });
        },

        updateUser() {
            this.getUser();
        },

        showLoader(bool) {
            this.showLoadingScreen = bool;
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
