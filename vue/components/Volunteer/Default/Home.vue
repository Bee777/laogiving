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
                <div class="cWidth-1200 pt-40 clearfix">
                    <div
                        class="flex-ctn flex-ctn--just-spc-btw flex-ctn--tablet-portrait-up-align-center flex-ctn--dir-col-tablet-portrait-up-row">
                        <div class="dbl-stats">
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8">2/2</div>
                                <div class="dbl-stats__desc"> attended</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8">1</div>
                                <div class="dbl-stats__desc"> as leader</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8">33.5</div>
                                <div class="dbl-stats__desc"> total hours</div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">

                    <div class="volunteer-admin__container" id="my-volunteer-activities">
                        <div
                            class="volunteer-admin__container-nav grid-12 grid-custom-1024-up-3 pt-16-custom-1024-up-86">
                            <div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">
                                <div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span
                                    class="nav-acdr__title">Live</span> <span
                                    class="nav-acdr__stats live-count">3</span></div>
                                <div class="nav-acdr__body">
                                    <div class="nav-acdr__grp nav-acdr__grp--single">
                                        <div class="radio-filters radio-filters--blk"><label class="radio-filters__lbl">
                                            <input type="radio" checked=""
                                                   name="filter_status"
                                                   class="radio-filters__radio" value="LIVE">
                                            <span class="radio-filters__text-left">Live</span>
                                            <span class="radio-filters__text-right live-count">3</span>
                                            <div class="radio-filters--blk__hilite"></div>
                                        </label>
                                        </div>
                                    </div>
                                    <div class="nav-acdr__grp nav-acdr__grp--single">
                                        <div class="radio-filters radio-filters--blk">
                                            <label class="radio-filters__lbl">
                                                <input type="radio"
                                                       name="filter_status"
                                                       class="radio-filters__radio" value="CLOSED">
                                                <span class="radio-filters__text-left">Closed</span>
                                                <span class="radio-filters__text-right closed-count">1</span>
                                                <div class="radio-filters--blk__hilite"></div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="nav-acdr__grp nav-acdr__grp--single">
                                        <div class="radio-filters radio-filters--blk">
                                            <label class="radio-filters__lbl">
                                                <input type="radio"
                                                       name="filter_status"
                                                       class="radio-filters__radio" value="CANCELLED">
                                                <span class="radio-filters__text-left">Cancelled</span>
                                                <span class="radio-filters__text-right cancelled-count">0</span>
                                                <div class="radio-filters--blk__hilite"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="grid-12 grid-custom-1024-up-9-last">
                            <!--Controls-->
                            <div class="volunteer-admin__container-controls">
                                <div class="search-result__sort-filter">
                                    <div class="select-btn is-active">
                                        <label class="mb-0 select-btn__lbl">
                                            <span
                                                class="select-btn__lbl-lbl mr-8 font-mid-grey body-txt body-txt--small"
                                                style="padding-bottom:10px">Sort By</span>
                                        </label>
                                        <select name="" id="sort-listing"
                                                class="select-ctn select--small select-btn__select">
                                            <option data-path=".volunteer-activity-name" value="title">Alphabetical
                                            </option>
                                            <option data-path=".volunteer-upcoming-datetime" value="date">Date
                                            </option>
                                            <option data-path=".volunteer-upcoming-datetime" value="date">Show latest
                                                first
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--Controls-->
                            <!--Loading-->
                            <div class="preloader" id="loadingPartialGif" style="display: none;">
                                <div style="text-align: center;">Loading now..</div>
                                <div class="preloader-ctn" role="dialog" id="js-flex-ctn--preloader-modal">
                                    <svg version="1.1" id="" class="preloader-ctn__svg"
                                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         x="0px" y="0px" width="40px" height="40px" viewBox="0 0 50 50"
                                         style="enable-background: new 0 0 50 50;" xml:space="preserve">
                                        <path class="preloader-ctn__loader" fill="#000"
                                              d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"></path>
                                    </svg>
                                </div>
                            </div>
                            <!--Loading-->
                            <!--Items-->
                            <div class="volunteer-cards-wrapper volunteer-cards-container">

                                <div
                                    class="rounded-card--header-solid rounded-card--gray-border volunteer-card no-box-shadow">
                                    <div
                                        class="rounded-card--header-solid__header rounded-card--gray-border__header flex-ctn flex-ctn--just-spc-btw flex-ctn--dir-col-tablet-portrait-up-row">
                                        <div>
                                            <div
                                                class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--just-start-mobile-tablet-portrait-up-center">
                                                <a href="/volunteer-event?event_activity_id=9109822"
                                                   style="text-decoration: none;"><h3
                                                    class="h3 mr-16 volunteer-activity-name">FOH Volunteers for
                                                    TheatreWorks' Production</h3></a>
                                                <div class="font-green">Organised by Bee Organisation</div>
                                            </div>
                                            <div class="flag-obj mb-8 mt-8">
                                                <div class="flag-obj__item flag-obj__item--top dark-grey"><i
                                                    class="material-icons">place</i></div>
                                                <div class="flag-obj__item"><p class="pb-8 volunteer-activity-location">
                                                    88 GEYLANG BAHRU</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rounded-card--header-solid__body rounded-card--gray-border__body">
                                        <ul class="list volunteer-admin__list">
                                            <li class="0 volunteer-activity-li event-li">
                                                <div class="flag-obj mb-8 ">
                                                    <div class="flag-obj__item flag-obj__item--top"><i
                                                        class="ico material-icons">event</i></div>
                                                    <div class="flag-obj__item flag-obj__item-with-button"><a
                                                        href="/volunteer-event?event_activity_id=9109822"
                                                        style="text-decoration: none;"><h4
                                                        class="mt-0 h4">08 May 2019 to 22 May
                                                        2019 </h4></a>
                                                        <div class="signup-status-select">
                                                            <div @click="toggleDetail=!toggleDetail"
                                                                 class="cursor sign-detail">
                                                                <i
                                                                    class="material-icons">
                                                                    {{ toggleDetail ? 'visibility_off' : 'visibility' }}
                                                                </i>
                                                            </div>
                                                            <select v-show="!toggleDetail"
                                                                    class=" select-ctn select--small"
                                                                    disabled=""
                                                                    style="padding: 6px 12px; background-image:none;">
                                                                <option selected="" class="signup-status-selected"
                                                                        value="attended-hour">Attended 14 hours
                                                                </option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="flag-obj mb-8">
                                                    <div class="flag-obj__item flag-obj__item--top"><i
                                                        class="ico material-icons">query_builder</i></div>
                                                    <div class="flag-obj__item"><p class="m-0 volunteer-activity-time">
                                                        2-3 days per week on weekday </p></div>
                                                </div>
                                                <div class="flag-obj">
                                                    <div class="flag-obj__item flag-obj__item--top"><i
                                                        class="ico material-icons">group</i></div>
                                                    <div class="flag-obj__item flag-obj__item-with-button"><p
                                                        class="m-0 volunteer-activity-position">Front of House</p>
                                                        <p class="font-green m-0">Signed up for 1 slot on 02 May
                                                            2019</p></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div
                                    class="rounded-card--header-solid rounded-card--gray-border volunteer-card no-box-shadow">
                                    <div
                                        class="rounded-card--header-solid__header rounded-card--gray-border__header flex-ctn flex-ctn--just-spc-btw flex-ctn--dir-col-tablet-portrait-up-row">
                                        <div>
                                            <div
                                                class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--just-start-mobile-tablet-portrait-up-center">
                                                <a href="/volunteer-event?event_activity_id=9109822"
                                                   style="text-decoration: none;"><h3
                                                    class="h3 mr-16 volunteer-activity-name">FOH Volunteers for
                                                    TheatreWorks' Production 1</h3></a>
                                                <div class="font-green">Organised by Bee Organisation</div>
                                            </div>
                                            <div class="flag-obj mb-8 mt-8">
                                                <div class="flag-obj__item flag-obj__item--top dark-grey"><i
                                                    class="material-icons">place</i></div>
                                                <div class="flag-obj__item"><p class="pb-8 volunteer-activity-location">
                                                    88 GEYLANG BAHRU</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rounded-card--header-solid__body rounded-card--gray-border__body">
                                        <ul class="list volunteer-admin__list">
                                            <li class="0 volunteer-activity-li event-li">
                                                <div class="flag-obj mb-8 ">
                                                    <div class="flag-obj__item flag-obj__item--top"><i
                                                        class="ico material-icons">event</i></div>
                                                    <div class="flag-obj__item flag-obj__item-with-button"><a
                                                        href="/volunteer-event?event_activity_id=9109822"
                                                        style="text-decoration: none;"><h4
                                                        class="mt-0 h4">21 May 2019 to 30 May 2019 </h4></a>
                                                        <select
                                                            class="signup-status-select select-ctn select--small">
                                                            <option selected="" class="signup-status-selected"
                                                                    value="PENDING">Pending
                                                            </option>
                                                            <option value="WITHDRAWN">Withdrawn</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flag-obj mb-8">
                                                    <div class="flag-obj__item flag-obj__item--top"><i
                                                        class="ico material-icons">query_builder</i></div>
                                                    <div class="flag-obj__item"><p class="m-0 volunteer-activity-time">
                                                        12:00 AM - 12:00 AM </p></div>
                                                </div>
                                                <div class="flag-obj">
                                                    <div class="flag-obj__item flag-obj__item--top"><i
                                                        class="ico material-icons">group</i></div>
                                                    <div class="flag-obj__item flag-obj__item-with-button"><p
                                                        class="m-0 volunteer-activity-position">Front of House</p>
                                                        <p class="font-green m-0">Signed up for 1 slot on 08 May
                                                            2019</p></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <!--Items-->
                            <nav
                                class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative pagination-nav-bar">
                                <ul class="pagi mt-16-tablet-portrait-up-0">
                                    <li class="pagi__item" data-role="page-prev"><a href="#"><span
                                        class="ico ico-page-prev"></span></a></li>
                                    <li class="pagi__item is-active" data-role="page-num"><a href="#">1</a></li>
                                    <li class="pagi__item" data-role="page-next"><a href="#"><span
                                        class="ico ico-page-next"></span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
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

    export default Base.extend({
        name: "Home",
        components: {
            Account
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


