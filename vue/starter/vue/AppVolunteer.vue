<template>
    <div>
        <div class="laogiving">
            <Modals/>
        </div>
        <Navbar @onNavbarFixed="(t)=> this.fixedNav = t" v-if="!$route.meta.hideNavFooter"/>
        <div :style="getStyles()" id="volunteer-main-container"
             :class="[(isMobile && $route.meta.navFixed) ? 'add-padding-top-content': '']">
            <router-view></router-view>
        </div>
        <Footer v-if="!$route.meta.hideNavFooter" :style="getStyles()"/>

        <Sidebar/>
    </div>
</template>
<script>
    import {mapActions, mapMutations, mapState} from 'vuex'
    import Navbar from '@com/Volunteer/Partial/Navbar.vue';
    import Sidebar from '@com/Volunteer/Partial/Sidebar.vue';
    import Footer from '@com/Volunteer/Partial/Footer.vue';

    const Modals = () => import('@com/Volunteer/Default/Includes/Modals.vue')
    export default {
        name: 'app-volunteer',
        components: {
            Footer,
            Navbar,
            Sidebar,
            Modals
        },

        data() {
            return {
                breakPoint: 0,
                windowHeight: 0,
                limitBreakPoint: 1023,
                fixedNav: {},
            }
        },
        computed: {
            ...mapState(['isMobile', 'authUserInfo']),
        },
        watch: {
            'authUserInfo': function (n, o) {
                if (!(this.$route.meta.allows && this.$route.meta.allows.includes(n.decodedType))) {
                    this.$utils.Location(`/${n.decodedType}/me`);
                }
            }
        },
        methods: {
            ...mapMutations(['setMobile']),
            ...mapActions(['fetchHomeData', 'fetchAuthUserInfo']),
            getClient: (e, context) => {
                context.breakPoint = e.currentTarget.innerWidth;
                context.windowHeight = e.currentTarget.innerHeight;
                context.isBreak(context.limitBreakPoint);
            },
            isBreak(break_point) {
                if (this.breakPoint <= break_point) {
                    this.setMobile({isMobile: true, currentWidth: this.breakPoint, currentHeight: this.windowHeight});
                } else {
                    this.setMobile({isMobile: false, currentWidth: this.breakPoint, currentHeight: this.windowHeight});
                }
            },
            getStyles() {
                return this.fixedNav.state ? `padding-top: ${this.fixedNav.height}px !important;` : '';
            },

        },
        mounted() {
            this.breakPoint = this.$el.clientWidth;
            this.windowHeight = this.$el.clientHeight;
            window.addEventListener('resize', (e) => {
                this.getClient(e, this);
            });
            this.isBreak(this.limitBreakPoint);
        },
        created() {
            this.fetchHomeData();
            this.fetchAuthUserInfo({no_redirect: true});//get first user data
        },
        beforeDestroy() {
            if (window.removeEventListener) {
                window.removeEventListener('resize', (e) => {
                    this.getClient(e, this)
                })
            }
        }
    }
</script>
<style scoped>
    #volunteer-main-container {
        min-height: 799px;
    }
</style>
