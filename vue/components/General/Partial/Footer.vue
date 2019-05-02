<template>
    <div>
        <footer class="site-footer" id="colophon">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4"><img :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`" alt="" /></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 footer-widget">
                        <aside class="widget widget_text">
                            <div class="textwidget">
                                The point of using Lorem Ipsum is that it has a more or less normal distribution of letters, as opposed to using
                                'Content here, content here', making it look like readable English.
                            </div>
                        </aside>
                        <aside class="widget socialmedia-widget">
                            <ul class="social">
                                <li><a><i class="fab fa-facebook"></i></a></li>
                                <li><a><i class="fab fa-instagram"></i></a></li>
                                <li><a><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-xs-12 col-sm-4 footer-widget">
                        <aside class="widget widget_nav_menu">
                            <ul class="menu">
                                <li><a>Home</a></li>
                                <li><a>Be a Volunteer</a></li>
                                <li><a>Be an Organization</a></li>
                                <li><a>News</a></li>
                                <li><a>About Us</a></li>
                                <li><a>Contact US</a></li>
                                <li><a>Privacy Policy</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-xs-12 col-sm-4 footer-widget">
                        <aside class="widget newsletter-widget">
                            <h3>Sign up now</h3>
                            <p>When an printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <form id="newsletter">
                                <input type="email" name="email" class="form-control" placeholder="Email" />
                                <button type="submit" value="" class="btn btn-orange btn-medium"><i class="lnr lnr-arrow-right"></i></button>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="copyright">
                            <p class="develop col-xs-12 col-sm-4 text-right"> <a href="/" target="_blank">Copyright ©
                                {{$utils.getDateTime(new Date()).years}} All rights reserved</a> </p>
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
    export default Base.extend({});
</script>
