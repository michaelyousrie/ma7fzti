<template>
    <div>
        <div v-show="table.show">
            <h1 class="bb">
                Incomes
                
                <button class="btn btn-primary right" @click="showForm('add')"><i class="fa fa-plus"></i> Add Income</button>
            </h1>
            
            <br>

            <table class="table table-dark table-striped">
                <thead>
                    <th>#</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Created</th>
                    <th>Amount</th>
                    <th></th>
                </thead>

                <tbody>
                    <tr v-for="(income, index) in incomes" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ income.description }}</td>
                        <td>{{ income.category? income.category.name : '-' }}</td>
                        <td>{{ income.when }}</td>
                        <td><span class="text-success">{{ currency }} +{{ income.amount }}</span></td>
                        <td>
                            <button class="btn btn-xs btn-primary" @click="showUpdateIncomeForm(income)"><i class="fa fa-edit"></i></button> &nbsp;
                            <button class="btn btn-xs btn-danger" @click="deleteIncome(income.id)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="tr-sum">
                        <td></td><td></td><td></td><td></td>
                        <td>{{ this.totalIncome }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Form-AddIncome
            v-show="this.forms.add.show"
            @showTable="showTable(true)" @updateUser="updateUser"
            :incomeCategories="incomeCategories"
        >
        </Form-AddIncome>
        <Form-EditIncome
            v-show="this.forms.edit.show"
            @updateUser="updateUser"
            :incomeCategories="incomeCategories"
        >
        </Form-EditIncome>
    </div>
</template>

<script>
export default {
    props: ['incomes', 'totalIncome', 'currency', 'incomeCategories'],
    
    data() {
        return {
            forms: {
                "add": {
                    show: false
                },

                "edit": {
                    show: false
                }
            },

            table: {
                show: true
            }
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


        showTable(bool = true) {
            this.showForm(false);
            this.table.show = bool;
        },


        updateUser() {
            this.$emit('updateUser');
        },


        deleteIncome(id) {
            var that = this;

            window.Alert.confirm("Are you sure you want to delete this income?", function() {
                that.$emit('showLoader');

                window.axios.delete( window.makeUrl( "/user/incomes/" + id ), [] ).then(resp => {
                    that.updateUser();
                    window.Alert.msg("Success!", "Income deleted!");

                    that.$emit('hideLoader');
                }).catch(resp => {
                    window.ShowError();
                });
            });
        },


        updateIncome() {
            var that = this;

            window.Alert.confirm("Are you sure you want to edit this income??", function() {

                that.$emit('showLoader');

                let description = that.description_value;
                let category_id = that.category_value;
                let amount = that.amount_value;

                window.axios.patch( window.makeUrl( "/user/incomes/" + that.toBeUpdatedIncome.id ), { description, category_id, amount } ).then(resp => {
                    that.updateUser();
                    window.Alert.msg("Income Updated!");
                    
                    that.hideIncomeForm();

                }).catch(error => {
                    window.FormErrors.Apply( error.response.data.errors );
                    window.ShowError();
                });

                that.$emit('hideLoader');
            });
        }
    }
}
</script>

<style>

</style>
