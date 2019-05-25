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
            >
            </Expenses>

            <Profile
                v-show="tabs.profile.show">
            </Profile>
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
                }
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
                this.totalIncome = this.user.getTotalIncome();

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

        getIncomeCategories() {
            return this.incomeCategories;
        },

        getCurrency() {
            return this.currency
        },

        getUserFirstName() {
            return this.user.first_name;
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
