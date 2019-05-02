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

                            <article class="post hentry">

                                <a  class="post-thumb">
                                    <figure><img alt="" :src="`${baseRes}assets/images/use_img/blog_img2.jpg`" /></figure>
                                </a>
                                <header class="entry-header">
                                    <h2 class="entry-title"><a >Tricks and Tips for Adobe Photoshop CS6</a></h2>
                                </header>

                                <div class="entry-content">
                                    <p>Nullam dictum accumsan hendrerit. Donec tempus ex non ante auctor, hendrerit viverra sem interdum.
                                        Vivamus sed eros a nisi pulvinar hendrerit. Cras dui nibh, sodales nec orci ut, fringilla molestie sapien.
                                        Mauris posuere, nisi eget ornare vestibulum, est est consectetur nisi, eget ullamcorper leo elit sit amet orci.
                                        Pellentesque in ex quis felis mattis ultricies. </p>
                                </div>

                                <footer class="entry-footer">
                                    <div class="entry-meta">
                                        <span class="posted-on"><a >March 17, 2016</a></span>
                                        <span class="byline">by <span class="author vcard"><a  class="url">ebastien Gabriel</a></span></span>
                                        <small>.</small>
                                        <span class="cat-links">Posted in " <a rel="category tag" >Online Courses</a> " <small>.</small> </span>
                                    </div>

                                </footer>

                                <a class="btn btn-medium read-more" >Read More <i class="lnr lnr-arrow-right"></i></a>
                            </article>

                            <article class="post hentry">
                                <blockquote class="post-quote">
                                    <i class="fa fa-quote-left"></i>
                                    <p>Praesent volutpatid nuncpretium ullamcorper Nunc infelis magnauis pharetra our is venenatis justo dapibus gravida class aptent.</p>
                                    <footer>Solvis Denial</footer>
                                </blockquote>
                            </article>
                            <article class="post hentry">

                                <a  class="post-thumb">
                                    <figure><img alt="" :src="`${baseRes}assets/images/use_img/blog_img2.jpg`" /></figure>
                                </a>
                                <header class="entry-header">
                                    <h2 class="entry-title"><a >The Design of HTML5</a></h2>
                                </header>

                                <div class="entry-content">
                                    <p>Nullam dictum accumsan hendrerit. Donec tempus ex non ante auctor, hendrerit viverra sem interdum.
                                        Vivamus sed eros a nisi pulvinar hendrerit. Cras dui nibh, sodales nec orci ut, fringilla molestie sapien.
                                        Mauris posuere, nisi eget ornare vestibulum, est est consectetur nisi, eget ullamcorper leo elit sit amet orci.
                                        Pellentesque in ex quis felis mattis ultricies. </p>
                                </div>

                                <footer class="entry-footer">
                                    <div class="entry-meta">
                                        <span class="posted-on"> <a >March 17, 2016</a></span>
                                        <span class="byline"> by <span class="author vcard"><a  class="url">Greg Christman</a></span> <small>.</small> </span>
                                        <span class="cat-links">Posted in " <a >Online Courses</a> " <small>.</small> </span>
                                        <span class="tags-links">Tags " <a rel="tag" >HTML5</a> " <small>.</small> </span>
                                        <span class="comments-link"><a >3 Comments</a></span>
                                    </div>

                                </footer>

                                <a class="btn btn-medium read-more">Read More <i class="lnr lnr-arrow-right"></i></a>
                            </article>
                            <!--Pagination -->
                            <div class="pagination">
                                <span class="page-numbers current">1</span>
                                <a  class="page-numbers">2</a>
                                <a  class="page-numbers">3</a>
                                <a class="next page-numbers"><i class="fa fa-angle-right"></i></a>
                            </div>
                            <!--Pagination -->
                        </main>

                        <div class="widget-area col-xs-12 col-sm-4 pull-right" id="secondary">
                            <aside class="widget widget_search">
                                <h3>Search bar</h3>
                                <form action="#" class="search-form" method="get">
                                    <input type="search" title="Search for:" name="s" value="" placeholder="Search …" class="search-field">
                                    <input type="submit" value="Search" class="search-submit btn btn-default">
                                </form>
                            </aside>
                            <aside class="widget recent_posts_widget">
                                <h3 class="widget-title">Recent Posts</h3>
                                <ul>
                                    <li class="clearfix"> <img :src="`${baseRes}assets/images/use_img/widget-thumb.jpg`" alt="" />
                                        <div class="simi-co">
                                            <h5><a >Can We Talk? A Real Conversation About Employee Performance</a></h5>
                                            <p class="meta"><a >News</a></p>
                                        </div>
                                    </li>
                                    <li class="clearfix"> <img :src="`${baseRes}assets/images/use_img/widget-thumb.jpg`" alt="" />
                                        <div class="simi-co">
                                            <h5><a >Create A Professional Music Video For Songwriters/Musicians</a></h5>
                                            <p class="meta"><a >Music</a></p>
                                        </div>
                                    </li>
                                    <li class="clearfix"> <img :src="`${baseRes}assets/images/use_img/widget-thumb.jpg`" alt="" />
                                        <div class="simi-co">
                                            <h5><a >Tricks and Tips for Adobe Photoshop CS6</a></h5>
                                            <p class="meta"><a >Online Courses</a></p>
                                        </div>
                                    </li>
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
            this.setPageTitle('News');
        }
    });
</script>

<style scoped>
.search-field {
    outline: none;
}
</style>
