<template>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            <h1 class="bb">
                Add Income

                <button class="btn btn-primary right" @click="showIncomesTable"><i class="fa fa-chevron-left"></i> Incomes</button>
            </h1>
            
            <br>

            <div class="row">
                <!-- Category -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-control" v-model="form.category_value">
                        <option v-for="cat in incomeCategories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
                    </select>
                    <span class="error-feedback-span" id="category_id-feedback-span"></span>
                </div>
                <!-- /Category -->

                <!-- Amount -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="amount">Amount</label>
                    <input type="text" id="amount" class="form-control" name="amount" v-model="form.amount_value">
                    <span class="error-feedback-span" id="amount-feedback-span"></span>
                </div>
                <!-- /Amount -->

                <!-- Description -->
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" rows="4" cols="2" v-model="form.description_value"></textarea>
                    <span class="error-feedback-span" id="description-feedback-span"></span>
                </div>
                <!-- /Description -->

                <!-- Buttons -->
                <div class="form-group col-md-12">
                    <button class="btn btn-danger btn-block" @click="clearForm">Clear Form</button>
                    <button class="btn btn-success btn-block" @click="addIncome">Add Income</button>
                </div>
                <!-- /Buttons -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["incomeCategories"],

    data() {
        return {
            form: {
                amount_value: null,
                description_value: null,
                category_value: null   
            }
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

        addIncome() {
            var that = this;

            window.Alert.confirm("Are you sure you want to add this income??", function() {

                that.$emit('showLoader');

                let description = that.form.description_value;
                let category_id = that.form.category_value;
                let amount = that.form.amount_value;

                window.axios.post( window.makeUrl( "/incomes" ), { description, category_id, amount } ).then(resp => {
                    that.$emit('updateUser');
                    that.clearForm();
                    that.showIncomesTable();
                    window.Alert.msg("Income Added!");
                }).catch(error => {
                    window.FormErrors.Apply( error.response.data.errors );
                    window.ShowError();
                });

                that.$emit('hideLoader');
            });
        },
    }
}
</script>

<style>

</style>
