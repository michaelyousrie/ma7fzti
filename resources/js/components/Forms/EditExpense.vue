<template>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            <h1 class="bb">
                Edit Expense #{{ expense? expense.id : ''}}

                <button class="btn btn-primary right" @click="showExpensesTable"><i class="fa fa-chevron-left"></i> Expenses</button>
            </h1>
            
            <br>

            <div class="row">
                <!-- Category -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="category">Category</label>
                    <select name="category_id" data-feedback-id="edit_category_id" id="category" class="form-control" v-model="form.category_value">
                        <option v-for="cat in expenseCategories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
                    </select>
                    <span class="error-feedback-span" id="edit_category_id-feedback-span"></span>
                </div>
                <!-- /Category -->

                <!-- Amount -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="amount">Amount</label>
                    <input type="text" id="amount" data-feedback-id="edit_amount" class="form-control" name="amount" v-model="form.amount_value">
                    <span class="error-feedback-span" id="edit_amount-feedback-span"></span>
                </div>
                <!-- /Amount -->

                <!-- Description -->
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea id="description" data-feedback-id="edit_description" class="form-control" name="description" rows="4" cols="2" v-model="form.description_value"></textarea>
                    <span class="error-feedback-span" id="edit_description-feedback-span"></span>
                </div>
                <!-- /Description -->

                <!-- Buttons -->
                <div class="form-group col-md-12">
                    <button class="btn btn-success btn-block" @click="updateExpense">Update Expense</button>
                </div>
                <!-- /Buttons -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["expenseCategories", 'expense'],

    data() {
        return {
            form: {
                amount_value: this.expense? this.expense.amount : '',
                description_value: this.expense? this.expense.description : '',
                category_value: this.expense? this.expense.category_id : ''
            }
        }
    },

    watch: {
        expense(expense) {
            this.form.amount_value = expense.amount;
            this.form.description_value = expense.description;
            this.form.category_value = expense.category_id;
        }
    },

    methods: {
        showExpensesTable() {
            this.$emit("showTable");
        },

        clearForm() {
            let entries = Object.entries(this.form);

            for ( const [key, value] of entries ) {
                this.form[key] = null;
            }
        },

        updateExpense() {
            var that = this;

            window.Alert.confirm("Are you sure you want to edit this expense?", function() {

                that.$emit('showLoader');

                let description = that.form.description_value;
                let category_id = that.form.category_value;
                let amount = that.form.amount_value;

                window.axios.patch( window.makeUrl( "/user/expenses/" + that.expense.id ), { description, category_id, amount } ).then(resp => {
                    that.$emit('updateUser');
                    window.Alert.msg("Expense Updated!");
                    
                    that.showExpensesTable();

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
