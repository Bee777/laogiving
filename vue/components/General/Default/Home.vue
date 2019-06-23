<template>
    <div>
        <Carousel :items="homeData.banners">
            <template slot-scope="{ data, idx, path}">
                <li
                    :style="`background:url(${baseUrl}/assets/images/banners/${data.image}) no-repeat center; background-size:cover;`"
                    :key="idx">
                    <div class="container">
                        <div class="row">
                            <div class="slide-caption">
                                <h2 data-animation="animated bounceInLeft">
                                    {{data.title}}</h2>
                                <a target="_blank" :href="data.link" data-animation="animated zoomInUp"
                                   class="btn btn-medium btn-blue">{{data.link_name}}<i
                                    class="lnr lnr-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </li>
            </template>
        </Carousel>
        <!--Portlet -->
        <section class="about-with-slide">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 aboutus">
                        <div class="row">
                            <div class="col-xs-12 col-sm-7">
                                <h3>All-in-one Giving</h3>
                                <h4><span>We want to make giving simple, fun and meaningful for you. The possibilities are endless!</span>
                                </h4>
                                <p>Find a volunteer activity that you're interested in, to use the skills you have,
                                    right here in Laos.</p>
                                <a @click="Route({name:'activities'})" class="btn btn-medium btn-blue">BE A VOLUNTEER <i
                                    class="lnr lnr-arrow-right"></i></a>
                            </div>
                            <div class="col-xs-12 col-sm-5">
                                <div class="about-slide">
                                    <ul class="slides">
                                        <li><a><img :src="`${baseRes}assets/svg/ic-volunteer-db.svg`" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Portlet -->
        <!--News-->
        <InHomeNews/>
        <!--News-->
        <!--Count Poster-->
        <section class="our-features">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h3><span>OUR</span> Stage</h3>
                        <ul>
                            <li>Total number of volunteers and activities</li>
                        </ul>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 feature">
                            <div class="is-left-side ">
                                <img alt="hours" :src="`${baseRes}assets/svg/ic-hours.svg`">
                                <h3 class="bg-stats__stats">{{ homeData.states.volunteer_signups || 0 }}</h3>
                                <p>volunteer signups</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 feature">
                            <div class="is-right-side ">
                                <img alt="hours" :src="`${baseRes}assets/svg/ic-home.svg`">
                                <h3 class="bg-stats__stats">{{ homeData.states.volunteering_created || 0 }}</h3>
                                <p>activities created.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Count Poster-->
        <!--Causes-->
        <InHomeCauses/>
        <!--Causes-->
        <section class="call-to-action">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-8">
                            <h3>You can make a difference today!.</h3>
                            <p>There's a lot more we can do, together.</p>
                        </div>
                        <a @click="Route({name:'about'})" class="btn btn-medium btn-default pull-right">Learn More <i
                            class="lnr lnr-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/GeneralBase.js";
    import {mapActions} from 'vuex'
    import Carousel from '@com/General/Partial/Carousel.vue'
    import InHomeNews from '@com/General/Default/Includes/HomeNews.vue'
    import InHomeCauses from '@com/General/Default/Includes/HomeExploreCauses.vue'

    export default Base.extend({
        name: "Home",
        data: () => ({
            contactInfo: {header_title: 'Contact Us Now'}//for contact form
        }),
        components: {
            Carousel,
            InHomeNews,
            InHomeCauses
        },
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
        created() {
            this.setPageTitle(`Home`);
        }
    });
</script>


