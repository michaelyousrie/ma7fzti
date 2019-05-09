<template>
    <div v-show="this.show">
        <h1 class="center bb">
            Incomes
            
            <button class="btn btn-primary right" @click="showAddIncomeForm"><i class="fa fa-plus"></i> Add Income</button>
        </h1>
        
        <br>

        <table class="table table-dark table-striped">
            <thead>
                <th>#</th>
                <th>description</th>
                <th>Created</th>
                <th>amount</th>
                <th></th>
            </thead>

            <tbody>
                <tr v-for="(income, index) in getUserIncomes" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ income.description }}</td>
                    <td>{{ income.when }}</td>
                    <td><span class="text-success">{{user.currency }} +{{ income.amount }}</span></td>
                    <td>
                        <button class="btn btn-xs btn-danger" @click="deleteIncome(income.id)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <tr class="bg-info">
                    <td></td><td></td><td></td>
                    <td>{{ user.getTotalIncome() }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- MODAL -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="addIncomeModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIncomeModal">Add Income</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Category -->
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-control">
                                <option v-for="cat in user.income_categories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
                            </select>
                        </div>
                        <!-- /Category -->

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="4" cols="2"></textarea>
                        </div>
                        <!-- /Description -->

                        <!-- Amount -->
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" id="amount" class="form-control" name="amount">
                        </div>
                        <!--  Amount/-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="addIncome">Add Income</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /MODAL -->

    </div>
</template>

<script>
export default {
    name: "Incomes",

    props: ['user'],

    created() {
        this.incomes = this.user.incomes;
        this.balance = this.user.balance;
    },
    
    data() {
        return {
            show: true,
            incomes: [],
            balance: 0,
        }
    },

    methods: {
        deleteIncome(id) {
            var that = this;

            window.Alert.confirm("Are you sure you want to delete this income?", function() {
                window.axios.delete( window.makeUrl( "/user/incomes/" + id ), [] ).then(resp => {
                    that.updateUser(resp);
                    window.Alert.msg("Success!", "Income deleted!");
                });
            });
        },


        showAddIncomeForm() {
            $('.modal').modal();
        },


        addIncome() {
            var that = this;

            window.Alert.confirm("Are you sure you want to add this income??", function() {
                let description = $('textarea[name=description]').val();
                let category_id = $('select[name=category_id] option:selected').val();
                let amount = $('input[name=amount]').val();

                window.axios.post( window.makeUrl( "/incomes" ), { description, category_id, amount } ).then(resp => {
                    that.updateUser(resp);
                    window.Alert.msg("Income Added!");
                    $('.modal').modal('hide');
                    that.clearForm();
                });
            });
        },


        updateUser( resp ) {
            this.user = window.user = window.updateUserObject( resp.data.user );
            this.$emit("updateUser");
        },


        clearForm() {
            $('textarea[name=description]').val('');
            $('select[name=category_id] option:first').attr('selected', true);
            $('input[name=amount]').val('');
        }
    },

    computed: {
        getUserIncomes() {
            return this.user.incomes;
        },

        getUserBalance() {
            return this.balance;
        },
    },
}
</script>

<style>
    .center {
        text-align: center;
    }

    .bb {
        border-bottom: 1px solid #e8e8e8;
        width: 90%;
        padding-bottom: 10px;
        margin-left: 5%;
    }

    .right {
        float: right;
        vertical-align: middle;
        margin-top: 10px;
    }
</style>
