<template>
    <div>
        <div v-show="table.show">
            <h1 class="bb">
                Incomes
                
                <button class="btn btn-primary right" @click="showForm('add')"><i class="fa fa-plus"></i> Add Income</button>
            </h1>
            
            <br>

            <table id="incomesTable" class="table table-light table-bordered table-striped">
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
                    <tr v-for="(income, index) in incomes" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{income.id }}</td>
                        <td>{{ income.description }}</td>
                        <td>{{ income.category? income.category.name : '-' }}</td>
                        <td>{{ income.when }}</td>
                        <td><span class="text-success">{{ currency }} +{{ income.amount }}</span></td>
                        <td>
                            <button class="btn btn-xs btn-primary" @click="updateIncome(income)"><i class="fa fa-edit"></i></button> &nbsp;
                            <button class="btn btn-xs btn-danger" @click="deleteIncome(income.id)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Form-AddIncome
            v-if="this.forms.add.show"
            @showTable="showTable(true)" @updateUser="updateUser"
            :incomeCategories="incomeCategories"
        >
        </Form-AddIncome>
        <Form-EditIncome
            v-if="this.forms.update.show"
            @showTable="showTable(true)" @updateUser="updateUser"
            :incomeCategories="incomeCategories" :income="getToBeUpdatedIncome"
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

                "update": {
                    show: false
                }
            },

            table: {
                show: true
            },

            toBeUpdatedIncome: null
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
        
        updateIncome(income) {
            this.toBeUpdatedIncome = income;
            this.showForm('update');
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
        }
    },

    computed: {
        getToBeUpdatedIncome() {
            return this.toBeUpdatedIncome;
        }
    },

    updated() {
        window.InitDataTable( $('#incomesTable') );
    }
}
</script>

<style>

</style>
