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
                                        <h1 v-else class="title single-blog-title">Tricks and Tips for Adobe Photoshop CS6</h1>
                                    </div>
                                    <div class="authorScale author-fontSize17 author-marginVertical24 author-flexCenter">
                                        <div class="author-flex0">
                                            <div class="author-avatar">
                                                <img v-if="shouldLoadingSingle(type)"
                                                     :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                                                     class="avatar-image image-size50x50">
                                                <img v-else-if="true"
                                                     :src="`https://jaol.org/assets/images/73053e4109225ff2df2ff96323dc8bf11552127362_site_info_.png?v92460dabdca9078129306df10a81f8d0`"
                                                     class="avatar-image image-size50x50">
                                            </div>
                                        </div>
                                        <div class="author-flex1 author-paddingLeft15 author-overflowHidden">
                                            <div class="author-paddingBottom3">
                                                <div class="author-caption">Panya CHANTHAVONG</div>
                                            </div>
                                            <div class="author-caption author-time-wrap">
                                                <time :datetime="`22:29 PM, 20 Mar 2019 `">22:29 PM, 20 Mar 2019
                                                </time>
                                                <span class="middot-divider author-fontSize12"></span>
                                                <span class="agoTime"
                                                      :title="`1 month ago`"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="spaced-flex"></div>
                                </div>

                                <div class="image single-post-image-container">
                                    <div v-if="shouldLoadingSingle(type)" class="loading-image"></div>
                                    <img v-if="true" class="single-post-image"
                                         :src="`https://jaol.org/assets/images/posts/MEXT 2019 Party.jpg7e6a2afe551e067a75fafacf47a6d981de8420d5627350b71d8d42692ba625da1553095506_posts.jpg`"
                                         :alt="`alt`">
                                </div>
                                <div class="blog-content">
                                    <div class="content" v-html="singlePostsData.news.data.description"></div>
                                </div>
                                <div class="author-postActions author-paddingTop20" v-if="singlePostsData.news.data.id">
                                    <div class="author-flexCenter">
                                        <div class="button-actions author-flex1">
                                            <a class="button button-dark author-fontBold">Sharing</a>
                                            <span class="middot-divider author-fontSize12 author-marginRight12"></span>
                                            <a target="_blank" :href="sharer('twitter', type, singlePostsData.news.data, link)"
                                               class="button button-dark author-marginRight12">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a target="_blank" :href="sharer('fb', type, singlePostsData.news.data, link)"
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
                                    <div class="nav-previous"> <i class="fa fa-arrow-circle-left"></i> <a>Audio tutorial for WordPress</a></div>
                                    <div class="nav-next"><a>The Design of HTML5</a> <i class="fa fa-arrow-circle-right"></i></div>
                                </div>
                            </nav>
                            <!--Navigation-->
                            <section class="related-posts clearfix">
                                <h3>Related Posts</h3>
                                <div class="col-xs-12 col-sm-4">
                                    <article class="blog-article"> <a> <img :src="`${baseRes}assets/images/use_img/relatedpost.jpg`" alt="" /></a>
                                        <h4><a>Audio tutorial for WordPress</a></h4>
                                        <p class="meta">In "<a>Music</a>, <a>Online Courses</a>"</p>
                                    </article>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <article class="blog-article"> <a > <img :src="`${baseRes}assets/images/use_img/relatedpost.jpg`" alt="" /></a>
                                        <h4><a >Audio Editing Basics with Reaper</a></h4>
                                        <p class="meta">In "<a>Online Courses</a>"</p>
                                    </article>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <article class="blog-article"> <a > <img :src="`${baseRes}assets/images/use_img/relatedpost.jpg`" alt="" /></a>
                                        <h4><a >Audio Editing Basics with Reaper</a></h4>
                                        <p class="meta">In "<a>Online Courses</a>"</p>
                                    </article>
                                </div>
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

            this.setPageTitle('News');
            this.singleId = this.$route.params.id;

            this.singlePostsData.news.data.description = ` <p>Vestibulum maximus finibus scelerisque. Nam finibus odio eget nisi pharetra imperdiet. Curabitur urna neque, bibendum quis nibh vel, tincidunt facilisis augue. In posuere, libero id faucibus sagittis, nunc augue convallis sem, ac scelerisque velit dolor at massa. Etiam nec nibh elit.</p>
                                    <p>Nullam dictum accumsan hendrerit. Donec tempus ex non ante auctor, hendrerit viverra sem interdum. Vivamus sed eros a nisi pulvinar hendrerit. Cras dui nibh, sodales nec orci ut, fringilla molestie sapien. Mauris posuere, nisi eget ornare vestibulum, est est consectetur nisi, eget ullamcorper leo elit sit amet orci. Pellentesque in ex quis felis mattis ultricies. Etiam vitae lectus fringilla, ornare sem non, interdum diam</p>`;
            this.singlePostsData.news.data.id = 1;
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
    .blog-article{
        text-align: center;
    }
    .hentry {
        margin: 0 0 1em;
    }
</style>
