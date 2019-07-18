<template>
    <div>
        <!--Loader-->
        <div class="preloader" v-if="isPreload">
            <div class="preloader-ctn">
                <svg version="1.1" id="" class="preloader-ctn__svg" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px"
                     viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                    <path class="preloader-ctn__loader" fill="#000"
                          d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"></path>
                </svg>
                <p id="loadingMsg" class="preloader-ctn__text"></p>
            </div>
            <div class="preloader__background"></div>
        </div>
        <!--Loader-->
        <div class="laogiving">
            <Modals/>
        </div>
        <Navbar v-if="!$route.meta.hideNavFooter"/>
        <div id="organize-main-container"
             :class="[(isMobile && $route.meta.navFixed) ? 'add-padding-top-content': '']">
            <router-view></router-view>
        </div>
        <Footer v-if="!$route.meta.hideNavFooter"/>

        <Sidebar/>

        <div class="toast" style="display: none;"></div>

    </div>
</template>
<script>
    import {mapActions, mapMutations, mapState} from 'vuex'
    import Navbar from '@com/Organize/Partial/Navbar.vue';
    import Sidebar from '@com/Organize/Partial/Sidebar.vue';
    import Footer from '@com/General/Partial/Footer.vue';

    const Modals = () => import('@com/Utils/Modals.vue')
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
                isPreload: false,
            }
        },
        computed: {
            ...mapState(['isMobile', 'authUserInfo']),
        },
        watch: {
            'authUserInfo': function (n, o) {
                if (!(this.$route.meta.allows && this.$route.meta.allows.includes(n.decodedType))) {
                    this.$utils.Location(`/${String(n.decodedType).replace(/_/g, '-')}/me`);
                }
            }
        },
        methods: {
            ...mapMutations(['setMobile', 'setUserProfile', 'setUserProfileKey']),
            ...mapActions(['fetchHomeData', 'fetchAuthUserInfo', 'fetchOptionProfileData']),
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
            onLoading(t) {
                this.isPreload = t;
            },
            registerEvents() {
                this.Event.listen('preload', (d) => {
                    this.onLoading(d.loading);
                })
            },
            getUserProfile() {
                this.fetchOptionProfileData()
                    .then(res => {
                        let s = res.success, d = res.data;
                        if (s) {
                            if (!this.$utils.isEmptyVar(d.user_profile)) {
                                this.setUserProfile(d.user_profile);
                            } else {
                                this.setUserProfileKey({key: 'display_name', value: d.name});
                                this.setUserProfileKey({key: 'public_email', value: d.email});
                            }
                        }
                    })
                    .catch(err => {
                    })
            },
        },
        mounted() {
            this.breakPoint = this.$el.clientWidth;
            this.windowHeight = this.$el.clientHeight;
            window.addEventListener('resize', (e) => {
                this.getClient(e, this);
            });
            this.isBreak(this.limitBreakPoint);
            //register events
            this.registerEvents();
        },
        created() {
            this.fetchAuthUserInfo({no_redirect: true});//get first user data
            this.getUserProfile();
            this.fetchHomeData();
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
    #organize-main-container {
        min-height: 799px;
    }
</style>
