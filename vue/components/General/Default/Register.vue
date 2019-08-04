<template>
    <div>
        <main class="laogiving activity clearfix">
            <div class="sign-up-overview-container">
                <div class="hero-container sign-up-overview-container-hero-container">
                    <template v-if="type==='volunteer'">
                        <h1 class="h1">Sign up as new individual</h1>
                        <h2 class="h2">Join 100,000 others who are changing the world!</h2>
                    </template>
                    <template v-else>
                        <h1 class="h1">Sign up as new organisation or group</h1>
                    </template>
                    <div class="hero-container__body hero-container__body--400">
                        <a @click="Route({name: 'register-overview'})"
                           class="cursor button--large button--with-icon button--no-bg button--white button--no-padding">
                            <div class="button--with-icon__wrapper"><i
                                class="ico material-icons button--with-icon__icon">keyboard_backspace</i> BACK
                            </div>
                        </a>
                    </div>
                </div>
                <div class="sign-up-overview-card-container">
                    <div class="rounded-card--header-solid">
                        <div class="rounded-card--header-solid__header" v-if="type==='organize'">
                            <div class="body-txt text-center">Fill in your personal information.</div>
                            <div class="body-txt text-center">We will ask about your organisation or group details in
                                the following pages.
                            </div>
                        </div>
                        <div class="rounded-card--header-solid__body">
                            <div class="body-txt body-txt--smaller body-txt--no-letter-space pt-8 text-center">Your
                                information is safe and secure with us.
                            </div>
                            <hr class="hr-text grey" data-content="Sign up with email">
                            <form @submit.prevent>
                                <fieldset class="fieldset">
                                    <div class="row-fluid clearfix">
                                        <div class="input-ctrl">
                                            <label class="lbl">Name
                                            </label>
                                            <input id="firstName" type="text" class="input-ctn"
                                                   placeholder="e.g. John Tan" name="name"
                                                   v-model="user.name">
                                            <label v-if="validated().name" for="firstName" class="error-msg" style="display: block;">{{ validated().name }}</label>
                                        </div>
                                        <div class="input-ctrl">
                                            <label class="lbl">Email
                                            </label>
                                            <input id="email" type="email" class="input-ctn"
                                                   placeholder="e.g. john@laogiving.la" name="email"
                                                   autocomplete="username"
                                                   v-model="user.email">
                                            <label v-if="validated().email" for="email" class="error-msg" style="display: block;">{{ validated().email }}</label>
                                        </div>
                                        <div class="input-ctrl">
                                            <label class="lbl">
                                                Password <span class="tooltip__mark" data-toggle="tooltip"
                                                               data-placement="right"
                                                               title="Your password must be between 8-24 characters with at least one number. Only special characters @$!%*?&amp;+-.=^_|~ are accepted.">?</span>
                                            </label>
                                            <input id="password" placeholder="Your password" class="input-ctn"
                                                   autocomplete="current-password" name="password"
                                                   v-model="user.password"
                                                   type="password">
                                            <label v-if="validated().password" for="password" class="error-msg" style="display: block;">{{ validated().password }}</label>
                                        </div>
                                    </div>
                                    <div class="body-txt body-txt--smaller body-txt--no-letter-space pt-8 text-center">
                                        <div class="control-group form-inline">
                                            <label for="_signup_agree"
                                                   class="checkbox">
                                                <input id="_signup_agree" class="field form-control" type="checkbox"
                                                       v-model="user.receive_news">
                                                Receive giving news and other good stories from us!
                                            </label>
                                        </div>
                                        <div style="width: 100%;" class="pt-24 ">
                                            <div class="control-group">
                                                <button v-if="!validated().loading" type="submit"
                                                        @click="RegisterUser()"
                                                        class="button-ctn button--large button--full">SIGN UP
                                                </button>

                                                <button v-else type="submit"
                                                        @click="RegisterUser()"
                                                        class="button-ctn button--large button--full">PLEASE WAIT...
                                                </button>

                                            </div>
                                        </div>
                                        <div
                                            class="body-txt body-txt--smaller body-txt--no-letter-space pt-8 text-center">
                                            By signing up, you agree to our <a target="_blank"
                                                                               class="cursor text-link text-link--underline">Terms
                                            and Conditions</a> and <a target="_blank"
                                                                      class="cursor text-link text-link--underline">Privacy
                                            Policy</a> .
                                        </div>
                                        <div class="body-txt pt-16 text-center"> Already have an account? <a
                                            @click="$modal.show('signin')" class="cursor text-link">Login here</a></div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: "register",
        data() {
            return {
                ...mapGetters(['validated']),
                type: 'volunteer',
                allows: {volunteer: 'volunteer', organize: 'organize'},
                user: {},
            }
        },
        methods: {
            ...mapActions(['register', 'setPageTitle']),
            RegisterUser() {
                this.user.type = this.type;
                this.register(this.user)
                    .then(res => {
                        this.Route({name: 'registered'}, 1000);
                    }).catch(e => {
                });
            },
            getTypeRegister() {
                if (!(this.$route.query.type && this.allows[this.$route.query.type])) {
                    return;
                }
                this.type = this.$route.query.type;
            }
        },
        mounted() {
            this.setPageTitle('Register - ');
            this.jq('[data-toggle="tooltip"]').tooltip();
        },
        created() {
            this.getTypeRegister();
        }
    }
</script>

<style scoped>

</style>
