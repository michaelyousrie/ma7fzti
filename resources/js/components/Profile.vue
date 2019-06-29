<template>
    <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1">
            <h1 class="bb">My Profile</h1>

            <div class="row">
                <!-- First Name -->
                <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" v-model="form.first_name" name="first_name" id="first_name">
                    <span class="error-feedback-span" id="first_name-feedback-span"></span>
                </div>
                <!-- /First Name -->

                <!-- Last Name -->
                <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" v-model="form.last_name" name="last_name" id="last_name">
                    <span class="error-feedback-span" id="last_name-feedback-span"></span>
                </div>
                <!-- /Last Name -->
            </div>

            <div class="row">
                <!-- Email -->
                <div class="form-group col-md-12">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" v-model="form.email" name="email" id="email">
                    <span class="error-feedback-span" id="email-feedback-span"></span>
                </div>
                <!-- /Email -->

                <!-- Currency -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="currency">Currency</label>
                    <input type="text" class="form-control" v-model="form.currency" name="currency" id="currency">
                    <span class="error-feedback-span" id="currency-feedback-span"></span>
                </div>
                <!-- /Currency -->

                <!-- Language -->
                <div class="form-group col-md-12 col-lg-6">
                    <label for="language_code">Language</label>
                    <select v-model="form.language_code" name="language_code" id="language_code" class="form-control">
                        <option v-for="lang in getLanguages" :key="lang.code" :value="lang.code">{{ lang.name }}</option>
                    </select>
                    <span class="error-feedback-span" id="language_code-feedback-span"></span>
                </div>
                <!-- /Language -->
            </div>
            
            <br>

            <div class="row">
                <div class="col-md-12">
                    <h1 class="bb">
                        Change Password
                        <span style="font-size: 0.5em">(Leave empty to keep your current password)</span>
                    </h1>

                    <div class="row">
                        <!-- New Passowrd -->
                        <div class="col-md-12 col-lg-6">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" v-model="form.new_password" name="new_password" id="new_password">
                            <span class="error-feedback-span" id="new_password-feedback-span"></span>
                        </div>
                        <!-- /New Passowrd -->

                        <!-- New Password Confirmation -->
                        <div class="col-md-12 col-lg-6">
                            <label for="new_password_confirm">New Password Confirmation</label>
                            <input type="password" class="form-control" v-model="form.new_password_confirm" name="new_password_confirm" id="new_password_confirm" @blur="confirmPasswordsMatch">
                            <span class="error-feedback-span" id="new_password_confirm-feedback-span"></span>
                        </div>
                        <!-- /New Password Confirmation -->
                    </div>
                </div>
            </div>

            <br><br>

            <!-- Buttons -->
            <div class="row">
                <div class="form-group col-md-12">
                    <button class="btn btn-success btn-block" @click="showPasswordModal">Update Profile</button>
                </div>
            </div>
            <!-- /Buttons -->
        </div>

        <!-- Enter Password Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="EnterPassword" aria-hidden="true" id="EnterPasswordModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label for="password">Enter Current Password</label>
                            <input type="password" class="form-control" v-model="form.password" name="password" id="password">
                            <span class="error-feedback-span" id="password-feedback-span"></span>
                        </div>

                        <br><hr>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary form-control" @click="updateProfile">Update Profile</button>
                                </div>

                                <div class="col-md-6">
                                    <button type="button" class="btn btn-secondary form-control" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Enter Password Modal -->
    </div>
</template>

<script>
export default {
    props: [ 'user' ],

    watch: {
        user(user) {
            this.form.first_name = user.first_name;
            this.form.last_name = user.last_name;
            this.form.email = user.email;
            this.form.currency = user.currency;
            this.form.language_code = user.language_code;
        }
    },

    data() {
        return {
            form: {
                first_name: null,
                last_name: null,
                email: null,
                currency: null,
                language_code: null,
                password: null,
                new_password: '',
                new_password_confirm: ''
            },

            languages: []
        }
    },

    created() {
        var that = this;

        window.axios.get( window.makeUrl( "languages" ) ).then( resp => {
            that.languages = resp.data.data;
        }).catch( err => {
            window.ShowError();
        });
    },


    computed: {
        getLanguages() {
            return this.languages;
        }
    },

    methods: {
        updateProfile() {
            
            var that = this;

            window.Alert.confirm("Are you sure you want to update your profile?", function() {
                that.$emit("showLoader");

                window.axios.patch( window.makeUrl( "user" ), { first_name: that.form.first_name, last_name: that.form.last_name, email: that.form.email, currency: that.form.currency, language_code: that.form.language_code, new_password: that.form.new_password, password: that.form.password }).then( resp => {

                    window.Alert.msg("Profile Updated. Please relogin...");

                    window.location = "/logout";

                }).catch( error => {
                    window.FormErrors.Apply( error.response.data.errors );
                    window.ShowError();
                });

                that.$emit('hideLoader');
            });
        },

        showPasswordModal() {
            if ( ! this.confirmPasswordsMatch() ) 
                return;

            $("#EnterPasswordModal").modal('show');
        },

        confirmPasswordsMatch() {
            if ( this.form.new_password != this.form.new_password_confirm ) {
                window.Alert.error( "Error", "Your password confirmation doesn't match your password!" );
                return false;
            }

            return true;
        }
    }
}
</script>

<style>

</style>
