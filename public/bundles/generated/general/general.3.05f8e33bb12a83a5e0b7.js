webpackJsonp([3],{"/aGA":function(t,a,s){var e=s("yZ/t");"string"==typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var i=s("rjj0").default;i("6f7fe458",e,!0,{})},"3lFp":function(t,a,s){"use strict";function e(t){s("/aGA")}Object.defineProperty(a,"__esModule",{value:!0});var i=s("lnVK"),n=s("8SMh"),r=s("XyMi"),c=e,l=Object(r.a)(i.a,n.a,n.b,!1,c,"data-v-4e3642c3",null);a.default=l.exports},"8SMh":function(t,a,s){"use strict";s.d(a,"a",function(){return e}),s.d(a,"b",function(){return i});var e=function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",[t._m(0),t._v(" "),s("div",{staticClass:"page-spacer clearfix"},[s("div",{staticClass:"content-area",attrs:{id:"primary"}},[s("div",{staticClass:"container"},[s("div",{staticClass:"row"},[s("main",{staticClass:"site-main col-xs-12 col-sm-8 left-block",attrs:{id:"main"}},[t._l(t.postsData.news.posts.data,function(a,e){return s("article",{key:e,staticClass:"post hentry"},[s("a",{staticClass:"post-thumb cursor",on:{click:function(s){return t.Route({name:"news-single",params:{id:a.id}})}}},[s("figure",{staticClass:"image-relative"},[s("div",{staticClass:"image-card-container"},[s("img",{staticClass:"image-card",attrs:{alt:a.title,src:""+t.baseUrl+a.image}})])])]),t._v(" "),s("header",{staticClass:"entry-header"},[s("h2",{staticClass:"entry-title"},[s("a",{staticClass:"cursor",on:{click:function(s){return t.Route({name:"news-single",params:{id:a.id}})}}},[t._v(t._s(a.title))])])]),t._v(" "),s("div",{staticClass:"entry-content",domProps:{innerHTML:t._s(t.$utils.sub(t.$utils.strip(a.description),280))}}),t._v(" "),s("footer",{staticClass:"entry-footer"},[s("div",{staticClass:"entry-meta"},[s("span",{staticClass:"posted-on"},[s("a",[t._v(t._s(a.post_updated))])]),t._v(" "),s("span",{staticClass:"byline"},[t._v("by "),s("span",{staticClass:"author vcard"},[s("a",{staticClass:"url"},[t._v(t._s(a.author))])])]),t._v(" "),s("small",[t._v(".")])])]),t._v(" "),s("a",{staticClass:"btn btn-medium read-more",on:{click:function(s){return t.Route({name:"news-single",params:{id:a.id}})}}},[t._v("Read More "),s("i",{staticClass:"lnr lnr-arrow-right"})])])}),t._v(" "),t.isNotFound()?s("div",{staticClass:"col-lg-8"},[s("div",{staticClass:"devsite-article mt-20"},[s("h1",{staticClass:"devsite-page-title"},[t._v("\n                                    Search results for "),s("span",{staticClass:"devsite-search-term"},[s("span",{staticClass:"devsite-search-term"},[t._v(t._s(t.query))])])])]),t._v(" "),s("div",{staticClass:"result-snippet"},[t._v("No Results")])]):t._e(),t._v(" "),t.postsData.news.posts.data?s("div",{staticClass:"pagination"},[t.paginate.current_page>1?s("a",{staticClass:"next page-numbers",on:{click:function(a){return t.prevPage(t.paginate.current_page-1)}}},[s("i",{staticClass:"fa fa-angle-left"})]):t._e(),t._v(" "),t._l(t.paginate.last_page,function(a){return[a===t.paginate.current_page?[s("span",{staticClass:"page-numbers current"},[t._v(t._s(a))])]:[s("a",{staticClass:"page-numbers",on:{click:function(s){return t.paginateNavigator({pageNo:a})}}},[t._v(t._s(a))])]]}),t._v(" "),t.paginate.current_page<t.paginate.last_page?s("a",{staticClass:"next page-numbers",on:{click:function(a){return t.nextPage(t.paginate.current_page+1)}}},[s("i",{staticClass:"fa fa-angle-right"})]):t._e()],2):t._e()],2),t._v(" "),s("div",{staticClass:"widget-area col-xs-12 col-sm-4 pull-right",attrs:{id:"secondary"}},[s("PostsSearchForm",{on:{onSearchEnter:function(a){return t.getItems("click")}},model:{value:t.query,callback:function(a){t.query=a},expression:"query"}}),t._v(" "),s("aside",{staticClass:"widget recent_posts_widget"},[s("h3",{staticClass:"widget-title"},[t._v("Recent Posts")]),t._v(" "),s("ul",t._l(t.postsData.news.mostViews,function(a,e){return s("li",{key:e,staticClass:"clearfix"},[s("img",{staticClass:"cursor",attrs:{src:""+t.baseUrl+a.image,alt:a.title},on:{click:function(s){return t.Route({name:"news-single",params:{id:a.id}})}}}),t._v(" "),s("div",{staticClass:"simi-co"},[s("h5",[s("a",{staticClass:"cursor",on:{click:function(s){return t.Route({name:"news-single",params:{id:a.id}})}}},[t._v(t._s(a.title))])]),t._v(" "),t._m(1,!0),t._v(" "),s("p",{staticClass:"meta"},[s("a",[t._v(t._s(a.post_updated))])])])])}),0)])],1)])])])])])},i=[function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{staticClass:"breadcrumb-section"},[s("div",{staticClass:"container"},[s("div",{staticClass:"row"},[s("header",{staticClass:"entry-header"},[s("h1",{staticClass:"entry-title"},[t._v("Our News")])])])])])},function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("p",{staticClass:"meta"},[s("a",[t._v("Updated At")])])}]},lnVK:function(t,a,s){"use strict";var e=s("nA46");a.a=e.a.extend({data:function(){return{type:"news"}},created:function(){this.registerWatches(),this.getItems(),this.setPageTitle("News")}})},"yZ/t":function(t,a,s){a=t.exports=s("FZ+f")(),a.push([t.i,".image-relative[data-v-4e3642c3]{position:relative;max-width:100%}.image-card-container[data-v-4e3642c3]{width:100%;height:100%;padding-top:70%}.image-card[data-v-4e3642c3],.post .post-thumb img[data-v-4e3642c3]{bottom:0;left:0;position:absolute;right:0;top:0;height:100%;width:100%;display:block}",""])}});