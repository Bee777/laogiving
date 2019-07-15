<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="company-profile__head">
                <div class="cWidth-1200 company-profile__head-title-logo object-fit">
                    <div class="company-profile__logo company-profile__logo--profile ">
                        <img :alt="authUserInfo.name" :src="`${baseUrl}${authUserInfo.image}`"></div>
                    <div class="company-profile__title-views-ctn"><h2 class="h2">{{authUserInfo.name}}</h2>
                        <div
                            class="font-dark-grey mt-16 body-txt--small flex flex-ctn--dir-col-tablet-landscape-up-row">
                            <div class="mr-0-tablet-landscape-up-24">
                                <span class="company-profile__views">{{userProfile.public_email||
                        authUserInfo.email}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Tabs-->
                <div class="cWidth-1200 company-profile__nav clearfix">
                    <nav class="hori-scroll-nav">
                        <ul class="hori-scroll-nav__list tabs list">
                            <li><a
                                @click="setRouteTab('dashboard')"
                                :class="[{' is-active': tab===0}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">Dashboard</a>
                            </li>
                            <li><a
                                @click="setRouteTab('activities')"
                                :class="[{' is-active': tab===1}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">My Volunteer
                                Activities</a>
                            </li>
                            <li><a @click="setRouteTab('saved')"
                                   :class="[{' is-active': tab===2}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Saved</a>
                            </li>
                            <li><a @click="setRouteTab('account')"
                                   :class="[{' is-active': tab===3}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Account</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!--Tabs-->
            </section>

            <!--Tabs Content-->
            <!--Dashboard-->

            <div class="cWidth-1200 mb-40 plr-16neg" v-show="tab===0">
                <div
                    class="flex flex-ctn--just-spc-btw flex-ctn--align-center flex-ctn--dir-col-custom-1024-up-row mt-40">
                    <span class="body-txt body-txt--small font-mid-grey body-txt--italic mb-16-custom-1024-up-0">Updated as of 7/5/2019</span>
                    <div class="month-range">
                        <span class="month-range__title">Showing data for</span>
                        <select v-model="volunteering.filter" class="select-ctn select--small"
                                :class="[{'is-hidden': volunteering.filter==='customMonth'}]">
                            <option selected="selected" value="this1Month">This month</option>
                            <option value="past1Month">Past 1 month</option>
                            <option value="past3Month">Past 3 months</option>
                            <option value="past6Month">Past 6 months</option>
                            <option value="customMonth">Custom</option>
                        </select>
                        <div class="month-range__body " :class="[{'is-hidden': volunteering.filter !== 'customMonth'}]">
                            <!-- is-hidden-->
                            <div class="month-range__item">
                                <select class="month-range__month select-ctn select--small select--font-small">
                                    <option value="0">Jan</option>
                                    <option value="1">Feb</option>
                                    <option value="2">Mar</option>
                                    <option value="3">Apr</option>
                                    <option value="4">May</option>
                                    <option value="5">Jun</option>
                                    <option value="6">July</option>
                                    <option value="7">Aug</option>
                                    <option value="8">Sept</option>
                                    <option value="9">Oct</option>
                                    <option value="10">Nov</option>
                                    <option value="11">Dec</option>
                                </select>
                                <select class="month-range__year select-ctn select--small select--font-small">
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                </select>
                            </div>
                            <div class="month-range__to">to</div>
                            <div class="month-range__item">
                                <select class="month-range__month select-ctn select--small select--font-small">
                                    <option value="0">Jan</option>
                                    <option value="1">Feb</option>
                                    <option value="2">Mar</option>
                                    <option value="3">Apr</option>
                                    <option value="4">May</option>
                                    <option value="5">Jun</option>
                                    <option value="6">July</option>
                                    <option value="7">Aug</option>
                                    <option value="8">Sept</option>
                                    <option value="9">Oct</option>
                                    <option value="10">Nov</option>
                                    <option value="11">Dec</option>
                                </select>
                                <select class="month-range__year select-ctn select--small select--font-small">
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                </select>
                            </div>
                            <div class="month-range__btns">
                                <button class="button-ctn mr-16">UPDATE</button>
                                <button @click="volunteering.filter='this1Month'"
                                        class="button-ctn button--ghost cancel">CANCEL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-ctn mb-40 mlr-16neg no-after no-before">
                    <div class="data-ctn__card" data-role="immersive-ctn__card">
                        <div class="data-ctn__title">Hours Volunteered</div>
                        <div class="data-ctn__details">
                            <div class="data-ctn__amount uf_volunteerHours">0</div>
                            <div class="dark-grey">hours across <strong>1</strong> opportunity</div>
                            <div class="mt-16 mb-16">Find out which causes you have given your time to.</div>
                            <i class="data-ctn__card-icon ico ico--large ico-volunteering-db"></i>
                            <div class="data-ctn__cta">
                                <button @click="$utils.Location('/posts/activities')" class="button-ctn button--ghost">
                                    VOLUNTEER NOW
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--EndDashboard-->
            <!--Volunteering-->
            <div class="ctn" v-show="tab===1">
                <MyVolunteering :visible="tab===1"/>
            </div>
            <!--EndVolunteering-->
            <!--Activities-->
            <div v-show="tab===2" class="container">
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
            <!--EndActivities-->
            <!--Account-->
            <div class="ctn" v-show="tab===3">
                <Account :visible="tab===3"/>
            </div>
            <!--EndAccount-->
            <!--Tabs Content-->

        </main>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/VolunteerBase.js";
    import {mapActions} from 'vuex'
    import Account from '@com/Volunteer/Pages/Account.vue'
    import MyVolunteering from '@com/Volunteer/Pages/MyVolunteering.vue'

    export default Base.extend({
        name: "Home",
        components: {
            Account,
            MyVolunteering
        },
        data: () => ({
            tab: 0,
            tabs: {dashboard: 0, activities: 1, saved: 2, account: 3},
            volunteering: {filter: 'this1Month'},
            toggleRadio: false,
            toggleDetail: false
        }),
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            }
        },
        methods: {
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                    this.$utils.setWindowTitle(`${this.$utils.firstUpper(tab)} | ${this.s.site_name}`);
                }
            },
            setRouteTab(n) {
                this.Route({name: 'home', query: {active_page: n}});
            },
        },
        mounted() {

        },
        created() {
            this.setPageTitle(`Dashboard`);
            this.setTab();
        }
    });
</script>


