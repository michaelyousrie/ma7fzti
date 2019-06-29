<template>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            <h1 class="bb">
                Edit Expense Category <i>({{ category ? category.name : ''}})</i>

                <button class="btn btn-primary right" @click="showExpenseCategoriesTable"><i class="fa fa-chevron-left"></i> Expense Categories</button>
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
                    <button class="btn btn-success btn-block" @click="updateIncome">Update Income Category</button>
                </div>
                <!-- /Buttons -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['category'],

    data() {
        return {
            form: {
                name_value: this.category? this.category.name : '',
                description_value: this.category? this.category.description : ''
            }
        }
    },

    watch: {
        category(category) {
            this.form.name_value = category.name;
            this.form.name_value = category.description;
        }
    },

    methods: {
        showExpenseCategoriesTable() {
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

            window.Alert.confirm("Are you sure you want to edit this expense category?", function() {

                that.$emit('showLoader');

                let description = that.form.description_value;
                let name = that.form.name_value;

                window.axios.patch( window.makeUrl( "/user/expense_categories/" + that.category.id ), { name, description } ).then(resp => {
                    that.$emit('updateUser');
                    window.Alert.msg("Expense Category Updated!");
                    
                    that.showExpenseCategoriesTable();

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
