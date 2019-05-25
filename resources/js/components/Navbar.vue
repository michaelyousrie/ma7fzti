<template>
    <nav class="navbar navbar-expand-lg">
    
        <a class="navbar-brand" href="/">{{ application_name }}</a>

        <button class="navbar-toggler bg-dark text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fa fa-bars"></i></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li :class="{'nav-item': true, 'active': incomes.active}" @click="showIncomes">
                    <a href="#" class="nav-link">Incomes</a>
                </li>

                <li :class="{'active': expenses.active, 'nav-item': true}" @click="showExpenses">
                    <a href="#" class="nav-link">Expenses</a>
                </li>

                <li :class="{'active': profile.active, 'nav-item': true}" @click="showProfile">
                    <a href="#" class="nav-link">Profile</a>
                </li>
            </ul>

            <p>Welcome, <a href="#">{{first_name}}</a> <br> <span class="balance">( {{currency}} {{balance}} )</span></p>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",

        data() {
            return {
                application_name: window.application_name,

                expenses: {
                    active: false
                },

                incomes: {
                    active: true
                },

                profile: {
                    active: false
                }
            }
        },

        methods: {
            showIncomes() {
                this.$emit("showIncomes");
                this.$emit("hideExpenses");
                this.incomes.active = true;
                this.expenses.active = false;
                this.profile.active = false;
            },

            showExpenses() {
                this.$emit("hideIncomes");
                this.$emit("showExpenses");
                this.expenses.active = true;
                this.incomes.active = false;
                this.profile.active = false;
            },

            showProfile() {
                this.profile.active = true;
                this.expenses.active = false;
                this.incomes.active = false;
                return null;
            }
        },

        props: ['first_name', 'balance', 'currency'],
    }
</script>

<style>

</style>
