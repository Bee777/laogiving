<template>
    <div>
        <div id="flex" class="flexslider laogiving">
            <ul class="slides">
                <li style="background:url(/bundles/general/assets/images/use_img/banner1.jpg) no-repeat center; background-size:cover;">
                    <div class="container">
                        <div class="row">
                            <div class="slide-caption">
                                <h2 data-animation="animated bounceInLeft"> An Innovative Graduate University of
                                    Theology </h2>
                                <a data-animation="animated zoomInUp"
                                   class="btn btn-medium btn-blue">View Campus <i class="lnr lnr-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </li>
                <li style="background:url(/bundles/general/assets/images/use_img/banner_img7.jpg) no-repeat center; background-size:cover;">
                    <div class="container">
                        <div class="row">
                            <div class="slide-caption">
                                <h2 data-animation="animated bounceInLeft"> An Innovative Graduate University of
                                    Theology </h2>
                                <a data-animation="animated zoomInUp"
                                   class="btn btn-medium btn-blue">View Campus <i class="lnr lnr-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div id="login-form" style="display:none;">
            <div class="row">
                <h3>Login</h3>
                <p>Please Login to Create a New Course</p>
                <form id="login" novalidate>
                    <input name="email" type="text" placeholder="Email or Username">
                    <input name="password" type="text" placeholder="Password">
                    <div class="row remeber">
                        <label><input name="rember" type="checkbox" value=""> Remember Me</label>
                        <a href="home-1.html#">Forgot Password?</a>
                    </div>
                    <div class="text-center button">
                        <input name="Login" type="button" value="Login Now">
                    </div>
                </form>
            </div>
        </div>

        <div id="register-form" style="display:none;">
            <div class="row">
                <h3>Register</h3>
                <p>Please Register to Create a New Account</p>
                <form id="register" novalidate>
                    <input name="name" type="text" placeholder="Name">
                    <input name="username" type="text" placeholder="Username">
                    <input name="email" type="text" placeholder="Email">
                    <input name="password" type="text" placeholder="Password">
                    <input name="confirmpassword" type="text" placeholder="Confirm Password">
                    <div class="row new-login">
                        Already have an account? <a href="home-1.html#">Login to your account! </a>
                    </div>
                    <div class="text-center button">
                        <input name="create-account" type="button" value="Create an Account">
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/GeneralBase.js";
    import {mapActions} from 'vuex'

    export default Base.extend({
        name: "Home",
        data: () => ({
            contactInfo: {header_title: 'Contact Us Now'}//for contact form
        }),
        components: {},
        methods: {
            ...mapActions(['postSendContact']),
            sendContact() {
                let c = this.contactInfo;
                if (this.validated().loading_send_contact) {
                    c.header_title = 'Sending Information...';
                    return;
                }
                this.postSendContact(c)
                    .then(res => {
                        if (res.success) {
                            this.contactInfo = {header_title: 'Sent the information!'};
                            setTimeout(() => {
                                this.contactInfo = {header_title: 'Contact Us Now'}
                            }, 3500);
                        }
                    })
                    .catch(err => {
                        if (err && !err.errors) {
                            c.header_title = 'Failed to send the information!';
                        }
                    });
            }
        },
        mounted() {
            this.jq('.laogiving').flexslider({
                animation: "fade",
                start: () => {
                    this.jq('body').removeClass('loading');
                },
                before: (slider) => {
                    var $animateSlide = this.jq(slider).find("[data-animation ^= 'animated']");
                    doAnimations($animateSlide);
                }
            });
        },
        created() {
            this.setPageTitle(`Home`);
        }
    });
</script>


