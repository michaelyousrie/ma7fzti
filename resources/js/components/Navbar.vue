<template>
    <nav class="navbar navbar-expand-lg">
    
        <a class="navbar-brand" href="/">{{ application_name }}</a>

        <button class="navbar-toggler bg-dark text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fa fa-bars"></i></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li v-for="(nav_item, index) in nav_items" :key="index" :class="{'nav-item': true, 'active': nav_item.active}" @click="nav_item.click()">
                    <a href="#" class="nav-link">{{nav_item.label}}</a>
                </li>

                <!-- <li :class="{'active': expenses.active, 'nav-item': true}" @click="showExpenses">
                    <a href="#" class="nav-link">Expenses</a>
                </li>

                <li :class="{'active': profile.active, 'nav-item': true}" @click="showProfile">
                    <a href="#" class="nav-link">Profile</a>
                </li> -->
            </ul>

            <div class="dropdown dropleft mr-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Welcome, {{ first_name }}
                </button>
                <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton">
                    <p class="text-center">Balance: <br> ({{ currency }} {{ balance }})</p>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout">Logout</a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",

        data() {
            var that = this;

            return {
                application_name: window.application_name,

                nav_items: {
                    "incomes": {
                        click() {
                            that.show("incomes");
                        },

                        label: "Incomes",
                        active: true
                    },

                    "expenses": {
                        click() {
                            that.show("expenses");
                        },
                        
                        label: "Expenses",
                        active: false
                    },

                    "income_categories": {
                        click() {
                            that.show('income_categories');
                        },

                        label: "Income Categories",
                        active: false
                    },
                    
                    "expense_categories": {
                        click() {
                            that.show('expense_categories');
                        },

                        label: "Expense Categories",
                        active: false
                    },

                    "profile": {
                        click() {
                            that.show("profile");
                        },

                        label: "Profile",
                        active: false
                    },
                },
            }
        },

        methods: {
            show(tab) {
                this.markActive(tab);
                this.$emit("showTab", {tab});
            },

            markActive(tab) {
                let entries = Object.entries(this.nav_items);
                
                for (const [key, value] of entries) {
                    if( key == tab ) {
                        this.nav_items[key].active = true;
                    } else {
                        this.nav_items[key].active = false;
                    }
                }
            }
        },

        props: ['first_name', 'balance', 'currency'],
    }
</script>

<style>

</style>
