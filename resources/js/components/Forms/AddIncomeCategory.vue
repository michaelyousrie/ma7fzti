<template>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            <h1 class="bb">
                Add Income Category

                <button class="btn btn-primary right" @click="showIncomesTable"><i class="fa fa-chevron-left"></i> Income Categories</button>
            </h1>
            
            <br>

            <div class="row">
                <!-- Name -->
                <div class="form-group col-md-12">
                    <label for="name">Name</label>
                    <input type="text" id="name" data-feedback-id="edit_name" class="form-control" name="name" v-model="form.name_value">
                    <span class="error-feedback-span" id="edit_name-feedback-span"></span>
                </div>
                <!-- /Name -->

                <!-- Description -->
                <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea id="description" data-feedback-id="edit_description" class="form-control" name="description" rows="4" cols="2" v-model="form.description_value"></textarea>
                    <span class="error-feedback-span" id="edit_description-feedback-span"></span>
                </div>
                <!-- /Description -->

                <!-- Buttons -->
                <div class="form-group col-md-12">
                    <button class="btn btn-danger btn-block" @click="clearForm">Clear Form</button>
                    <button class="btn btn-success btn-block" @click="addIncome">Add Income Category</button>
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
                name_value: null,
                description_value: null
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

            window.Alert.confirm("Are you sure you want to add this income category?", function() {

                that.$emit('showLoader');

                let name = that.form.name_value;
                let description = that.form.description_value;

                window.axios.post( window.makeUrl( "/user/income_categories" ), { name, description } ).then(resp => {
                    that.$emit('updateUser');
                    that.clearForm();
                    that.showIncomesTable();
                    window.Alert.msg("Income Category Added!");
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
