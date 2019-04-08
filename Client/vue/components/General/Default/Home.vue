<template>
    <div>
        <div id="flex" class="flexslider laogiving">
            <ul class="slides">
                <li style="background:url(/bundles/general/assets/images/banner1.jpg) no-repeat center; background-size:cover;">
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
                <li style="background:url(/bundles/general/assets/images/banner7.jpg) no-repeat center; background-size:cover;">
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


