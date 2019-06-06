<template>
    <div>
        <div v-show="table.show">
            <h1 class="bb">
                Expenses
                
                <button class="btn btn-primary right" @click="showForm('add')"><i class="fa fa-plus"></i> Add Expense</button>
            </h1>
            
            <br>

            <table id="expensesTable" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Created</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(expense, index) in expenses" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{expense.id }}</td>
                        <td>{{ expense.description }}</td>
                        <td>{{ expense.category? expense.category.name : '-' }}</td>
                        <td>{{ expense.when }}</td>
                        <td><span class="text-danger">{{ currency }} -{{ expense.amount }}</span></td>
                        <td>
                            <button class="btn btn-xs btn-primary" @click="updateExpense(expense)"><i class="fa fa-edit"></i></button> &nbsp;
                            <button class="btn btn-xs btn-danger" @click="deleteExpense(expense.id)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Form-AddExpense
            v-if="this.forms.add.show"
            @showTable="showTable(true)" @updateUser="updateUser"
            :expenseCategories="expenseCategories"
        >
        </Form-AddExpense>
        <Form-EditExpense
            v-if="this.forms.update.show"
            @showTable="showTable(true)" @updateUser="updateUser"
            :expenseCategories="expenseCategories" :expense="getToBeUpdatedExpense"
        >
        </Form-EditExpense>
    </div>
</template>

<script>
export default {
    props: ['expenses', 'totalExpense', 'currency', 'expenseCategories'],
    
    data() {
        return {
            forms: {
                "add": {
                    show: false
                },

                "update": {
                    show: false
                }
            },

            table: {
                show: true
            },

            toBeUpdatedExpense: null
        }
    },

    methods: {
        showForm(form) {
            let entries = Object.entries(this.forms);
            this.table.show = false;

            for( const [key, value] of entries ) {
                if ( key == form ) {
                    this.forms[key].show = true;
                } else {
                    this.forms[key].show = false;
                }
            }
        },
        
        updateExpense(expense) {
            this.toBeUpdatedExpense = expense;
            this.showForm('update');
        },


        showTable(bool = true) {
            this.showForm(false);
            this.table.show = bool;
        },


        updateUser() {
            this.$emit('updateUser');
        },


        deleteExpense(id) {
            var that = this;

            window.Alert.confirm("Are you sure you want to delete this expense?", function() {
                that.$emit('showLoader');

                window.axios.delete( window.makeUrl( "/user/expenses/" + id ), [] ).then(resp => {
                    that.updateUser();
                    window.Alert.msg("Success!", "Expense deleted!");

                    that.$emit('hideLoader');
                }).catch(resp => {
                    window.ShowError();
                });
            });
        }
    },

    computed: {
        getToBeUpdatedExpense() {
            return this.toBeUpdatedExpense;
        }
    },

    updated() {
        window.InitDataTable( $('#expensesTable') );
    }
}
</script>

<style>

</style>
