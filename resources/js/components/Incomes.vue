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
                <tr v-for="(income, index) in user.incomes" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ income.description }}</td>
                    <td>{{ income.when }}</td>
                    <td><span class="text-success">{{user.currency }} +{{ income.amount }}</span></td>
                    <td>
                        <button class="btn btn-xs btn-danger" @click="deleteIncome(income.id)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td></td><td></td><td></td>
                    <td class="text-secondary">{{ user.getTotalIncome() }}</td>
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
    
    data() {
        return {
            show: true,
        }
    },

    methods: {
        deleteIncome(id) {
            // 
        }
    }
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
