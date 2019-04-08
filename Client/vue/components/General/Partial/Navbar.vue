<template>
    <div>
        <!--TopNav-->
        <div class="header_meta header_meta_one">
            <div class="container">
                <div class="row">
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
                            <li><a href="#login-form" class="fancybox">Login</a></li>
                            <li><a  href="#register-form" class="fancybox">Signup</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!--TopNav-->
        <!--MainTopNav-->
        <header class="site-header home-one" id="masthead">
            <div class="container">
                <div class="row">
                    <div class="site-branding col-xs-12 col-sm-3"><a @click="Route({name: 'home'})">
                        <img alt="educationpress"
                             class="brand"
                             :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"/></a>
                    </div>
                    <nav class="main-navigation navbar navbar-default" id="site-navigation">
                        <div class="navbar-header">
                            <button data-target=".navbar-ex1-collapse" data-toggle="collapse" class="navbar-toggle"
                                    type="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav">
                                <li class="dropdown active">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                       aria-expanded="false" @click="Route({name: 'home'})">
                                        Home <span class="caret"></span></a>
                                    <ul class=" dropdown-menu" role="menu">
                                        <li><a>Home Page 1</a></li>
                                        <li><a>Home Page 2</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                       aria-expanded="false">
                                        Classes <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a>Classes 2 Columns List</a></li>
                                        <li><a>Classes 3 Columns List</a></li>
                                        <li><a>Classes Detail</a></li>
                                        <li><a>Classes Detail With Video</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        Events <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a>Event Listing</a></li>
                                        <li><a>Event Detail</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        Pages <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a>About Us</a></li>

                                        <li><a>Gallery</a></li>
                                        <li><a>FAQs</a></li>
                                        <li><a>Shortcodes</a></li>
                                        <li><a>Plans and Pricing</a></li>
                                        <li><a>404 Error</a></li>
                                        <li><a>Under Construction</a></li>
                                        <li><a>Login</a></li>
                                        <li><a>Register</a></li>
                                        <li><a>Edit Profile</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        Blog <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a>Blog Listing</a></li>
                                        <li><a>Blog Detail</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        Shop <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a>Shopping Cart</a></li>
                                        <li><a>Checkout</a></li>
                                    </ul>
                                </li>
                                <li><a>Contact Us</a></li>
                                <li class="pull-right">
                                    <a title="View your cart" class="menu-cart">
                                        <i class="lnr lnr-cart"></i> <span>0</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!--MainTopNav-->
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
        }
    });
</script>
<style scoped>

</style>

