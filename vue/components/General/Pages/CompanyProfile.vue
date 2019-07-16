<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="company-profile__head">
                <div class="cWidth-1200 company-profile__head-title-logo">
                    <div class="company-profile__logo">
                        <img v-if="shouldShowSingle()"
                             :src="`${baseUrl}${singlePostsData.organize.user_profile.organize_image}`"></div>
                    <div class="company-profile__title-views-ctn"><h2 class="h2">
                        {{singlePostsData.organize.user_profile.display_name}}</h2>
                        <div
                            class="font-dark-grey mt-16 body-txt--small flex-ctn flex-ctn flex-ctn--dir-col-tablet-landscape-up-row">
                            <div class="mr-0-tablet-landscape-up-24">
                                <div class="social-list mt-8">
                                    <a class="button-ctn button--icon button--ghost "
                                       :href="sharer('fb', type, singlePostsData.organize.user_profile, link)"
                                       title="Facebook"> <i class="material-icons button--icon__icon">share</i>
                                        <span class="button--icon__name">SHARE</span>
                                    </a>
                                    <label class="btn-checkbox-btn btn-checkbox-btn--save ">
                                        <input v-if="LoggedIn()" v-model="bookmarkOrganize" type="checkbox"
                                               name="saving-bookmark"
                                               @change="saveMyBookmark(singlePostsData.organize.user_profile)">
                                        <input v-else disabled type="checkbox">
                                        <span @click="checkingSaveBookmark()"
                                              class="button-ctn button--icon button--ghost">
                                      <i class="material-icons ico-save button--icon__icon">bookmark_border</i>
                                      <span class="button--icon__name">SAVE</span>
                                    </span>
                                    </label>
                                    <a
                                        @click="copyToClipboard({text: link})"
                                        class="button-ctn button--icon button--ghost "
                                        title="Link copy to clipboard"> <i
                                        class="material-icons button--icon__icon">link</i>
                                        <span class="button--icon__name">LINK</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Tabs-->
                <div class="cWidth-1200 company-profile__nav clearfix">
                    <nav class="hori-scroll-nav">
                        <ul class="hori-scroll-nav__list tabs list">
                            <li><a
                                @click="setRouteTab('our-volunteering')"
                                :class="[{' is-active': tab===0}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">Our
                                Volunteering</a></li>
                            <li><a @click="setRouteTab('organization-profile')"
                                   :class="[{' is-active': tab===1}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Profile</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!--Tabs-->
            </section>

            <!--Tabs Content-->
            <!--Activities-->
            <VolunteeringFilter v-show="tab===0" ref="volunteeringFilter" @onPaginateNavigator="paginateNavigator"
                                :options="homeData"
                                :displayType="displayType"
                                @onClearFilters="clearFilters()"
                                :disableFilters="disableFilters"
                                :isSearch="isSearch" :query="query"
                                :filters="filters" :paginate="paginate"/>
            <!--Activities-->

            <!--Profile-->
            <div class="ctn" v-show="tab===1">
                <div class="cWidth-1200">
                    <section class="company-profile__body ctn clearfix">
                        <div class="company-profile__main objectfit ">
                            <div class="swiper-arrow-wrap swiper-container-horizontal">
                                <Carousel :hasVideos="true" ref="organize-profile">
                                    <template slot="slide-item">
                                        <div class="swiper-slide" v-if="user_media.video.url !==''">
                                            <div class="video-container none-active"
                                                 :data-embed="covertYoutubeUrlToEmBed(user_media.video.url)">
                                            </div>
                                        </div>
                                        <div class="swiper-slide" v-for="(item, idx) in user_media.images"
                                             v-if="item.image_base64!==''" :key="idx">
                                            <img :alt="item.url" class="img-placeolder"
                                                 :src="item.image_base64">
                                        </div>
                                    </template>
                                </Carousel>

                                <div class="company-pagination swiper-pagination swiper-pagination-bullets"><span
                                    class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
                            </div>
                        </div>
                        <div class="company-profile__donate">
                            <AccordionCard>
                                <template slot="header-title">
                                    <h6 class="h6">VISION &amp;
                                        MISSION</h6>
                                </template>
                                <template slot="body-content">
                                    <p class="break-word pre-wrap"
                                       v-text="singlePostsData.organize.user_profile.vision_mission"></p>
                                </template>
                            </AccordionCard>
                        </div>
                        <div class="company-profile__options">
                            <div class="company-profile__description">

                                <AccordionCard containerClasses="accordion-card--borderless">
                                    <template slot="header-title">
                                        <h3 class="h3">About Us</h3>
                                    </template>
                                    <template slot="body-content">
                                        <div class="body-txt break-word pre-wrap"
                                             v-html="singlePostsData.organize.user_profile.about"></div>
                                    </template>
                                </AccordionCard>

                                <AccordionCard containerClasses="accordion-card--borderless">
                                    <template slot="header-title">
                                        <h3 class="h3">Our Programmes</h3>
                                    </template>
                                    <template slot="body-content">
                                        <div class="body-txt break-word pre-wrap"
                                             v-html="singlePostsData.organize.user_profile.our_programmes"></div>
                                    </template>
                                </AccordionCard>

                            </div>
                        </div>

                        <div class="company-profile__causes-contact">

                            <AccordionCard>
                                <template slot="header-title">
                                    <h6 class="h6">SUPPORTED
                                        CAUSES</h6>
                                </template>
                                <template slot="body-content">
                                    <ul class="list list--spacing">
                                        <li v-for="(item, idx) in user_causes_display" :key="idx"><i
                                            :style="`background-image: url('${baseUrl}/assets/images/icon/causes/${item.small_icon}');`"
                                            class="ico ico--medium ico-community mr-8"></i>{{item.name}}
                                        </li>
                                    </ul>
                                </template>
                            </AccordionCard>

                            <AccordionCard containerClasses="mt-16">
                                <template slot="header-title">
                                    <h6 class="h6">CONTACT
                                        US</h6>
                                </template>
                                <template slot="body-content">
                                    <div><h4 style="margin-bottom:10px">
                                        {{singlePostsData.organize.user_profile.contact_person}}</h4>
                                        <p class="body-txt">{{singlePostsData.organize.user_profile.display_name}}</p>
                                    </div>
                                    <div class="mb-16"><i class="ico material-icons gray mr-6">call</i>
                                        <a :href="`tel:${singlePostsData.organize.user_profile.phone_number}`"
                                           class="text-link text-link--dark-grey">{{singlePostsData.organize.user_profile.phone_number}}</a>
                                    </div>
                                    <div class="mb-16">
                                        <i class="ico material-icons gray mr-6">email</i>
                                        <a
                                            class="text-link text-link--dark-grey"
                                            :href="`mailto:${singlePostsData.organize.user_profile.public_email}`">{{singlePostsData.organize.user_profile.public_email}}</a>
                                    </div>
                                    <div class="mb-16">
                                        <i class="ico material-icons gray mr-6">public</i>
                                        <a
                                            :href="$utils.httpOrHttps(singlePostsData.organize.user_profile.website, true)"
                                            class="text-link text-link--dark-grey"
                                            target="_blank">{{singlePostsData.organize.user_profile.website}}</a></div>
                                    <div>
                                        <i class="ico ico-facebook-gray mr-8"></i>
                                        <a target="_blank"
                                           class="text-link text-link--dark-grey"
                                           :href="`https://www.facebook.com/${singlePostsData.organize.user_profile.facebook}`">{{singlePostsData.organize.user_profile.facebook}}</a>
                                    </div>
                                </template>
                            </AccordionCard>

                            <ReportAbuse :data="{user_id: $store.state.authUserInfo.id || 0, type: 'profile'}"
                                         :email="$store.state.authUserInfo.email || ''"/>

                        </div>

                    </section>
                </div>
            </div>
            <!--Profile-->
            <!--Tabs Content-->

        </main>
    </div>
