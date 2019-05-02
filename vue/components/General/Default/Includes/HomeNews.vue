<template>
    <div>
        <section class="school-events">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h3><span>Our</span> News</h3>
                        <ul>
                            <li>Read our breaking news or find the latest news from us.</li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 zoom" v-for="(i, idx) in listing" :key="idx">
                        <div class="events">
                            <a @click="Route({name: 'news-single',  params: {id: i} })" class="img-thumb cursor">
                                <figure>
                                    <img :src="`${baseRes}assets/images/use_img/event1.jpg`" alt=""/></figure>
                            </a>
                            <div class="events-info">
                                <h3><a  class="cursor" @click="Route({name: 'news-single',  params: {id: i} })">Event Name Here {{ i }}</a></h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <ul class="events-time">
                                    <li>Date <span>Aug 25 -27, 2015</span>
                                    </li>
                                </ul>
                                <a @click="Route({name: 'news-single',  params: {id: i} })" class="know-more cursor">Know More <i class="lnr lnr-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center col-xs-12">
                        <a @click="Route({name: 'news'})" data-animation="animated zoomInUp" class="btn btn-medium btn-blue">All News<i class="lnr lnr-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data: () => ({
            listing: [1, 2, 3],
        })
    };
</script>
