<template>
    <div>
        <div v-show="table.show">
            <h1 class="bb">
                Income Categories
                
                <button class="btn btn-primary right" @click="showForm('add')"><i class="fa fa-plus"></i> Add Income Category</button>
            </h1>
            
            <br>

            <table id="incomeCategoriesTable" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(category, index) in getIncomeCategories" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>{{ category.description }}</td>
                        <td>{{ category.when }}</td>
                        <td>
                            <button class="btn btn-xs btn-primary" @click="updateCategory(category)"><i class="fa fa-edit"></i></button> &nbsp;
                            <button class="btn btn-xs btn-danger" @click="deleteCategory(category.id)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Form-AddIncomeCategory
            v-if="this.forms.add.show"
            @showTable="showTable(true)" @updateUser="updateUser"
        >
        </Form-AddIncomeCategory>
        <Form-EditIncomeCategory
            v-if="this.forms.update.show"
            @showTable="showTable(true)" @updateUser="updateUser"
            :category="getToBeUpdatedCategory"
        >
        </Form-EditIncomeCategory>
    </div>
</template>

<script>
export default {
    props: ['user'],
    
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

            toBeUpdatedCategory: null
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
        
        updateCategory(category) {
            this.toBeUpdatedCategory = category;
            this.showForm('update');
        },


        showTable(bool = true) {
            this.showForm(false);
            this.table.show = bool;
        },


        updateUser() {
            this.$emit('updateUser');
        },


        deleteCategory(id) {
            var that = this;

            window.Alert.confirm("Are you sure you want to delete this income category AND all incomes that are associated with it?", function() {
                that.$emit('showLoader');

                window.axios.delete( window.makeUrl( "/user/income_categories/" + id ), [] ).then(resp => {
                    that.updateUser();
                    window.Alert.msg("Success!", "Income Category deleted!");

                    that.$emit('hideLoader');
                }).catch(resp => {
                    window.ShowError();
                });
            });
        }
    },

    computed: {
        getToBeUpdatedCategory() {
            return this.toBeUpdatedCategory;
        },

        getIncomeCategories() {
            return this.user.income_categories;
        }
    },

    updated() {
        window.InitDataTable( $('#incomeCategoriesTable') );
    }
}
</script>

<style>

</style>
