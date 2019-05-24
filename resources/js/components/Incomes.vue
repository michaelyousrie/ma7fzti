<template>
    <div v-show="this.show">
        <h1 class="bb">
            Incomes
            
            <button class="btn btn-primary right" @click="showAddIncomeForm"><i class="fa fa-plus"></i> Add Income</button>
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

        <!-- MODAL -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="addIncomeModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIncomeModal">{{ getConfirmButtonTitle() }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Category -->
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-control" v-model="category_value">
                                <option v-for="cat in incomeCategories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
                            </select>
                            <span class="error-feedback-span" id="category_id-feedback-span"></span>
                        </div>
                        <!-- /Category -->

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="4" cols="2" v-model="description_value"></textarea>
                            <span class="error-feedback-span" id="description-feedback-span"></span>
                        </div>
                        <!-- /Description -->

                        <!-- Amount -->
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" id="amount" class="form-control" name="amount" v-model="amount_value">
                            <span class="error-feedback-span" id="amount-feedback-span"></span>
                        </div>
                        <!--  Amount/-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="addEditIncome(income)">{{ getConfirmButtonTitle() }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /MODAL -->

    </div>
</template>

<script>
export default {
    props: ['incomes', 'totalIncome', 'currency', 'incomeCategories'],
    
    data() {
        return {
            show: true,

            amount_value: null,
            description_value: null,
            category_value: null,

            wantToAdd: true,

            toBeUpdatedIncome: null
        }
    },

    methods: {
        deleteIncome(id) {
            var that = this;

            window.Alert.confirm("Are you sure you want to delete this income?", function() {
                that.$emit('showLoader');

                window.axios.delete( window.makeUrl( "/user/incomes/" + id ), [] ).then(resp => {
                    that.$emit('updateUser');
                    window.Alert.msg("Success!", "Income deleted!");

                    that.$emit('hideLoader');
                }).catch(resp => {
                    window.ShowError();
                });
            });
        },


        showAddIncomeForm() {
            this.wantToAdd = true;
            this.clearForm();
            $('.modal').modal();
        },

        
        showUpdateIncomeForm( income ) {
            this.wantToAdd = false;
            this.toBeUpdatedIncome = income;
            this.clearForm();

            this.amount_value = income.amount;
            this.description_value = income.description;
            this.category_value = income.category_id;

            $('.modal').modal();
        },


        addEditIncome() {
            if (this.wantToAdd == true) {
                this.addIncome();
            } else if ( this.wantToAdd == false ) {
                this.updateIncome();
            }
        },

        
        hideIncomeForm() {
            $('.modal').modal('hide');
        },


        addIncome() {
            var that = this;

            window.Alert.confirm("Are you sure you want to add this income??", function() {

                that.$emit('showLoader');

                let description = that.description_value;
                let category_id = that.category_value;
                let amount = that.amount_value;

                window.axios.post( window.makeUrl( "/incomes" ), { description, category_id, amount } ).then(resp => {
                    that.$emit('updateUser');
                    window.Alert.msg("Income Added!");
                    $('.modal').modal('hide');
                    that.clearForm();
                }).catch(error => {
                    window.FormErrors.Apply( error.response.data.errors );
                    window.ShowError();
                });

                that.$emit('hideLoader');
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
                    that.$emit('updateUser');
                    window.Alert.msg("Income Updated!");
                    
                    that.hideIncomeForm();

                }).catch(error => {
                    window.FormErrors.Apply( error.response.data.errors );
                    window.ShowError();
                });

                that.$emit('hideLoader');
            });
        },


        clearForm() {
            this.description_value = null;
            this.category_value = null;
            this.amount_value = null;
        },

        getConfirmButtonTitle() {
            return this.wantToAdd == true ? 'Add Income' : 'Edit Income';
        }
    }
}
</script>

<style>

</style>
