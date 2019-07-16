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
                                @click="tab=0"
                                :class="[{' is-active': tab===0}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">Our
                                Volunteering</a></li>
                            <li><a @click="tab=1"
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
            <div v-show="tab===0" class="container">
                <main class="activity">
                    <div class="cWidth-1200 search-result__body">
                        <div class="row">
                            <!--Aside left-->
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="aside-container">
                                    <!--Head-->
                                    <div class="search-result__aside-head">
                                        <div class="flag-obj flag-obj--full">
                                            <div class="flag-obj__item"><span
                                                class="body-txt font-mid-grey">Filter By</span>
                                            </div>
                                            <div class="flag-obj__item text-right"><a
                                                class="text-link body-txt--smaller bold js-clear-filters js-clear-filters-btn">CLEAR
                                                ALL</a></div>
                                        </div>
                                    </div>
                                    <!--Head-->
                                    <!--Filters-->
                                    <div class="res-ctn search-result__mobile-menu">
                                        <div class="res-ctn__bd lock-body">
                                            <div class="hide-desktop-up">
                                                <div class="flag-obj flag-obj--full">
                                                    <div class="flag-obj__item bold font-black">Filters</div>
                                                    <div class="flag-obj__item text-right"><a
                                                        class="res-ctn-hide-btn button-ctn button--ghost"> DONE </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="search-result__banner ">
                                                <a class="h6 text-link--white text-link--no-underline">CLEAR ALL</a>
                                            </div>
                                            <!--Filter Items-->
                                            <!--Radio Item-->
                                            <div class="filter-item is-expanded">
                                                <div class="title-head">
                                                    CATEGORIES
                                                    <i class="material-icons title-head-icon">keyboard_arrow_down</i>
                                                </div>
                                                <div class=" title-body title-body-collapsible">
                                                    <div class="radio-filters">
                                                        <label class="radio-filters__lbl">
                                                            <input type="radio" name="categories"
                                                                   class="radio-filters__radio callSearch categoriesType targetCategory"
                                                                   data-target="adHoc">
                                                            <span
                                                                class="radio-filters__text-left">Ad Hoc Volunteering</span>
                                                            <span class="radio-filters__text-right">124</span>
                                                        </label>
                                                    </div>
                                                    <div class="radio-filters">
                                                        <label class="radio-filters__lbl">
                                                            <input type="radio" name="categories"
                                                                   class="radio-filters__radio callSearch categoriesType targetCategory"
                                                                   data-target="adHoc">
                                                            <span
                                                                class="radio-filters__text-left">Regular Volunteering</span>
                                                            <span class="radio-filters__text-right">253</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Radio Item-->
                                            <!--Checkbox Item-->
                                            <div class="filter-item is-expanded">
                                                <div class="title-head">
                                                    CAUSES
                                                    <i class="material-icons title-head-icon">keyboard_arrow_down</i>
                                                </div>
                                                <div class=" title-body title-body-collapsible">
                                                    <ul class="checkbox-list" style="max-height: none;">
                                                        <li class="title-child">
                                                            <label class="checkbox-list__checkbox">
                                                                <input type="checkbox">
                                                                <span class="checkbox-list__lbl-spn">
                                                Animal Welfare
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li class="title-child">
                                                            <label class="checkbox-list__checkbox">
                                                                <input type="checkbox">
                                                                <span class="checkbox-list__lbl-spn">
                                               Arts & Heritage
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li class="title-child">
                                                            <label class="checkbox-list__checkbox">
                                                                <input type="checkbox">
                                                                <span class="checkbox-list__lbl-spn">
                                                Children & Youth
                                            </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!--Checkbox Item-->
                                            <!--Radio Item ver2-->
                                            <div class="filter-item is-expanded">
                                                <div class="title-head">
                                                    DATE
                                                    <i class="material-icons title-head-icon">keyboard_arrow_down</i>
                                                </div>
                                                <div class=" title-body title-body-collapsible">
                                                    <ul class="radio-btn--large list--bot-space-large"
                                                        style="max-height: none;">
                                                        <li>
                                                            <label class="radio-btn__lbl">
                                                                <input name="date-range" class="radio-btn__radio"
                                                                       type="radio">
                                                                <span class="radio-btn__value">
                                                All Dates
                                            </span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="radio-btn__lbl">
                                                                <input name="date-range" class="radio-btn__radio"
                                                                       type="radio">
                                                                <span class="radio-btn__value">
                                                Tomorrow
                                            </span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!--Radio Item ver2-->
                                            <!--Filter Items-->
                                        </div>
                                    </div>
                                    <!--Overlay @is-visible-->
                                    <div class=" ovrly"></div>
                                    <!--Overlay-->
                                    <!--Filters-->
                                </div>
                            </div>
                            <!--Aside left-->
                            <!--List Items-->
                            <div class="col-xs-12 col-sm-12 col-md-9">
                                <div class="search-result__main">
                                    <div class="search-result__main-head">
                                        <p class="font-black bold caps search-result__result">
                                            <strong>377 </strong>
                                            <span>RESULTS FOUND</span>
                                        </p>
                                        <div class="search-result__sort-filter">
                                            <a class="btn sort-filter">
                                                <i class="material-icons">filter_list</i>
                                                FILTERS
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" v-for="i in 3">
                                            <!--CardItem-->
                                            <div class="card card--flex">
                                                <div class="card__head">
                                                    <div class="gradient-over-image">
                                                        <div
                                                            :style="`background-image: url(https://www.giving.sg/image/logo?img_id=9040323);`"
                                                            class="gradient-over-image__image--bg gradient-over-image__image">

                                                        </div>
                                                    </div>
                                                    <div class="stats card__head-overlay font-white font-white"><span
                                                        class="stats__num">30</span> <span
                                                        class="stats__des">openings</span>
                                                    </div>
                                                </div>
                                                <!--Card Body-->
                                                <div class="card__body">
                                                    <h2 class="card__title break-word truncate">
                                                        FOH Volunteers for TheatreWorks' Production
                                                    </h2>
                                                    <div class="media-by">
                                                        <p
                                                            class="body-txt body-txt--smaller body-txt--no-letter-space font-mid-grey break-word">
                                                            by <span
                                                            class="bold break-word">TheatreWorks (Singapore) Limited</span>
                                                        </p>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">event</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            Thu, 02 May 2019
                                                            <!--<span-->
                                                            <!--class="other-date-label">+3 other dates</span>-->
                                                        </div>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">query_builder</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            6:00 PM to 10:00 PM
                                                        </div>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">place</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            River Valley
                                                        </div>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">group</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            Suitable for: Open to All
                                                        </div>
                                                    </div>
                                                    <div class="card__cta">
                                                        <button class="btn button--no-bg button--full">LEARN MORE
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--Card Body-->
                                                <!--Card Link-->
                                                <div>
                                                    <a class="card__link" href="/posts/volunteer-activity/1"
                                                       target="_blank"></a>
                                                </div>
                                                <!--Card Link-->
                                            </div>
                                            <!--CardItem-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--List Items-->
                    </div>
                </main>
            </div>
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

                                <div class="swiper-pagination swiper-pagination-bullets"><span
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
    import {mapActions} from 'vuex'

    export default Base.extend({
        name: "CompanyProfile",
        data: () => ({
            type: 'organize',
            tab: 1,
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
            user_causes_display: []
        }),
        components: {
            AccordionCard,
            ReportAbuse,
            Carousel
        },
        methods: {
            ...mapActions(['copyToClipboard']),
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
            setItem(data) {
                this.bookmarkOrganize = !(!(data.saved_bookmark));
                this.setPageTitle(data.name + ' - Company Profile');
                this.user_media = data.user_media;
                this.user_causes_display = data.user_causes_display;
                this.$nextTick(() => {
                    this.initCarousel();
                })
            },
            initCarousel() {
                let carousel = this.$refs['organize-profile'];
                if (carousel) {
                    carousel.initCarousel();
                }
            },
            checkingSaveBookmark() {
                if (!this.LoggedIn()) {
                    this.toaster('You do not have permission to favourite')
                }
            },
            shouldShowSingle() {
                return !this.$utils.isEmptyObject(this.singlePostsData[this.type].user_profile);
            },
            destroyCarousel() {
                let carousel = this.$refs['organize-profile'];
                if (carousel) {
                    carousel.removeCarousel();
                }
            },
        },
        beforeDestroy() {
            this.destroyCarousel();
        },
        created() {
            this.setPageTitle('Company Profile - ');
            this.link = this.baseUrl + this.$route.fullPath;
            this.registerWatches();
            this.singleId = this.$route.params.id;
            this.saveMyBookmark = this.debounce(this.saveMyBookmark, 250);
            let tab = this.$route.query.activities;
            if (tab) {
                this.tab = 0;
            } else {
                this.fetchSinglePostsData({type: this.type, id: this.singleId});
            }
        }
    });
</script>

<style scoped>

</style>
