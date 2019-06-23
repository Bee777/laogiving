<template>
    <div>
        <div class="page-spacer clearfix">
            <div id="primary" class="content-area">
                <div class="container">
                    <div class="row">
                        <main id="main" class="site-main col-xs-12 col-sm-12">
                            <article class="post hentry">

                                <div class="blog-header">
                                    <div class="blog-header-title">
                                        <h1 v-if="shouldLoadingSingle(type)">
                                            <div class="loading-text"></div>
                                        </h1>
                                        <h1 v-else class="title single-blog-title">{{ singlePostsData.news.data.title
                                            }}</h1>
                                    </div>
                                    <div
                                        class="authorScale author-fontSize17 author-marginVertical24 author-flexCenter">
                                        <div class="author-flex0">
                                            <div class="author-avatar">
                                                <img v-if="shouldLoadingSingle(type)"
                                                     :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                                                     class="avatar-image image-size50x50">
                                                <img v-else-if="singlePostsData.news.data.author_image"
                                                     :src="`${baseUrl}${singlePostsData.news.data.author_image}`"
                                                     :alt="singlePostsData.news.data.author"
                                                     class="avatar-image image-size50x50">
                                            </div>
                                        </div>
                                        <div class="author-flex1 author-paddingLeft15 author-overflowHidden">
                                            <div class="author-paddingBottom3">
                                                <div class="author-caption">{{ singlePostsData.news.data.author }}</div>
                                            </div>
                                            <div class="author-caption author-time-wrap">
                                                <time :datetime="singlePostsData.news.data.updated_at">
                                                    {{singlePostsData.news.data.post_updated}}
                                                </time>
                                                <span class="middot-divider author-fontSize12"></span>
                                                <span class="agoTime"
                                                      :title="singlePostsData.news.data.post_updated_ago"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="spaced-flex"></div>
                                </div>

                                <div class="image single-post-image-container">
                                    <div v-if="shouldLoadingSingle(type)" class="loading-image"></div>
                                    <img v-if="singlePostsData.news.data.image" class="single-post-image"
                                         :src="singlePostsData.news.data.image"
                                         :alt="singlePostsData.news.data.title">
                                </div>
                                <div class="blog-content">
                                    <div class="content" v-html="singlePostsData.news.data.description"></div>
                                </div>
                                <div class="author-postActions author-paddingTop20" v-if="singlePostsData.news.data">
                                    <div class="author-flexCenter">
                                        <div class="button-actions author-flex1">
                                            <a class="button button-dark author-fontBold">Sharing</a>
                                            <span class="middot-divider author-fontSize12 author-marginRight12"></span>
                                            <a target="_blank"
                                               :href="sharer('twitter', type, singlePostsData.news.data, link)"
                                               class="button button-dark author-marginRight12">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a target="_blank"
                                               :href="sharer('fb', type, singlePostsData.news.data, link)"
                                               class="button button-dark author-marginRight12">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="author-borderTopLightest author-marginTop20 author-paddingBottom20"></div>
                            </article>
                            <!--Navigation-->
                            <nav class="navigation post-navigation">
                                <div class="nav-links">
                                    <div v-if="singlePostsData.news.data.previous" class="nav-previous"><i
                                        class="fa fa-arrow-circle-left"></i> <a
                                        class="cursor"
                                        @click="Route({name: 'news-single', params: {id: singlePostsData.news.data.previous.id}})">{{
                                        $utils.sub(
                                        singlePostsData.news.data.previous.title, 40 )}}</a></div>
                                    <div v-if="singlePostsData.news.data.next" class="nav-next"><a
                                        class="cursor"
                                        @click="Route({name: 'news-single', params: {id: singlePostsData.news.data.next.id}})">{{
                                        $utils.sub(
                                        singlePostsData.news.data.next.title, 40 )}}</a> <i
                                        class="fa fa-arrow-circle-right"></i></div>
                                </div>
                            </nav>
                            <!--Navigation-->
                            <section class="related-posts clearfix">
                                <h3>Related Posts</h3>
                                <div class="col-xs-12 col-sm-4" v-for="(item, idx) in singlePostsData.news.others"
                                     :key="idx">
                                    <article class="blog-article">
                                        <a class="cursor"
                                           @click="Route({name: 'news-single', params: {id: item.id}})">
                                            <figure class="image-relative-abs ">
                                                <div class="image-card-container-abs" style="padding-top: 54%;">
                                                    <img class="image-card-abs"
                                                         :src="`${baseUrl}${item.image}`"
                                                         :alt="item.title"/>
                                                </div>
                                            </figure>
                                        </a>
                                        <h4><a @click="Route({name: 'news-single', params: {id: item.id}})"
                                               class="cursor">{{item.title}}</a></h4>
                                        <p class="meta">"<a>News</a>, <a>Updated At {{item.post_updated}}</a>"</p>
                                    </article>
                                </div>
                                <!--<div class="col-xs-12 col-sm-4">-->
                                <!--<article class="blog-article"><a> <img-->
                                <!--:src="`${baseRes}assets/images/use_img/relatedpost.jpg`" alt=""/></a>-->
                                <!--<h4><a>Audio Editing Basics with Reaper</a></h4>-->
                                <!--<p class="meta">In "<a>Online Courses</a>"</p>-->
                                <!--</article>-->
                                <!--</div>-->
                            </section>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'news',
            link: '',
        }),
        watch: {
            '$route.params': function (n, o) {
                this.$utils.scrollToY('html,body', 10);
                this.singleId = n.id;
                this.link = this.baseUrl + this.$route.fullPath;
                this.fetchSinglePostsData({type: this.type, id: this.singleId});
            }
        },
        methods: {
            setItem(data) {
                this.setPageTitle(data.data.title)
            }
        },
        created() {
            this.link = this.baseUrl + this.$route.fullPath;
            this.registerWatches();
            this.setPageTitle("News");
            this.singleId = this.$route.params.id;
            this.fetchSinglePostsData({type: this.type, id: this.singleId});
        }
    });
</script>
<style scoped>
    .page-spacer {
        padding: 20px 0 0;
    }

    .related-posts {
        padding-bottom: 20px;
    }

    .blog-article {
        text-align: center;
    }

    .hentry {
        margin: 0 0 1em;
    }
</style>
