<template>
    <div class="nav-bar-fixed-container" ref="main-nav-bar">
        <div :class="[{'nav-bar-fixed' : isFixedNav}]">
            <!--TopNav-->
            <div class="header_meta header_meta_one flex flex-scale-auto" v-if="!isFixedNav">
                <div class="full-width-percent">
                    <ul class="social">
                        <li><a><i class="fab fa-twitter"></i></a></li>
                        <li><a><i class="fab fa-facebook"></i></a></li>
                        <li><a><i class="fab fa-linkedin"></i></a></li>
                        <li><a><i class="fab fa-pinterest-square"></i></a></li>
                        <li><a><i class="fab fa-instagram"></i></a></li>
                        <li><a><i class="fab fa-youtube"></i></a></li>
                    </ul>
                    <nav class="meta-login">
                        <ul>
                            <li class="clock"><i class="lnr lnr-clock"></i>Mon - Fri : 8:00 - 12:00</li>
                            <li class="call"><i class="lnr lnr-smartphone"></i>Call Us +731 234 5678</li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!--TopNav-->
            <!--MainTopNav-->
            <header class="site-header home-one" id="masthead">
                <div>
                    <div v-if="navInputSearch.active" class="flex flex-scale-auto full-width-percent">
                        <div class="search-nav-container flex flex-center flex-items-center flex">
                            <i @click="activeNavInputSearch(false)" class="material-icons cursor">search</i>
                            <input ref="navbar-input-search" @blur="activeNavInputSearch(false)"
                                   class="nav-input-space-left nav-input-search"
                                   type="text" placeholder="Search">
                            <i @click="activeNavInputSearch(false)" class="material-icons cursor">close</i>
                        </div>
                    </div>
                    <div v-show="!navInputSearch.active" class="flex flex-scale-auto">
                        <div class="site-branding flex-start">
                            <a @click="Route({name: 'home'})">
                                <img alt="educationpress"
                                     class="brand"
                                     :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"/></a>
                        </div>
                        <nav
                            class="main-navigation navbar navbar-default flex flex-end flex-items-stretch"
                            id="site-navigation">
                            <div class="navbar-header">
                                <button @click="showMobileNav" class="navbar-toggle" type="button">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav flex flex-wrap flex-end ">
                                    <li><a class="na">Be a Volunteer</a></li>
                                    <li><a>Create an Activity</a></li>
                                    <li><a @click="activeNavInputSearch(true)" class="search-menu"><i
                                        class="material-icons">search</i></a></li>
                                    <li><a class="menu-button">Log In</a></li>
                                    <li><a class="menu-button">Sign Up</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>
            <!--MainTopNav-->
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters, mapState, mapMutations} from 'vuex';
    import Base from "@com/Bases/GeneralBase.js";

    export default Base.extend({
        data() {
            return {
                ...mapGetters(['LoggedIn', 'validated']),
                isActive: '',
                el: null,
                lastScrollTop: 0,
                navbarHeight: 180,
                isFixedNav: false,
                navInputSearch: {active: false, text: ''}
            };
        },
        watch: {
            isSidebar: function (n, o) {
                this.isActive = n === 'left-side' ? '' : 'is-active'
            },
        },
        computed: {
            ...mapState(['isMobile', 'isSidebar']),
        },
        methods: {
            ...mapMutations(['setSidebar']),
            ...mapActions(['Logout']),
            showMobileNav() {
                this.isActive = this.isActive === 'is-active' ? '' : 'is-active';
                this.setSidebar({isSidebar: this.isActive})
            },
            toggleFixedNav(t) {
                this.isFixedNav = t;
            },
            activeNavInputSearch(t) {
                this.navInputSearch.active = t;
                if (t) {
                    setTimeout(() => {
                        this.$refs['navbar-input-search'].focus();
                    }, 200);
                }
            },
            scrollNavHandler() {
                this.el = this.jq(window);
                this.el.scroll(() => {
                    let st = this.el.scrollTop();
                    if (st > this.lastScrollTop) {
                        // Scroll Down
                        if (st > this.navbarHeight) {
                            this.toggleFixedNav(true);
                        }
                    } else {
                        // Scroll Up
                        if (this.navbarHeight - st >= this.navbarHeight - 1) {
                            this.toggleFixedNav(false);
                        }
                    }
                    this.lastScrollTop = st;
                });//
            },
            removeHandlers() {
                if (this.el)
                    this.el.off('scroll');
            },
        },
        mounted() {
            this.scrollNavHandler();
        },
        beforeDestroy() {
            this.removeHandlers();
        }
    });
</script>
<style scoped>

</style>

