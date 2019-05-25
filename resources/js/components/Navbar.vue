<template>
    <nav class="navbar navbar-expand-lg">
    
        <a class="navbar-brand" href="/">{{ application_name }}</a>

        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                    </a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a v-for="(link, index) in links" :key="index" class="dropdown-item" :href="link.href">{{link.label}}</a>
                    </div>
                </li>

                <li class="nav-item" v-for="(item,index) in items" :key="index">
                    <a :href="item.href" class="nav-link">{{item.label}}</a>
                </li> -->

                <li :class="{'nav-item': true, 'active': incomes.active}" @click="showIncomes">
                    <a href="#" class="nav-link">Incomes</a>
                </li>

                <li :class="{'active': expenses.active, 'nav-item': true}" @click="showExpenses">
                    <a href="#" class="nav-link">Expenses</a>
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
                }
            }
        },

        methods: {
            showIncomes() {
                this.$emit("showIncomes");
                this.$emit("hideExpenses");
                this.expenses.active = false;
                this.incomes.active = true;
            },

            showExpenses() {
                this.$emit("hideIncomes");
                this.$emit("showExpenses");
                this.expenses.active = true;
                this.incomes.active = false;
            }
        },

        props: ['first_name', 'balance', 'currency'],
    }
</script>

<style>

</style>
