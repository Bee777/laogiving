<template>
    <div>
        <main class="laogiving activity clearfix">
            <div class="ctn">
                <div class="jumbotron">&nbsp;</div>
                <div class="our-vision div-width-80p">
                    <h1 class="h1 dark">Our Vision: The City of Good</h1>
                    <p><b class="dark-grey">Good food. Good education. Good housing.</b><br> Laos is a fine city, known
                        for a lot of good things.<br> But what’s the good in all this good, if you can’t share it with
                        those who aren’t doing so good?<br> We want to build a City of Good.<br> Something beyond all
                        the good we already have, and focus on the good we can do.</p>
                </div>
                <div class="why-give">
                    <h1 class="h1">Why Give With Us?</h1>
                    <p>&nbsp;</p>
                    <h2 class="h2">1) Safe and Secure</h2>
                    <p>We take your online security seriously, so that you have a peace of mind.<br> Your information is
                        kept safe and secure by using a top-of-the-line ISO27001 security certified data centre, and we
                        are always reviewing our safety measurements.</p>
                    <h2 class="h2">2) Trusted by all</h2>
                    <p>LaoGiving.la is backed by the Ministry of Culture, Community &amp; Youth, and you can be sure
                        that the funds you raise go only to registered charities.</p>
                    <h2 class="h2">3) 100% committed to doing good</h2>
                    <p>We provide Giving.sg as our service to the community, and don't charge a service fee.<br> That
                        means 100% of your donation goes towards your chosen charity.</p>
                </div>
                <div class="how-it-works div-width-80p"><h1 class="h1 dark">How it Works</h1>
                    <div class="row mt-30">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="span4"
                                 style="visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                                <img :src="`${baseRes}assets/svg/ic-indi.svg`">
                                <h3 class="h3 mt-16">Individuals</h3>
                                <p>We make it safe, easy, and fun for anyone to give to registered charities. Want to
                                    raise
                                    money for your favourite cause? Or simply looking for volunteering opportunities? No
                                    matter how you want to give, we’re your go-to place!</p></div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="span4"
                                 style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 2s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                                <img :src="`${baseRes}assets/svg/ic-organisation.svg`">
                                <h3 class="h3 mt-16">Groups</h3>
                                <p>Giving is more fun when it’s multiplied, so this is your chance to get your network
                                    involved! If you’re a little shy about your giving, we’ve got your back with options
                                    to
                                    make your profile and giving activities private, so only your members have
                                    access.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="boiler" v-html="s.description"></div>
            </div>
        </main>
    </div>
</template>
<script>
    import Base from "@com/Bases/GeneralBase.js";

    export default Base.extend({
        created() {
            this.setPageTitle(`About us`);
        }
    });
</script>
