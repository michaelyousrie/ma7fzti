<template>
    <div v-show="this.show">
        <h1 class="center bb">Incomes</h1>

        <br>

        <table class="table table-dark table-striped">
            <thead>
                <th>#</th>
                <th>description</th>
                <th>Created</th>
                <th>amount</th>
                <th></th>
            </thead>

            <tbody>
                <tr v-for="(income, index) in getUserIncomes" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ income.description }}</td>
                    <td>{{ income.when }}</td>
                    <td><span class="text-success">{{user.currency }} +{{ income.amount }}</span></td>
                    <td>
                        <button class="btn btn-xs btn-danger" @click="deleteIncome(income.id)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <tr class="bg-info">
                    <td></td><td></td><td></td>
                    <td>{{ user.getTotalIncome() }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Incomes",

    props: ['user'],

    created() {
        this.incomes = this.user.incomes;
        this.balance = this.user.balance;
    },
    
    data() {
        return {
            show: true,
            incomes: [],
            balance: 0,
        }
    },

    methods: {
        deleteIncome(id) {
            window.axios.delete( window.makeUrl( "/user/incomes/" + id ), [] ).then(resp => {
                this.user = window.user = window.updateUserObject( resp.data.user );
            });
        }
    },

    computed: {
        getUserIncomes() {
            return this.user.incomes;
        },

        getUserBalance() {
            return this.balance;
        },
    },
}
</script>

<style>
    .center {
        text-align: center;
    }

    .bb {
        border-bottom: 1px solid #e8e8e8;
        width: 90%;
        padding-bottom: 10px;
        margin-left: 5%;
    }
</style>
