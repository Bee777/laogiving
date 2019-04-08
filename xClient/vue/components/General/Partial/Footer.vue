<template>
    <div>
        <footer class="footer is-primary">
            <div class="section">
                <div class="container">
                    <div class="columns is-multiline">
                        <div class="column is-4">
                            <div class="title">Japan Alumni Of Laos</div>
                            <router-link :to="{name:'home'}">
                                <figure class="image">
                                    <img
                                        class="footer-logo"
                                        :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                                        alt="Placeholder image"
                                    >
                                </figure>
                            </router-link>
                            <p class="footer-text">ສະມາຄົມອະດີດນັກສຶກສາລາວ ຈາກປະເທດຍີ່ປຸ່ນ</p>
                            <h1 class="title">Follow us</h1>
                            <div class="column-media is-fultiline is-mobile">
                                <div id="social" v-if="!$utils.isEmptyVar( homeData.ContactInfo )">
                                    <a v-if="!$utils.isEmptyVar(homeData.ContactInfo.twitter)"
                                       class="twitterBtn smGlobalBtn" target="_blank"
                                       :href="homeData.ContactInfo.twitter"><i class="fab fa-twitter"></i></a>
                                    <a class="facebookBtn smGlobalBtn" target="_blank"
                                       :href="homeData.ContactInfo.facebook"><i class="fab fa-facebook-f"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="column is-4">
                            <div class="title">Useful Links</div>
                            <div class="columns">
                                <div class="column">
                                    <div class="footer-link">
                                        <router-link :to="{name:'about'}" class="navbar-item footer-item">About Us
                                        </router-link>
                                        <router-link :to="{name:'contact'}" class="navbar-item footer-item">Contact
                                        </router-link>
                                        <router-link :to="{name:'news'}" class="navbar-item footer-item">News
                                        </router-link>
                                        <router-link
                                            :to="{name:'scholarships'}"
                                            class="navbar-item footer-item"
                                        >Scholarship
                                        </router-link>
                                        <!--<router-link-->
                                        <!--:to="{name:'dictionary'}"-->
                                        <!--class="navbar-item footer-item"-->
                                        <!--&gt;Dictionary-->
                                        <!--</router-link>-->
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="footer-link">
                                        <router-link
                                            :to="{name:'events'}"
                                            class="navbar-item footer-item footer-item"
                                        >Event
                                        </router-link>
                                        <router-link :to="{name:'forum'}" class="navbar-item footer-item">Forum
                                        </router-link>
                                        <router-link
                                            :to="{name:'organize-charts'}"
                                            class="navbar-item footer-item"
                                        >Organization Chart
                                        </router-link>
                                        <router-link :to="{name:'activities'}" class="navbar-item footer-item">
                                            Activity
                                        </router-link>
                                        <router-link :to="{name:'contact'}" class="navbar-item footer-item">Contact
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-4">
                            <div class="title">Contact Us</div>
                            <div class="social">
                                <div class="columns">
                                    <div class="column">
                                        <ul v-if="!$utils.isEmptyVar( homeData.ContactInfo )">
                                            <li class="footer-contact">
                                                <i class="fa fa-phone"></i>
                                                <span>{{homeData.ContactInfo.phone}}</span>
                                            </li>
                                            <li class="footer-contact">
                                                <i class="fa fa-envelope"></i>
                                                <span>{{homeData.ContactInfo.email}}</span>
                                            </li>
                                            <li class="footer-contact">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{homeData.ContactInfo.address}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="subscribe">-->
                            <!--<div class="field has-addons">-->
                            <!--<div class="control">-->
                            <!--<input class="input" type="text" placeholder="Your Email">-->
                            <!--</div>-->
                            <!--<div class="control">-->
                            <!--<a class="button is-info">Subscribe</a>-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="footer-bar">
            <div class="section">
                <div class="container">
                    <div class="columns">
                        <div class="column">
                            <p>
                                Copyright ©
                                {{$utils.getDateTime(new Date()).years}} All rights reserved | Powered by
                                <a
                                    href="https://www.mekong.digital"
                                    target="_blank"
                                >Mekong Digital Works</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/GeneralBase.js";
    export default Base.extend({});
</script>
