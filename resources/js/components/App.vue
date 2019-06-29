<template>
    <div>
        <Loader v-if="showLoadingScreen"></Loader>

        <Navbar
            @showTab="showTab"
            :first_name="getUserFirstName" :balance="getBalance" :currency="getCurrency"
        >
        </Navbar>

        <!-- <Sidebar 
            @showIncomes="showIncomes(true)" @hideIncomes="showIncomes(false)"  @showExpenses="showExpenses(true)" @hideExpenses="showExpenses(false)"
            :balance="getBalance" :currency="getCurrency"
        >
        </Sidebar> -->

        <div class="content">
            <Incomes 
                v-show="tabs.incomes.show" 
                @updateUser="updateUser" @showLoader="showLoader(true)" @hideLoader="showLoader(false)"
                :incomes="getIncomes" :currency="getCurrency" :totalIncome="getTotalIncome" :incomeCategories="getIncomeCategories"
            >
            </Incomes>

            <Expenses 
                v-show="tabs.expenses.show"
                @updateUser="updateUser" @showLoader="showLoader(true)" @hideLoader="showLoader(false)"
                :expenses="getExpenses" :currency="getCurrency" :totalExpense="getTotalExpense" :expenseCategories="getExpenseCategories"
            >
            </Expenses>

            <Profile
                v-show="tabs.profile.show"
                @updateUser="updateUser" @showLoader="showLoader(true)" @hideLoader="showLoader(false)"
                :user="getUserData"
            >
            </Profile>

            <IncomeCategories
                v-show="tabs.income_categories.show"
                @updateUser="updateUser" @showLoader="showLoader(true)" @hideLoader="showLoader(false)"
                :user="getUserData"
            >
            </IncomeCategories>

            <ExpenseCategories
                v-show="tabs.expense_categories.show"
                @updateUser="updateUser" @showLoader="showLoader(true)" @hideLoader="showLoader(false)"
                :user="getUserData"
            >
            </ExpenseCategories>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            showLoadingScreen: true,

            user: {
                "first_name": "User",
                "last_name": "User"
            },

            tabs: {
                incomes: {
                    show: true
                },

                expenses: {
                    show: false
                },

                profile: {
                    show: false
                },

                income_categories: {
                    show: false
                },

                expense_categories: {
                    show: false
                }
            },

            balance: 0,
            totalIncome: 0,
            currency: null,
            incomes: [],
            expenses: [],
            incomeCategories: [],
            expenseCategories: []
        }
    },

    methods: {
        showTab(payload) {
            let tab = payload.tab;
            let entries = Object.entries(this.tabs);

            for( const [element, value] of entries ) {
                if ( element == tab ) {
                    this.tabs[element].show = true;
                } else {
                    this.tabs[element].show = false;
                }
            }
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
                this.expenseCategories = this.user.expense_categories;
                this.totalIncome = this.user.getTotalIncome();
                this.totalExpense = this.user.getTotalExpense();

                that.showLoader(false);
            }).catch(error => {
                window.ShowError();
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

        getTotalExpense() {
            return this.totalExpense;
        },

        getIncomeCategories() {
            return this.incomeCategories;
        },

        getExpenseCategories() {
            return this.expenseCategories;
        },

        getCurrency() {
            return this.currency
        },

        getUserFirstName() {
            return this.user.first_name;
        },

        getUserData() {
            return this.user;
        },
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
