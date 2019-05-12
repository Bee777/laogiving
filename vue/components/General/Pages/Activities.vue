<template>
    <div class="container">
        <main class="activity">
            <div class="cWidth-1200 search-result__body">
                <div class="row">
                    <!--Aside left-->
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="aside-container">
                            <!--Head-->
                            <div class="search-result__aside-head">
                                <div class="flag-obj flag-obj--full">
                                    <div class="flag-obj__item"><span class="body-txt font-mid-grey">Filter By</span>
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
                                                class="res-ctn-hide-btn button-ctn button--ghost"> DONE </a></div>
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
                                                    <span class="radio-filters__text-left">Ad Hoc Volunteering</span>
                                                    <span class="radio-filters__text-right">124</span>
                                                </label>
                                            </div>
                                            <div class="radio-filters">
                                                <label class="radio-filters__lbl">
                                                    <input type="radio" name="categories"
                                                           class="radio-filters__radio callSearch categoriesType targetCategory"
                                                           data-target="adHoc">
                                                    <span class="radio-filters__text-left">Regular Volunteering</span>
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
                                                        <input name="date-range" class="radio-btn__radio" type="radio">
                                                        <span class="radio-btn__value">
                                                All Dates
                                            </span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="radio-btn__lbl">
                                                        <input name="date-range" class="radio-btn__radio" type="radio">
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
                                    <div class="card card--flex no-margin-lr">
                                        <div class="card__head">
                                            <div class="gradient-over-image">
                                                <div
                                                    :style="`background-image: url(https://www.giving.sg/image/logo?img_id=9040323);`"
                                                    class="gradient-over-image__image--bg gradient-over-image__image">

                                                </div>
                                            </div>
                                            <div class="stats card__head-overlay font-white font-white"><span
                                                class="stats__num">30</span> <span class="stats__des">openings</span>
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
                                                <button class="btn button--no-bg button--full">LEARN MORE</button>
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
</template>


<script>

    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'Activities',
        }),
        created() {
            this.setPageTitle('Activities');
        }
    });
</script>

<style scoped>

</style>
