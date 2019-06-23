<template>
    <div>
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <header class="entry-header">
                        <h1 class="entry-title">Our News</h1>
                    </header>
                </div>
            </div>
        </div>
        <!--Listing-->
        <div class="page-spacer clearfix">
            <div id="primary" class="content-area">
                <div class="container">
                    <div class="row">
                        <main id="main" class="site-main col-xs-12 col-sm-8 left-block">
                            <article class="post hentry" v-for="(item, idx) in postsData.news.posts.data" :key="idx">
                                <a class="post-thumb cursor"  @click="Route({name: 'news-single', params: {id: item.id}})">
                                    <figure class="image-relative">
                                        <div class="image-card-container">
                                            <img class="image-card" :alt="item.title" :src="`${baseUrl}${item.image}`"/>
                                        </div>
                                    </figure>
                                </a>
                                <header class="entry-header">
                                    <h2 class="entry-title"><a class="cursor"
                                        @click="Route({name: 'news-single', params: {id: item.id}})">{{item.title}}</a>
                                    </h2>
                                </header>

                                <div class="entry-content" v-html="$utils.sub($utils.strip(item.description), 280)">
                                </div>
                                <footer class="entry-footer">
                                    <div class="entry-meta">
                                        <span class="posted-on"><a>{{ item.post_updated }}</a></span>
                                        <span class="byline">by <span class="author vcard"><a class="url">{{item.author}}</a></span></span>
                                        <small>.</small>
                                        <!--<span class="cat-links">Posted in " <a rel="category tag">Online Courses</a> " <small>.</small> </span>-->
                                    </div>
                                </footer>
                                <a @click="Route({name: 'news-single', params: {id: item.id}})"
                                   class="btn btn-medium read-more">Read More <i class="lnr lnr-arrow-right"></i></a>
                            </article>
                            <div class="col-lg-8" v-if="isNotFound()">
                                <div class="devsite-article mt-20">
                                    <h1 class="devsite-page-title">
                                        Search results for <span class="devsite-search-term"><span
                                        class="devsite-search-term">{{ query }}</span></span>
                                    </h1>
                                </div>
                                <div class="result-snippet">No Results</div>
                            </div>
                            <!--<article class="post hentry">-->
                            <!--<blockquote class="post-quote">-->
                            <!--<i class="fa fa-quote-left"></i>-->
                            <!--<p>Praesent volutpatid nuncpretium ullamcorper Nunc infelis magnauis pharetra our is venenatis justo dapibus gravida class aptent.</p>-->
                            <!--<footer>Solvis Denial</footer>-->
                            <!--</blockquote>-->
                            <!--</article>-->
                            <!--<article class="post hentry">-->
                                <!--<a class="post-thumb">-->
                                    <!--<figure><img alt="" :src="`${baseRes}assets/images/use_img/blog_img2.jpg`"/>-->
                                    <!--</figure>-->
                                <!--</a>-->
                                <!--<header class="entry-header">-->
                                    <!--<h2 class="entry-title"><a>The Design of HTML5</a></h2>-->
                                <!--</header>-->
                                <!--<div class="entry-content">-->
                                    <!--<p>Nullam dictum accumsan hendrerit. Donec tempus ex non ante auctor, hendrerit-->
                                        <!--viverra sem interdum.-->
                                        <!--Vivamus sed eros a nisi pulvinar hendrerit. Cras dui nibh, sodales nec orci ut,-->
                                        <!--fringilla molestie sapien.-->
                                        <!--Mauris posuere, nisi eget ornare vestibulum, est est consectetur nisi, eget-->
                                        <!--ullamcorper leo elit sit amet orci.-->
                                        <!--Pellentesque in ex quis felis mattis ultricies. </p>-->
                                <!--</div>-->
                                <!--<footer class="entry-footer">-->
                                    <!--<div class="entry-meta">-->
                                        <!--<span class="posted-on"> <a>March 17, 2016</a></span>-->
                                        <!--<span class="byline"> by <span class="author vcard"><a class="url">Greg Christman</a></span> <small>.</small> </span>-->
                                        <!--<span class="cat-links">Posted in " <a>Online Courses</a> " <small>.</small> </span>-->
                                        <!--<span class="tags-links">Tags " <a rel="tag">HTML5</a> " <small>.</small> </span>-->
                                        <!--<span class="comments-link"><a>3 Comments</a></span>-->
                                    <!--</div>-->

                                <!--</footer>-->
                                <!--<a class="btn btn-medium read-more">Read More <i class="lnr lnr-arrow-right"></i></a>-->
                            <!--</article>-->
                            <!--Pagination -->
                            <div class="pagination" v-if="postsData.news.posts.data">
                                <a @click="prevPage(paginate.current_page - 1)"  v-if="paginate.current_page>1" class="next page-numbers"><i class="fa fa-angle-left"></i></a>
                                <template v-for="p in paginate.last_page">
                                    <template v-if="p===paginate.current_page">
                                        <span class="page-numbers current">{{p}}</span>
                                    </template>
                                    <template v-else>
                                        <a @click="paginateNavigator({pageNo: p})" class="page-numbers">{{ p }}</a>
                                    </template>
                                </template>
                                <a @click="nextPage(paginate.current_page + 1)" v-if="paginate.current_page < paginate.last_page" class="next page-numbers"><i class="fa fa-angle-right"></i></a>
                            </div>
                            <!--Pagination -->
                        </main>

                        <div class="widget-area col-xs-12 col-sm-4 pull-right" id="secondary">
                            <PostsSearchForm v-model="query" @onSearchEnter="getItems('click')"/>
                            <aside class="widget recent_posts_widget">
                                <h3 class="widget-title">Recent Posts</h3>
                                <ul>
                                    <li v-for="(item, idx) in postsData.news.mostViews" :key="idx" class="clearfix">
                                        <img class="cursor" @click="Route({name: 'news-single', params: {id: item.id}})"  :src="`${baseUrl}${item.image}`" :alt="item.title"/>
                                        <div class="simi-co">
                                            <h5><a class="cursor" @click="Route({name: 'news-single', params: {id: item.id}})">{{item.title}}</a></h5>
                                            <p class="meta"><a>Updated At</a></p>
                                            <p class="meta"><a>{{item.post_updated}}</a></p>
                                        </div>
                                    </li>
                                    <!--<li class="clearfix"><img :src="`${baseRes}assets/images/use_img/widget-thumb.jpg`"-->
                                                              <!--alt=""/>-->
                                        <!--<div class="simi-co">-->
                                            <!--<h5><a>Create A Professional Music Video For Songwriters/Musicians</a></h5>-->
                                            <!--<p class="meta"><a>Music</a></p>-->
                                        <!--</div>-->
                                    <!--</li>-->
                                    <!--<li class="clearfix"><img :src="`${baseRes}assets/images/use_img/widget-thumb.jpg`"-->
                                                              <!--alt=""/>-->
                                        <!--<div class="simi-co">-->
                                            <!--<h5><a>Tricks and Tips for Adobe Photoshop CS6</a></h5>-->
                                            <!--<p class="meta"><a>Online Courses</a></p>-->
                                        <!--</div>-->
                                    <!--</li>-->
                                </ul>
                            </aside>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--Listing-->

    </div>
</template>

<script>

    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'news',
        }),
        created() {
            this.registerWatches();
            this.getItems();
            this.setPageTitle('News');
        }
    });
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
    .image-card, .post .post-thumb img {
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
