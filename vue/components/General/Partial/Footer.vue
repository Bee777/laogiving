<template>
    <div>
        <footer class="site-footer" id="colophon">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4"><img
                        :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`" alt=""/></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 footer-widget">
                        <aside class="widget widget_text">
                            <div class="textwidget">
                                We want to build a City of Good.
                                Something beyond all the good we already have, and focus on the good we can do.
                            </div>
                        </aside>
                        <aside class="widget socialmedia-widget">
                            <ul class="social">
                                <li><a target="_blank" :href="s.twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a target="_blank" :href="s.facebook"><i class="fab fa-facebook"></i></a></li>
                                <li><a target="_blank" :href="s.instagram"><i class="fab fa-instagram"></i></a></li>
                                <li><a target="_blank" :href="s.youtube"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-xs-12 col-sm-4 footer-widget">
                        <aside class="widget widget_nav_menu">
                            <ul class="menu">
                                <li><a class="cursor" @click="goTo({name: 'home', href: '/'})">Home</a></li>
                                <li><a class="cursor" @click="goTo({name: 'activities', href: '/posts/activities'})">Be
                                    a Volunteer</a></li>
                                <li v-if="!LoggedIn()">
                                    <a class="cursor"
                                       @click="goTo({name: 'register', query: {type: 'organize'}, href: '/register?type=organize' })">Be
                                        an
                                        Organization</a></li>
                                <li><a class="cursor" @click="goTo({name: 'news', href: '/posts/news'})">News</a></li>
                                <li><a class="cursor" @click="goTo({name: 'about', href: '/about'})">About Us</a></li>
                                <li><a class="cursor" @click="goTo({name: 'contact', href: '/contact'})">Contact US</a>
                                </li>
                                <!--<li><a @click="Route({name: 'activities'})">Privacy Policy</a></li>-->
                            </ul>
                        </aside>

                    </div>
                    <div class="col-xs-12 col-sm-4 footer-widget">
                        <aside class="widget newsletter-widget">
                            <h3>NEWSLETTER</h3>
                            <p>Receive giving news and other good stories from us!.</p>
                            <form @submit.prevent id="newsletter">
                                <input v-model="news_letter.email" type="email" name="email" class="form-control"
                                       placeholder="Email"/>

                                <button @click="subMitNewsLetter" type="submit" value=""
                                        class="btn btn-orange btn-medium"><i
                                    class="lnr lnr-arrow-right"></i></button>
                                <label v-if="validated().email" class="error-msg" style="display: block;">{{
                                    validated().email }}</label>
                                <label v-if="news_letter.msg" class="success-msg">{{ news_letter.msg }}</label>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="copyright">
                            <p class="develop col-xs-12 col-sm-4 text-right"><a href="/" target="_blank">Copyright ©
                                {{$utils.getDateTime(new Date()).years}} All rights reserved</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/GeneralBase.js";
    import {mapActions} from 'vuex'

    export default Base.extend({
        data: () => ({
            news_letter: {msg: ''},
        }),
        methods: {
            ...mapActions(['postSaveNewsLetter']),
            goTo({name, query, href}) {
                if (this.$context_name === 'app_general') {
                    this.Route({name, query})
                } else {
                    this.$utils.Location(href);
                }
            },
            subMitNewsLetter() {
                this.postSaveNewsLetter(this.news_letter).then((res) => {
                    if (res.success) {
                        this.news_letter.msg = res.msg;
                        this.news_letter.email = '';
                        setTimeout(() => {
                            this.news_letter.msg = '';
                        }, 3500);
                    }
                }).catch((err) => {
                    //console.log(err);
                })
            },
        }
    });
</script>