</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'
    import AccordionCard from '@com/Utils/AccordionCard.vue'
    import Carousel from '@com/Utils/Carousel.vue'
    import ReportAbuse from '@com/Utils/ReportAbuse.vue'
    import VolunteeringFilter from '@com/Utils/VolunteeringFilter.vue'

    import {mapActions, mapState} from 'vuex'

    export default Base.extend({
        name: "CompanyProfile",
        components: {
            AccordionCard,
            ReportAbuse,
            Carousel,
            VolunteeringFilter
        },
        data: () => ({
            shouldScroll: true,
            shouldCarousel: false,
            type: 'activities',
            tab: 0,
            tabs: {'our-volunteering': 0, 'organization-profile': 1},
            link: '',
            bookmarkOrganize: false,
            user_media: {
                video: {validated: '', url: ''},
                images: [
                    {
                        image_base64: '',
                        image: null,
                        validated: '',
                        removable: false,
                    }
                ],
            },
            user_causes_display: [],
            filters: {
                organize_id: 0,
                causes: [],
                openings: [],
                skills: [],
                suitables: [],
                date: 'all_date',
            },
            displayType: 'volunteer',
            disableFilters: {
                post_type: true,
                causes: false,
                openings: false,
                skills: false,
                suitables: false,
                weekday_or_weekend: true,
                commitment_duration: true,
                frequency: true,
                date: false,
            }
        }),
        watch: {
            tab: function (n) {
                //reset by tab
                this.isSearch = false;
                if (n === 0) {
                    this.setFilteringGetData();
                }
            },
            '$route.query': function (n) {
                this.setTab();
                if (this.tab === 0) {
                    this.setFilteringGetData();
                } else {
                    this.fetchSinglePostsData({type: 'organize', id: this.singleId});
                }
            },
            filters: {
                deep: true,
                handler(n, o) {
                    if (this.tab === 0) {
                        this.setQueryString();
                    }
                }
            },
            'singlePostsData.organize': function (n) {
                this.setOrganizeProfileItem(n);
            }
        },
        computed: {
            ...mapState(['homeData', 'postsData']),
        },
        methods: {
            ...mapActions(['copyToClipboard']),
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                    this.$utils.setWindowTitle(`${this.$utils.firstUpper(tab)} | ${this.s.site_name}`);
                }
            },
            setRouteTab(n) {
                this.Route({name: 'organize-profile', params: {id: this.singleId}, query: {active_page: n}});
            },
            covertYoutubeUrlToEmBed(url) {
                let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                let match = url.match(regExp);

                if (match && match[2].length === 11) {
                    return `${match[2]}`;
                } else {
                    return '';
                }
            },
            saveMyBookmark(data) {
                if (this.LoggedIn()) {
                    this.postSaveBookMark({
                        post_id: data.user_id,
                        type: 'organize',
                        checked: this.bookmarkOrganize
                    }).then((res) => {
                        if (!res.success) {
                            this.bookmarkOrganize = false;
                        }
                    }).catch(() => {
                        this.bookmarkOrganize = false;
                    });
                } else {
                    this.toaster('You do not have permission to favourite')
                }
            },
            setOrganizeProfileItem(data) {
                this.bookmarkOrganize = !(!(data.saved_bookmark));
                this.user_media = data.user_media;
                this.user_causes_display = data.user_causes_display;
                if (this.tab === 1 && !this.shouldCarousel) {
                    this.shouldCarousel = true;
                    this.$nextTick(() => {
                        this.initCarousel();
                    });
                }
                if (this.shouldScroll) {
                    this.shouldScroll = false;
                    this.setPageTitle(data.name + ' - Company Profile');
                } else {
                    document.title = `${data.name}  - Company Profile | ${this.s.site_name}`;
                }
            },
            initCarousel() {
                let carousel = this.$refs['organize-profile'];
                if (carousel) {
                    carousel.initCarousel();
                }
            },
            destroyCarousel() {
                let carousel = this.$refs['organize-profile'];
                if (carousel) {
                    carousel.removeCarousel();
                }
            },
            checkingSaveBookmark() {
                if (!this.LoggedIn()) {
                    this.toaster('You do not have permission to favourite')
                }
            },
            shouldShowSingle() {
                return !this.$utils.isEmptyObject(this.singlePostsData['organize'].user_profile);
            },
            setQueryString() {
                //please clone the queries for editable queries working
                let q = JSON.parse(JSON.stringify(this.$route.query));
                //query
                q.q = this.query;
                //causes
                q.causes = this.filters.causes.join(',');
                //skills
                q.skills = this.filters.skills.join(',');
                //suitables
                q.suitables = this.filters.suitables.join(',');
                //openings
                q.openings = this.filters.openings.join(',');
                //date
                q.date = this.filters.date;
                //organize id
                q.organize_id = this.singleId;
                //set query
                this.$router.replace({path: this.$route.path, query: q});
            },
            setFilteringGetData() {
                let q = this.$route.query;
                //tab
                this.query = q.q || '';
                //type
                //cause
                this.filters.causes = q.causes ? q.causes.split(',') : [];
                //skills
                this.filters.skills = q.skills ? q.skills.split(',') : [];
                //suitables
                this.filters.suitables = q.suitables ? q.suitables.split(',') : [];
                //openings
                this.filters.openings = q.openings ? q.openings.split(',') : [];
                //date
                this.filters.date = q.date || 'all_date';
                //organize id
                this.filters.organize_id = this.singleId;
                //set filters
                this.options_request = this.filters;
                this.paginate.per_page = 12;
                //get data
                this.getItems('no-scroll');
            },
            clearFilters() {
                this.filters = {
                    organize_id: 0,
                    causes: [],
                    openings: [],
                    skills: [],
                    suitables: [],
                    date: 'all_date',
                    is_filtering: false
                }
            },
        },
        beforeDestroy() {
            this.destroyCarousel();
        },
        created() {
            this.registerWatches();
            this.setPageTitle('Company Profile - ');
            this.link = this.baseUrl + this.$route.fullPath;
            this.singleId = this.$route.params.id;
            this.saveMyBookmark = this.debounce(this.saveMyBookmark, 250);
            this.getItems = this.debounce(this.getItems, 150);
            this.setTab();
            this.fetchSinglePostsData({type: 'organize', id: this.singleId});
            this.setFilteringGetData();
        }
    });
</script>

<style>
    .company-pagination span {
        margin: 0 4px !important;
    }
</style>
