<template>
    <div>

        <div class="laogiving">
            <div class="row-fluid text-center">
                <main class="laogiving activity clearfix reset-container">
                    <div class="container">
                        <div id="resetpwd-header">
                            <div class="signup-section"><h3 class="h3">Reset your password</h3></div>
                            <form
                                @submit.prevent
                                class="form " method="post" style="display: flow-root">
                                <div class="control-group"><label
                                    class="control-label"><h5 class="h5">We will sign out your authenticated devices
                                    after finished the password reset action.</h5>
                                </label>
                                    <fieldset class="fieldset">
                                        <div class="control-group">
                                            <div class="controls"><span
                                                class="validation-feedback pull-right" style="display: none"></span>
                                                <div class="control-group mt-8">
                                                    <input class="field text-center"
                                                           disabled
                                                           v-model="user.email"
                                                           id="email"
                                                           name="email" placeholder="Your email address"
                                                           type="email" value="" size="30">
                                                    <label for="email" class="error-msg" style="display: block;">{{
                                                        validated().email || validated().error }}</label>
                                                </div>
                                                <!--<label class="control-label" for="password">New Password</label>-->
                                                <div class="control-group" v-if="!hide">
                                                    <input class="field text-center"
                                                           v-model="user.password"
                                                           id="password"
                                                           name="password" placeholder="Enter new password"
                                                           type="password">
                                                    <label for="password" class="error-msg" style="display: block;">{{
                                                        validated().password }}</label>
                                                </div>

                                                <div class="control-group" v-if="!hide">
                                                    <input class="field text-center"
                                                           v-model="user.password_confirmation"
                                                           id="password_confirmation"
                                                           name="password_confirmation"
                                                           placeholder="Enter new password confirmation"
                                                           type="password" value="" size="30">
                                                    <label for="password_confirmation" class="error-msg"
                                                           style="display: block;">{{
                                                        validated().password_confirmation }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls" v-if="!hide">
                                                <button v-if="!validated().loading_reset"
                                                        @click="UserResetPassword()"
                                                        type="submit" class="button-ctn button--large"
                                                        id="forgot-password-btn">Reset password
                                                </button>
                                                <button v-else type="submit" class="button-ctn button--large"
                                                >Saving...
                                                </button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <p class="small"> I want to <a @click="Route({name: 'register-overview'})"
                                                               class="alternate-actions cursor">Sign Up</a>
                                    or <a @click="$modal.show('signin')" class="alternate-actions cursor">Log
                                        In</a> instead </p>
                            </form>

                            <div class="signup-section"><p class="small"><a href="/" class="alternate-actions">Take me
                                back to the home page</a></p></div>

                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapActions, mapGetters, mapMutations} from 'vuex'

    export default {
        name: "ResetPassword",
        data() {
            return {
                ...mapGetters(['validated']),
                user: {email: '...'},
                hide: false,
            }
        },
        methods: {
            ...mapActions(['initResetForm', 'resetPassword', 'setPageTitle']),
            ...mapMutations(['setValidated']),
            UserResetPassword() {
                this.resetPassword(this.user)
                    .then(res => {
                        if (res.success) {
                            this.Route({name: 'finished-reset-password'}, 1000);
                        }
                    })
                    .catch(e => {

                    })
            },
            Init() {
                let token = this.$route.params.token;
                this.initResetForm(token)
                    .then(res => {
                        if (res.success) {
                            this.user.token_input = res.token;
                            this.user.email = decodeURIComponent(res.email);
                        } else {
                            this.hide = true;
                            this.setValidated({errors: {error: "Your reset password link has expired!, Redirect in 4.5"}});
                            this.Route({name: 'forgot-password'}, 4500)
                        }
                    })
                    .catch(e => {

                    })
            }
        },
        mounted() {
            this.setPageTitle('Reset Password');
        },
        created() {
            this.Init();
        }
    }
</script>

<style scoped>

</style>
