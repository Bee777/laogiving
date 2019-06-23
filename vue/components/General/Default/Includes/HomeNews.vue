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
                    <div class="col-xs-12 col-sm-6 col-md-4 zoom"
                         v-for="(item, idx) in $store.state.homeData.latest_news" :key="idx">
                        <div class="events">
                            <a @click="Route({name: 'news-single',  params: {id: item.id} })" class="img-thumb cursor">
                                <figure class="image-relative">
                                    <div class="image-card-container">
                                        <img class="image-card" :src="`${item.image}`" :alt="item.title"/>
                                    </div>
                                </figure>
                            </a>
                            <div class="events-info">
                                <h3><a class="cursor" @click="Route({name: 'news-single',  params: {id: item.id} })">{{item.title}}</a></h3>
                                <p v-html="$utils.sub($utils.strip(item.description), 80)"></p>
                                <ul class="events-time">
                                    <li><span>Updated At</span> <span>{{item.formatted_updated_at}}</span>
                                    </li>
                                </ul>
                                <a @click="Route({name: 'news-single',  params: {id: item.id} })"
                                   class="know-more cursor">Know More <i class="lnr lnr-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center col-xs-12">
                        <a @click="Route({name: 'news'})" data-animation="animated zoomInUp"
                           class="btn btn-medium btn-blue">All News<i class="lnr lnr-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data: () => ({

        })
    };
</script>
<style scoped>
    .image-relative {
        position: relative;
        max-width: 100%;
    }
    .image-card-container {
        width: 100%;
        height: 100%;
        padding-top: 70%;
    }
    .image-card{
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 100%;
        display: block;
    }
</style>
