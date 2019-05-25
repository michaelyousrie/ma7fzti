<template>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            <h1 class="bb">
                Edit Income #{{ income? income.id : ''}}

                <button class="btn btn-primary right" @click="showIncomesTable"><i class="fa fa-chevron-left"></i> Incomes</button>
            </h1>
            
            <br>

            <div class="row">
                <!-- Category -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="category">Category</label>
                    <select name="category_id" data-feedback-id="edit_category_id" id="category" class="form-control" v-model="form.category_value">
                        <option v-for="cat in incomeCategories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
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
                    <button class="btn btn-success btn-block" @click="updateIncome">Update Income</button>
                </div>
                <!-- /Buttons -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["incomeCategories", 'income'],

    data() {
        return {
            form: {
                amount_value: this.income? this.income.amount : '',
                description_value: this.income? this.income.description : '',
                category_value: this.income? this.income.category_id : ''
            }
        }
    },

    watch: {
        income(income) {
            this.form.amount_value = income.amount;
            this.form.description_value = income.description;
            this.form.category_value = income.category_id;
        }
    },

    methods: {
        showIncomesTable() {
            this.$emit("showTable");
        },

        clearForm() {
            let entries = Object.entries(this.form);

            for ( const [key, value] of entries ) {
                this.form[key] = null;
            }
        },

        updateIncome() {
            var that = this;

            window.Alert.confirm("Are you sure you want to edit this income??", function() {

                that.$emit('showLoader');

                let description = that.form.description_value;
                let category_id = that.form.category_value;
                let amount = that.form.amount_value;

                window.axios.patch( window.makeUrl( "/user/incomes/" + that.income.id ), { description, category_id, amount } ).then(resp => {
                    that.$emit('updateUser');
                    window.Alert.msg("Income Updated!");
                    
                    that.showIncomesTable();

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
