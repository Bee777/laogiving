<template>
    <div class="nav-bar-fixed-container" ref="main-nav-bar">
        <div class="nav-bar" :class="[{'nav-bar-fixed' : isFixedNav}]">
            <!--TopNav-->
            <div class="header_meta header_meta_one flex flex-scale-auto" v-if="!isFixedNav">
                <div class="full-width-percent bg-smoke">
                    <div class="pd-l-15">
                        <ul class="social">
                            <li><a><i class="fab fa-facebook"></i></a></li>
                            <li><a><i class="fab fa-instagram"></i></a></li>
                            <li><a><i class="fab fa-youtube"></i></a></li>
                        </ul>
                        <nav class="meta-login">
                            <ul>
                                <li><a @click="$utils.Location('/about')" class="cursor">About</a></li>
                                <li><a @click="$utils.Location('/contact')" class="cursor">Contact Us</a></li>
                                <li class="call"><i class="lnr lnr-smartphone"></i>Call Us +731 234 5678</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--TopNav-->
            <!--MainTopNav-->
            <header class="site-header home-one" id="masthead" ref="nav-bar">
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
                            <a @click="$utils.Location('/')">
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
                                    <li><a @click="$utils.Location('/posts/activities')" class="cursor">Be a Volunteer</a></li>
                                    <li><a @click="Route({name: 'home', query: {active_page: 'account'}})" class="cursor">My Account</a></li>
                                    <li><a @click="Logout()" class="menu-button">Sign
                                        Out</a>
                                    </li>
                                    <li><a @click="activeNavInputSearch(true)" class="search-menu cursor"><i
                                        class="material-icons">search</i></a></li>
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
                navbarHeight: 170,
                fixedNavBarHeight: 64,
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
                this.$emit('onNavbarFixed', {state: t, height: this.navbarHeight});
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
                //set scroll info
                setTimeout(() => {
                    this.navbarHeight = this.$refs['main-nav-bar'].clientHeight;
                    this.fixedNavBarHeight = this.$refs['nav-bar'].clientHeight;
                }, 100);

                let nScroll = this.navbarHeight - this.fixedNavBarHeight,
                    Scroll = this.navbarHeight + this.fixedNavBarHeight, st = 0;
                this.el = this.jq(window);
                //set scroll info

                this.el.scroll(() => {
                    st = this.el.scrollTop();
                    if (st > this.lastScrollTop) {
                        // Scroll Down
                        if (st > nScroll) {
                            this.toggleFixedNav(true);
                        }
                    } else {
                        // Scroll Up
                        if (st <= Scroll) {
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
        created() {
            this.toggleFixedNav = this.$throttle(this.toggleFixedNav, 250);
        },
        mounted() {
            this.scrollNavHandler();
        },
        beforeDestroy() {
            this.removeHandlers();
        }
    });
</script>

