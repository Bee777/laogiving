<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="company-profile__head">
                <div class="cWidth-1200 company-profile__head-title-logo">
                    <div class="company-profile__logo"><img
                        src="https://www.giving.sg/image/organization_logo?img_id=6090606&amp;1508937117000"></div>
                    <div class="company-profile__title-views-ctn"><h2 class="h2">National
                        Neuroscience Institute</h2>
                        <div
                            class="font-dark-grey mt-16 body-txt--small flex-ctn flex-ctn flex-ctn--dir-col-tablet-landscape-up-row">
                            <div class="mr-0-tablet-landscape-up-24">
                                <div class="social-list mt-8">
                                    <a class="button-ctn button--icon button--ghost "
                                       title="Facebook"> <i class="material-icons button--icon__icon">share</i>
                                        <span class="button--icon__name">SHARE</span>
                                    </a>
                                    <label class="btn-checkbox-btn btn-checkbox-btn--save ">
                                        <input type="checkbox" name="saving-bookmark">
                                        <span class="button-ctn button--icon button--ghost">
                                      <i class="material-icons ico-save button--icon__icon">bookmark_border</i>
                                      <span class="button--icon__name">SAVE</span>
                                    </span>
                                    </label>
                                    <a class="button-ctn button--icon button--ghost "
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
                                <div class="swiper-container--images swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img alt="" class="img-placeolder"
                                                 src="https://www.giving.sg/image/logo?img_id=6080036">
                                        </div>
                                        <div class="swiper-slide">
                                            <img alt="" class="img-placeolder"
                                                 src="https://www.giving.sg/image/logo?img_id=9040323">
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev rotage"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                                <div class="swiper-pagination swiper-pagination-bullets"><span
                                    class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
                            </div>
                        </div>
                        <div class="company-profile__donate">
                            <div class="accordion-card">
                                <div class="accordion-card__head">
                                    <h6 class="h6">VISION &amp;
                                        MISSION</h6>
                                    <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                    <div class="accordion-card__hitarea"></div>
                                </div>
                                <div class="accordion-card__body"><p>NNI is the national
                                    specialist centre and regional centre for clinical referrals for the management and
                                    treatment of the neurosciences.</p></div>
                            </div>
                        </div>
                        <div class="company-profile__options">
                            <div class="company-profile__description">

                                <div class="accordion-card accordion-card--borderless">
                                    <div class="accordion-card__head"><h3 class="h3">About
                                        Us</h3> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                        <div class="accordion-card__hitarea"></div>
                                    </div>
                                    <div class="accordion-card__body">
                                        <div class="body-txt break-word"> National Neuroscience Institute (NNI) is the
                                            national specialist centre and regional centre for clinical referrals for
                                            the management and treatment of the neurosciences, as well as for education
                                            and research conducted in the field. <br><br>Offering a comprehensive range
                                            of Neurology, Neurosurgery and Neuroradiology services using the latest
                                            technology and experience of our healthcare professionals, NNI is at the
                                            forefront of neuroscience care in Singapore and across the region. <br><br>NNI
                                            operates directly from two campuses; Tan Tock Seng Hospital and Singapore
                                            General Hospital (SGH), as well as provides specialty services to most other
                                            hospitals in Singapore. <br><br>We are a member of the SingHealth (Singapore
                                            Health Services) Group, an integrated healthcare delivery network which
                                            offers a complete range of multi-disciplinary and integrated medical care.
                                            The Group comprises hospitals, national specialty centres and a network of
                                            polyclinics.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-card accordion-card--borderless">
                                    <div class="accordion-card__head"><h3 class="h3">Our
                                        Programmes</h3> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                        <div class="accordion-card__hitarea"></div>
                                    </div>
                                    <div class="accordion-card__body">
                                        <div class="body-txt break-word"> Our
                                            programmes are centered around our 3 pillars - Education, Research and
                                            Clinical Services. We believe strongly in patients at the heart of all we
                                            do. Find out more at www.nni.com.sg today!
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="company-profile__causes-contact">
                            <div class="accordion-card">
                                <div class="accordion-card__head"><h6 class="h6">SUPPORTED
                                    CAUSES</h6> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                    <div class="accordion-card__hitarea"></div>
                                </div>
                                <div class="accordion-card__body">
                                    <ul class="list list--spacing">
                                        <li><i
                                            style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-community.svg');"
                                            class="ico ico--medium ico-community mr-8"></i>Community
                                        </li>
                                        <li><i
                                            style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-education.svg');"
                                            class="ico ico--medium ico-education mr-8"></i>Education
                                        </li>
                                        <li><i
                                            style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-elderly.svg');"
                                            class="ico ico--medium ico-elderly mr-8"></i>Elderly
                                        </li>
                                        <li><i
                                            style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-health.svg');"
                                            class="ico ico--medium ico-health mr-8"></i>Health
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="accordion-card mt-16">
                                <div class="accordion-card__head"><h6 class="h6">CONTACT
                                    US</h6> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                    <div class="accordion-card__hitarea"></div>
                                </div>
                                <div class="accordion-card__body">
                                    <div><h4 style="margin-bottom:10px">Volunteer Co-ordinator</h4>
                                        <p class="body-txt">National Neuroscience Institute</p></div>
                                    <div class="mb-16"><i class="ico material-icons gray mr-6">call</i>
                                        <a href="tel:63577095"
                                           class="text-link text-link--dark-grey">63577095</a>
                                    </div>
                                    <div class="mb-16">
                                        <i class="ico material-icons gray mr-6">email</i>
                                        <a
                                            class="text-link text-link--dark-grey" href="mailto:giving@nni.com.sg">giving@nni.com.sg</a>
                                    </div>
                                    <div class="mb-16">
                                        <i class="ico material-icons gray mr-6">public</i>
                                        <a
                                            href="http://www.giving.sg" class="text-link text-link--dark-grey"
                                            target="_blank">www.giving.sg</a></div>
                                </div>
                            </div>

                            <div class="text-center mb-16">
                                <a id="report-abuse-button" class="text-link"><i
                                    class="ico  material-icons ico-flag mr-8">outlined_flag</i>Report
                                    abuse</a>
                            </div>

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

    export default Base.extend({
        name: "CompanyProfile",
        data: () => ({
            type: 'CompanyProfile',
            tab: 1,
        }),
        methods: {
            initCarousel() {
                var mSwiper = new Swiper('.swiper-container', {
                    loop: true,
                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    spaceBetween: 10,
                })
            },
        },
        mounted() {
            this.initCarousel();
        },
        created() {
            this.setPageTitle('Company Profile - ');
            let tab = this.$route.query.activities;
            if (tab) {
                this.tab = 0;
            }
        }
    });
</script>

<style scoped>

</style>
