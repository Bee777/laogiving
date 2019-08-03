<template>
    <div class="laogiving">
        <div class="row-fluid text-center">
            <main class="laogiving activity clearfix reset-container">
                <div class="container">
                    <div id="resetpwd-header">
                        <div class="signup-section"><h3 class="h3">Forgot your password</h3></div>
                        <form
                            @submit.prevent
                            class="form " method="post" style="display: flow-root">
                            <div class="control-group"><label
                                class="control-label"><h5 class="h5">We'll email you a link to get it reset.</h5>
                            </label>
                                <fieldset class="fieldset">
                                    <div class="">
                                        <div class="controls"><span
                                            class="validation-feedback pull-right" style="display: none"></span>
                                            <div class="control-group">
                                                <input class="field text-center"
                                                       v-model="user.email"
                                                       id="email"
                                                       name="email" placeholder="Your email address"
                                                       type="email" value="" size="30">
                                                <label for="email" class="error-msg" style="display: block;">{{
                                                    validated().email || validated().error }}</label>
                                                <p class="small"><a style="text-decoration: none;"
                                                                    class="alternate-actions">{{succeeded().msg}}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button v-if="!validated().loading" @click="ForgotPasswordUser()"
                                                    type="submit" class="button-ctn button--large"
                                                    id="forgot-password-btn">Reset my password please!
                                            </button>
                                            <button v-else type="submit" class="button-ctn button--large"
                                            >Please wait resetting...
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
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: "ForgotPassword",
        data() {
            return {
                ...mapGetters(['validated', 'succeeded']),
                user: {},
                redirecting: false,
            }
        },
        methods: {
            ...mapActions(['forgotPassword', 'setPageTitle']),
            ForgotPasswordUser() {
                if (this.redirecting) {
                    return;
                }
                this.forgotPassword(this.user)
                    .then(res => {
                        if (res.success) {
                            this.redirecting = true;
                            this.Route({name: 'home'}, 2500);
                        }
                    }).catch((err) => {

                });
            }
        },
        mounted() {
            this.setPageTitle('Forgot Password');
        }
    }
</script>

<style scoped>

</style>
