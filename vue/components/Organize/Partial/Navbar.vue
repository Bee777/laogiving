<template>
    <div class="nav-bar-fixed-container" ref="main-nav-bar">
        <div class="nav-bar metabar"
             :class="[{'metabar--affixed': isFixedNav, 'is-transitioning': isTransitionFixedNav}]"
             :style="`-webkit-transform: translateY(-${ isFixedNav? fixedNavBarToHeight: 0}px);transform: translateY(-${isFixedNav? fixedNavBarToHeight: 0}px);`">
            <!--TopNav-->
            <div ref="nav-bar-top" class="header_meta header_meta_one flex flex-scale-auto">
                <div class="full-width-percent bg-smoke">
                    <div class="pd-l-15">
                        <ul class="social">
                            <li><a target="_blank" :href="s.facebook"><i class="fab fa-facebook"></i></a></li>
                            <li><a target="_blank" :href="s.instagram"><i class="fab fa-instagram"></i></a></li>
                            <li><a target="_blank" :href="s.youtube"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                        <nav class="meta-login">
                            <ul>
                                <li><a @click="$utils.Location('/about')" class="cursor">About</a></li>
                                <li><a @click="$utils.Location('/contact')" class="cursor">Contact Us</a></li>
                                <li class="call"><i class="lnr lnr-smartphone"></i>Call Us {{s.phone}}</li>
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
                                   @keyup.enter="$utils.Location(`/posts/activities?q=${dataQuery}&search=yes`)"
                                   v-model="dataQuery"
                                   class="nav-input-space-left nav-input-search"
                                   type="text" placeholder="Search">
                            <i @click="activeNavInputSearch(false)" class="material-icons cursor">close</i>
                        </div>
                    </div>
                    <div v-show="!navInputSearch.active" class="flex flex-scale-auto">
                        <div class="site-branding flex-start">
                            <a @click="$utils.Location('/')">
                                <img ref="logo-image" alt="laogiving"
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
                                    <li :class="isRoute('home', {includes: ['our-volunteering']})"><a
                                        @click="Route({name: 'home', query: {active_page: 'our-volunteering', user_id: $route.query.user_id}})"
                                        class="cursor" :class="isRoute('home', {includes: ['our-volunteering']})">Our
                                        Volunteering</a></li>
                                    <li :class="isRoute('home', {includes: 'all', excepts: ['our-volunteering']})"><a
                                        :class="isRoute('home', {includes: 'all', excepts: ['our-volunteering']})"
                                        @click="Route({name: 'home', query: {active_page: 'account'}})"
                                        class="cursor">My Account</a></li>
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

        <div class="metabar metabar--spacer" :style="`height: ${navbarHeight}px;`"></div>

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
                navbarHeight: 127,
                fixedNavBarToHeight: 48,
                fixedNavBarHeight: 79,
                isFixedNav: false,
                transitionFixedNav: 200,
                isTransitionFixedNav: false,
                navInputSearch: {active: false, text: ''},
                dataQuery: '',
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
            setNavHeight() {
                //set data
                let that = this;
                setNavHeight();
                //set data
                //image loading
                function setNavHeight() {
                    let navTopHeight = (that.$refs['nav-bar-top'] || {}).clientHeight;
                    let navHeight = (that.$refs['nav-bar'] || {}).clientHeight;
                    that.navbarHeight = navTopHeight + navHeight;
                    that.fixedNavBarTopHeight = navTopHeight;
                    that.fixedNavBarHeight = navHeight;
                    that.$emit('onNavbarFixed', {state: true, height: that.navbarHeight});
                }

                let logoImage = this.$refs['logo-image'];
                if (logoImage) {
                    if (logoImage.complete) {
                        setNavHeight();
                    } else {
                        logoImage.addEventListener('load', setNavHeight);
                        logoImage.addEventListener('error', setNavHeight)
                    }
                }
                //image loading
            },
            scrollNavHandler() {
                //set scroll info
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.setNavHeight();
                    }, 300);
                });
                let nScroll = this.fixedNavBarToHeight,
                    Scroll = this.fixedNavBarToHeight, st = 0;
                this.el = this.jq(window);
                //set scroll info

                this.el.scroll(() => {
                    st = this.el.scrollTop();
                    if (st > this.lastScrollTop) {
                        // Scroll Down
                        if (st > nScroll) {
                            this.toggleFixedNav(true);
                        }
                        this.isTransitionFixedNav = false;
                    } else {
                        // Scroll Up
                        if (st <= Scroll) {
                            this.toggleFixedNav(false);
                        }
                        if (st <= this.transitionFixedNav) {
                            this.isTransitionFixedNav = true;
                        }
                    }
                    this.lastScrollTop = st;
                });//
            },
            removeHandlers() {
                if (this.el)
                    this.el.off('scroll');
            },
            isRoute(n, {includes, excepts}) {
                let nameBool = this.$route.name === n;
                let active_page = this.$route.query.active_page;
                if (includes === 'all') {
                    return (nameBool && !((excepts || []).includes(active_page))) ? 'active' : ''
                }
                return (nameBool && (includes || []).includes(active_page)) ? 'active' : '';
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

<style lang="scss" scoped>

    .metabar {
        position: absolute;
        display: block;
        z-index: 500;
        width: 100%;
        font-size: 16px;
        background: #fff;
        color: rgba(0, 0, 0, .54);
        letter-spacing: 0;
        font-weight: 400;
        font-style: normal;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        top: 0;
    }

    .metabar--spacer {
        position: relative;
        z-index: 100;
    }

    .metabar--affixed {
        position: fixed;
        background: #fff;
        -webkit-box-shadow: 0 2px 2px -2px rgba(0, 0, 0, .15);
        box-shadow: 0 2px 2px -2px rgba(0, 0, 0, .15);
        -webkit-transform: translateY(-100%);
        transform: translateY(-100%);
    }

    .metabar--affixed.is-transitioning {
        -webkit-transition: -webkit-transform .3s;
        transition: -webkit-transform .3s;
        transition: transform .3s;
        transition: transform .3s, -webkit-transform .3s;
    }
</style>
