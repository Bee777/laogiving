<template>
    <div>
        <main class="laogiving activity clearfix">
            <div class="sign-up-overview-container">
                <div class="hero-container sign-up-overview-container-hero-container">
                    <h1 class="h1">Join our extraordinary community! </h1>
                    <h2 class="h2">Choose your account type and sign up</h2>
                    <div class="hero-container__image"></div>
                </div>
                <div class="sign-up-overview-card-container">
                    <div class="rounded-card">
                        <div class="rounded-card__head rounded-card__head--salmon"><p>Individual</p></div>
                        <div class="rounded-card__body">
                            <div class="media-obj">
                                <div class="media-obj__main"><h2 class="h2 mt-0">Volunteer </h2>
                                    <p>With over 400 charities to choose from, you'll definitely find something close to
                                        your heart.</p></div>
                                <div class="media-obj__asset"><img
                                    src="https://www.giving.sg/givingsg-theme/images/mt/ic-indi.svg" alt=""></div>
                            </div>
                            <button @click="Route({name: 'register', query: { type: 'volunteer' }})"
                                    class="button-ctn button--ghost button--large button--salmon">SIGN UP
                            </button>
                        </div>
                    </div>
                    <div class="rounded-card">
                        <div class="rounded-card__head rounded-card__head--navy-blue"><p>ORGANISATION OR GROUPS</p>
                        </div>
                        <div class="rounded-card__body">
                            <div class="media-obj">
                                <div class="media-obj__main"><h2 class="mt-0">It's A Match! </h2>
                                    <p>Find your perfect charity, and invite all your members to do good, together.</p>
                                </div>
                                <div class="media-obj__asset">
                                    <img src="https://www.giving.sg/givingsg-theme/images/mt/ic-organisation.svg"
                                         alt=""></div>
                            </div>
                            <button @click="Route({name: 'register', query: { type: 'organize' }})"
                                    class="button-ctn button--ghost button--large button--navy-blue"
                                    >SIGN UP
                            </button>
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
        name: "RegisterOverview",
        data() {
            return {
                ...mapGetters(['validated']),
                user: {}
            }
        },
        methods: {
            ...mapActions(['register', 'setPageTitle']),
            RegisterUser() {
                this.register(this.user)
                    .then(res => {
                        this.Route({name: 'registered'}, 1000);
                    });
            }
        },
        mounted() {
            this.setPageTitle('Register Overview');
        },
    }
</script>

<style scoped>

</style>
