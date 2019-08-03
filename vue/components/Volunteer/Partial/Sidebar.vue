<template>
    <div id="main-side-bar">
        <div id="ms-sidebar" class="sidebar is-hidden-desktop-only is-hidden-desktop"
             :class="isSidebar==='is-active' ? 'left-side open' : 'left-side'"
             :style="`top: calc(0px);`">
            <section class="my-sidebar-drawer">
                <div class="my-sidebar-drawer-loginInfo">
                    <div class="sidebar-container" @click="GoToHomePage()">
                        <img class="i-sidebar-content-fill-content i-sidebar-content-replaced-content"
                             :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`">
                    </div>
                    <div class="drawer-unlogin">
                        <a @click="GoToHomePage()" class="drawer-seeker">
                            <span class="line-bottom">Lao giving</span>
                        </a>
                        <router-link @click.native.prevent="maskClick()" :to="{ name: 'home', query: { active_page: 'account' } }">
                            <a class="drawer-employer">
                                <span>My Account</span>
                            </a>
                        </router-link>
                    </div>
                </div>
                <ul class="sidebar-drawer-box">
                    <template>
                        <li :class="isRoute('home')">
                            <router-link :to="{name: 'home', query: { active_page: 'dashboard' } }" @click.native.prevent="maskClick()">
                                <i class="sidebar-icon-md material-icons">
                                    dashboard
                                </i>
                                <span>Dashboard</span>
                            </router-link>
                        </li>
                        <li v-if="($route.query.search !== 'yes')">
                            <a class="cursor" @click="GoToSearchPage()">
                                <i class="sidebar-icon-md material-icons">
                                    search
                                </i>
                                <span>Search</span>
                            </a>
                        </li>
                        <li :class="isRoute('news')">
                            <a class="cursor" @click="goToPage('/posts/news')">
                                <i class="sidebar-icon-md material-icons">
                                    rss_feed
                                </i>
                                <span>News</span>
                            </a>
                        </li>
                        <li :class="isRoute('activities')">
                            <a class="cursor" @click="goToPage('/posts/activities?type=volunteer')">
                                <i class="sidebar-icon-md material-icons">
                                    list_alt
                                </i>
                                <span>Activities</span>
                            </a>
                        </li>
                    </template>
                </ul>

                <ul class="sidebar-drawer-box">
                    <li :class="isRoute('contact')">
                        <a class="cursor" @click="goToPage('/contact')">
                            <i class="sidebar-icon-md material-icons">
                                call
                            </i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                    <li :class="isRoute('about')">
                        <a class="cursor" @click="goToPage('/about')">
                            <i class="sidebar-icon-md material-icons">
                                info
                            </i>
                            <span>About</span>
                        </a>
                    </li>
                    <li class="drawer-help" v-if="LoggedIn()">
                        <a @click.prevent="setLogout">
                            <i :class="logoutClass" class="sidebar-icon-md fas"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
                <ul class="sidebar-drawer-box"></ul>
            </section>
        </div>
        <div class="sidebar-mask" @click="maskClick()" :class="isSidebar==='is-active' ? '' : 'left-side' "
             v-if="isMobile"></div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapActions, mapMutations} from 'vuex'

    export default {
        data() {
            return {
                ...mapGetters(['LoggedIn']),
                logoutClass: 'fa-external-link-square-alt'
            }
        },
        computed: {
            ...mapState(['isMobile', 'isSidebar', 'authUserInfo']),
        },
        watch: {
            isSidebar: function (n, o) {
                if (n === 'left-side') {
                    this.removeClasses()
                } else {
                    this.addClasses()
                }
            },
            LoggedIn: function (v) {
                this.maskClick()
            }
        },
        methods: {
            ...mapMutations(['setSidebar']),
            ...mapActions(['Logout']),
            removeClasses() {
                this.jq("body").removeClass("hidden sidebar");
                this.jq("html").removeClass("hidden sidebar");
            },
            addClasses() {
                this.jq("html").addClass("hidden sidebar");
                this.jq("body").addClass("hidden sidebar");
            },
            maskClick() {
                this.removeClasses();
                this.setSidebar({isSidebar: (this.isSidebar === 'is-active' ? 'left-side' : '')});
            },
            setLogout() {
                this.logoutClass = 'fa-spinner';
                this.Logout();
            },
            isRoute(n) {
                return this.$route.name === n ? 'is-active' : ''
            },
            GoToHomePage() {
                this.$utils.Location('/');
                this.maskClick();
            },
            goToPage(href) {
                this.$utils.Location(href);
                this.maskClick();
            },
            GoToSearchPage() {
                this.$utils.Location(`/posts/activities?q=&search=yes`);
            },
        },
    }
</script>
<style scoped>

    li.is-active {
        background-color: #ECECEC !important;
    }

    .sidebar {
        position: fixed !important;
        top: 0;
        max-height: 100vh !important;
        height: 100vh;
        max-width: 80vw !important;
        background-color: #efefef;
        min-width: 45px !important;
        outline: none;
        overflow-x: hidden !important;
        overflow-y: auto !important;
        z-index: 10000;
        -webkit-overflow-scrolling: touch;
        will-change: transform;
        -webkit-transition: -webkit-transform 233ms cubic-bezier(0, 0, .21, 1);
        transition: -webkit-transform 233ms cubic-bezier(0, 0, .21, 1);
        transition: transform 233ms cubic-bezier(0, 0, .21, 1);
        transition: transform 233ms cubic-bezier(0, 0, .21, 1), -webkit-transform 233ms cubic-bezier(0, 0, .21, 1);
        display: inline-block;
    }

    .sidebar.left-side {
        left: 0 !important;
        -webkit-transform: translateX(-100%) !important;
        transform: translateX(-100%) !important;
    }

    .sidebar.open {
        -webkit-transform: translateX(0) !important;
        transform: translateX(0) !important;
    }

    .my-sidebar-drawer-loginInfo {
        height: 128px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        background-color: #ed1f24;
        overflow: hidden;
        background-image: linear-gradient(to bottom right, #ed1424, #ed1f24);
        background-repeat: no-repeat;
        background-size: cover;
    }

    .my-sidebar-drawer {
        width: 100%;
        height: 100%;
        -overflow-scrolling: touch;
    }

    /** box */
    .sidebar-drawer-box {
        width: 100%;
        color: #555;
        margin: 0;
        padding: 8px 0;
    }

    .sidebar-drawer-box li {
        position: relative;
        height: 48px;
        line-height: 48px;
        overflow: hidden;
        font-size: 14px;
    }

    .sidebar-drawer-box li a {
        display: block;
    }

    .sidebar-drawer-box li span {
        font-weight: 600;
        color: #3A3E4A;
    }

    .sidebar-drawer-box li .sidebar-icon-md {
        padding: 10px 16px 10px 16px;
        margin-right: 16px;
        float: left;
        font-size: 26px !important;
        color: #898B92;
        min-width: 56px;
        max-width: 56px;
    }

    .sidebar-icon-md {
        position: relative;
        display: inline-block;
        font-size: 16px !important;
        line-height: 1;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: .2px;
        -moz-osx-font-smoothing: grayscale;
    }

    /** box */
    .my-sidebar-drawer-loginInfo .sidebar-container {
        width: 96px;
        height: 96px;
        padding: 16px;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
    }

    .my-sidebar-drawer-loginInfo .sidebar-container img {
        display: block;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
    }

    .i-sidebar-content-layout-size-defined .i-sidebar-content-fill-content {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    .i-sidebar-content-fill-content {
        display: block;
        height: 0;
        max-height: 100%;
        max-width: 100%;
        min-height: 100%;
        min-width: 100%;
        width: 0;
        margin: auto;
    }

    .i-sidebar-content-replaced-content, .i-sidebar-content-screen-reader {
        padding: 0 !important;
        border: none !important;
    }

    .my-sidebar-drawer-loginInfo .drawer-unlogin {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        width: 100%;
        padding: 2px 16px 16px;
        white-space: nowrap;
        font-size: 15px;
        line-height: 1.2;
        color: #fff;
    }

    .my-sidebar-drawer-loginInfo .drawer-seeker {
        display: inline-block;
        padding: 0 6px 0 0;
        font-size: 15px;
        line-height: 1.2;
        border-right: solid 1px #fff;
        color: #fff;
    }

    .my-sidebar-drawer-loginInfo .drawer-employer {
        display: inline-block;
        padding-left: 2px;
        font-size: 15px;
        line-height: 1.2;
        color: #fff;
    }

    #ms-sidebar {
        background: #fff;
        width: 80%;
        height: 100%;
    }

    .sidebar-mask {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        opacity: 0.2;
        background-image: none !important;
        background-color: #000;
        z-index: 9999;
    }

    .sidebar-mask.left-side {
        display: none;
    }

    .ine-bottom {
        border-bottom: 1px solid #ffffff !important;
    }

    .line-bottom-blue {
        border-bottom: 1px solid #004FCE !important;
    }

    .line-bottom-green {
        border-bottom: 1px solid #00D29D !important;
    }

    .sidebar-drawer-box + .sidebar-drawer-box {
        border-top: 1px solid #EBEBEC;
    }

    @media screen and (max-width: 366px) {
        .my-sidebar-drawer-loginInfo .drawer-seeker, .my-sidebar-drawer-loginInfo .drawer-employer {
            font-size: 14.2px;
        }
    }
</style>
