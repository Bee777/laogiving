<template>
    <main class="activity pad clearfix">
        <div class="cWidth-1200 search-result__body">
            <!--Aside left-->
            <div class="search-result__aside aside-container">
                <!--Head-->
                <div class="search-result__aside-head">
                    <div class="flag-obj flag-obj--full">
                        <div class="flag-obj__item"><span
                            class="body-txt font-mid-grey">Filter By</span>
                        </div>
                        <div class="flag-obj__item text-right">
                            <a @click="clearFilters()"
                               class="cursor text-link body-txt--smaller bold js-clear-filters js-clear-filters-btn">CLEAR
                                ALL</a></div>
                    </div>
                </div>
                <!--Head-->
                <!--Filters-->
                <div class="res-ctn search-result__mobile-menu" :style="`right: ${showFilter? '0': ''}`">
                    <div class="res-ctn__bd lock-body">
                        <div class="hide-desktop-up">
                            <div class="flag-obj flag-obj--full">
                                <div class="flag-obj__item bold font-black">Filters</div>
                                <div class="flag-obj__item text-right"><a @click="toggleShowFilter()"
                                                                          class="res-ctn-hide-btn button-ctn button--ghost">
                                    DONE </a></div>
                            </div>
                        </div>
                        <div class="search-result__banner ">
                            <a @click="clearFilters()" class="h6 text-link--white text-link--no-underline">CLEAR
                                ALL</a>
                        </div>
                        <!--Filter Items-->
                        <!--Radio Item-->
                        <!--<div class="filter-item is-expanded">-->
                        <!--<div class="title-head">-->
                        <!--CATEGORIES-->
                        <!--<i class="material-icons title-head-icon">keyboard_arrow_down</i>-->
                        <!--</div>-->
                        <!--<div class=" title-body title-body-collapsible">-->
                        <!--<div class="radio-filters">-->
                        <!--<label class="radio-filters__lbl">-->
                        <!--<input type="radio" name="categories"-->
                        <!--class="radio-filters__radio callSearch categoriesType targetCategory"-->
                        <!--data-target="adHoc">-->
                        <!--<span-->
                        <!--class="radio-filters__text-left">Ad Hoc Volunteering</span>-->
                        <!--<span class="radio-filters__text-right">124</span>-->
                        <!--</label>-->
                        <!--</div>-->
                        <!--<div class="radio-filters">-->
                        <!--<label class="radio-filters__lbl">-->
                        <!--<input type="radio" name="categories"-->
                        <!--class="radio-filters__radio callSearch categoriesType targetCategory"-->
                        <!--data-target="adHoc">-->
                        <!--<span-->
                        <!--class="radio-filters__text-left">Regular Volunteering</span>-->
                        <!--<span class="radio-filters__text-right">253</span>-->
                        <!--</label>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <FilterItem v-if="!disableFilters.post_type" ref="post-type-filter" v-model="filters.post_type"
                                    type="radio-count"
                                    name="TYPE"
                                    @onClearSelected="()=>{filters.post_type = ''}"
                                    :items="options.post_type"/>

                        <!--Radio Item-->
                        <!--Checkbox Item-->

                        <FilterItem v-if="!disableFilters.causes" ref="causes-filter" v-model="filters.causes"
                                    name="CAUSES"
                                    :items="options.all_causes"/>

                        <template v-if="displayType !== 'organize'">

                            <FilterItem v-if="!disableFilters.openings" ref="openings-filter" v-model="filters.openings"
                                        name="OPENING"
                                        :items="options.openings"/>

                            <FilterItem v-if="!disableFilters.suitables" ref="suitables-filter"
                                        v-model="filters.suitables" name="SUITABILITY"
                                        :items="options.all_suitables"/>

                            <FilterItem v-if="!disableFilters.weekday_or_weekend" ref="weekday_or_weekend-filter"
                                        v-model="filters.weekday_or_weekend"
                                        name="WEEKDAY OR WEEKEND"
                                        :items="options.weekday_or_weekend"/>

                            <FilterItem v-if="!disableFilters.commitment_duration" ref="commitment_duration-filter"
                                        v-model="filters.commitment_duration"
                                        name="COMMITMENT DURATION"
                                        :items="options.commitment_duration"/>

                            <FilterItem v-if="!disableFilters.frequency" ref="frequency-filter"
                                        v-model="filters.frequency" name="FREQUENCY"
                                        :items="options.frequency"/>

                            <FilterItem v-if="!disableFilters.skills" ref="skills-filter" v-model="filters.skills"
                                        name="SKILLS"
                                        :items="options.all_skills"/>

                            <FilterItem v-if="!disableFilters.date" ref="date-filter" type="radio"
                                        v-model="filters.date" name="DATE"
                                        :items="options.dates"/>

                        </template>

                        <!--<div class="filter-item is-expanded">-->
                        <!--<div class="title-head">-->
                        <!--CAUSES-->
                        <!--<i class="material-icons title-head-icon">keyboard_arrow_down</i>-->
                        <!--</div>-->
                        <!--<div class=" title-body title-body-collapsible">-->
                        <!--<ul class="checkbox-list" style="max-height: none;">-->
                        <!--<li class="title-child">-->
                        <!--<label class="checkbox-list__checkbox">-->
                        <!--<input type="checkbox">-->
                        <!--<span class="checkbox-list__lbl-spn">-->
                        <!--Animal Welfare-->
                        <!--</span>-->
                        <!--</label>-->
                        <!--</li>-->
                        <!--<li class="title-child">-->
                        <!--<label class="checkbox-list__checkbox">-->
                        <!--<input type="checkbox">-->
                        <!--<span class="checkbox-list__lbl-spn">-->
                        <!--Arts & Heritage-->
                        <!--</span>-->
                        <!--</label>-->
                        <!--</li>-->
                        <!--<li class="title-child">-->
                        <!--<label class="checkbox-list__checkbox">-->
                        <!--<input type="checkbox">-->
                        <!--<span class="checkbox-list__lbl-spn">-->
                        <!--Children & Youth-->
                        <!--</span>-->
                        <!--</label>-->
                        <!--</li>-->
                        <!--</ul>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--Checkbox Item-->
                        <!--Radio Item ver2-->
                        <!--<div class="filter-item is-expanded">-->
                        <!--<div class="title-head">-->
                        <!--DATE-->
                        <!--<i class="material-icons title-head-icon">keyboard_arrow_down</i>-->
                        <!--</div>-->
                        <!--<div class=" title-body title-body-collapsible">-->
                        <!--<ul class="radio-btn&#45;&#45;large list&#45;&#45;bot-space-large"-->
                        <!--style="max-height: none;">-->
                        <!--<li>-->
                        <!--<label class="radio-btn__lbl">-->
                        <!--<input name="date-range" class="radio-btn__radio"-->
                        <!--type="radio">-->
                        <!--<span class="radio-btn__value">-->
                        <!--All Dates-->
                        <!--</span>-->
                        <!--</label>-->
                        <!--</li>-->
                        <!--<li>-->
                        <!--<label class="radio-btn__lbl">-->
                        <!--<input name="date-range" class="radio-btn__radio"-->
                        <!--type="radio">-->
                        <!--<span class="radio-btn__value">-->
                        <!--Tomorrow-->
                        <!--</span>-->
                        <!--</label>-->
                        <!--</li>-->
                        <!--</ul>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--Radio Item ver2-->
                        <!--Filter Items-->
                    </div>
                </div>
                <!--Overlay @is-visible-->
                <div @click="toggleShowFilter()" class="ovrly" :class="[{'is-visible': showFilter}]"></div>
                <!--Overlay-->
                <!--Filters-->
            </div>

            <!--Aside left-->
            <!--List Items-->

            <div class="search-result__main">
                <div class="search-result__main-head">
                    <p v-if="paginate.data && paginate.data.length <=0 && isSearch"
                       class="font-black bold caps search-result__result"><strong
                        class="big"></strong><span>NO RESULTS FOUND</span>
                        <span>for '{{query}}'</span></p>
                    <p v-else class="font-black bold caps search-result__result">
                        <strong>{{paginate.data.length}} </strong>
                        <span>RESULTS FOUND</span>
                    </p>
                    <div class="search-result__sort-filter">
                        <a @click="toggleShowFilter()" class="btn sort-filter">
                            <i class="material-icons">filter_list</i>
                            FILTERS
                        </a>
                    </div>
                </div>
                <div class="search-result__gallery-flex gallery--flex gallery--flex-fill-empty">
                    <template v-if="displayType === 'all'">
                        <template v-for="(item, idx) in  paginate.data">
                            <!--CardItem Volunteering-->
                            <template v-if="item.post_type==='activity'">
                                <div class="card card--flex" :key="idx">
                                    <div class="card__head">
                                        <div class="gradient-over-image">
                                            <div
                                                :style="`background-image: url(${item.images_media[0].image_base64});`"
                                                class="gradient-over-image__image--bg gradient-over-image__image">

                                            </div>
                                        </div>
                                        <div class="stats card__head-overlay font-white font-white"><span
                                            class="stats__num">{{getTotalVacancies(item)}}</span> <span
                                            class="stats__des">openings</span>
                                        </div>
                                    </div>
                                    <!--Card Body-->
                                    <div class="card__body">
                                        <h2 class="card__title break-word truncate">
                                            {{item.name}}
                                        </h2>
                                        <div class="media-by">
                                            <p
                                                class="body-txt body-txt--smaller body-txt--no-letter-space font-mid-grey break-word">
                                                by <span
                                                class="bold break-word">{{item.organize}}</span>
                                            </p>
                                        </div>

                                        <div class="media-obj mt-16">
                                            <div class="media-obj__asset"><i
                                                class="material-icons ico--small">event</i></div>
                                            <div
                                                class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                {{ getMonthsTextRange(item) }}
                                            </div>
                                        </div>

                                        <!--<div class="media-obj mt-16">-->
                                        <!--<div class="media-obj__asset"><i-->
                                        <!--class="material-icons ico&#45;&#45;small">event</i></div>-->
                                        <!--<div-->
                                        <!--class="media-obj__main media-obj__main&#45;&#45;small-spacing body-txt body-txt&#45;&#45;small">-->
                                        <!--Thu, 02 May 2019-->
                                        <!--&lt;!&ndash;<span&ndash;&gt;-->
                                        <!--&lt;!&ndash;class="other-date-label">+3 other dates</span>&ndash;&gt;-->
                                        <!--</div>-->
                                        <!--</div>-->
                                        <div class="media-obj mt-16">
                                            <div class="media-obj__asset"><i
                                                class="material-icons ico--small">query_builder</i></div>
                                            <div
                                                class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space">
                                                <span class="volunteer-preview-frequency volunteer-preview-start-time">{{ getFrequency()[item.frequency]}} on {{ getDaysOfWeek(item.days_of_week)}}</span>
                                                <br><span
                                                class="font-mid-grey body-txt--small frequency_duration_view">{{ item.duration}} hours per session</span>
                                            </div>
                                        </div>
                                        <div class="media-obj mt-16">
                                            <div class="media-obj__asset"><i
                                                class="material-icons ico--small">place</i></div>
                                            <div
                                                class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                {{ item.town }}
                                            </div>
                                        </div>
                                        <div class="media-obj mt-16">
                                            <div class="media-obj__asset"><i
                                                class="material-icons ico--small">group</i></div>
                                            <div
                                                class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                Suitable for: {{item.suitablesTexts}}
                                            </div>
                                        </div>
                                        <div class="card__cta">
                                            <button @click="emitRemoveAction(item)" v-if="removeAction"
                                                    class="button-ctn button--full mb-8">{{!item.removed ? 'REMOVE':
                                                'FAVOURITE'}}
                                            </button>
                                            <button v-else @click="openVolunteeringTab(item.id)"
                                                    class="btn button--no-bg button--full">
                                                LEARN MORE
                                            </button>
                                        </div>
                                    </div>
                                    <!--Card Body-->
                                    <!--Card Link-->
                                    <div>
                                        <a class="card__link" :href="`/posts/volunteer-activity/${item.id}`"
                                           target="_blank"></a>
                                    </div>
                                    <!--Card Link-->
                                </div>
                            </template>
                            <!--CardItem Volunteering-->
                            <template v-else>
                                <!--CardItem Organize-->
                                <div class="card card--flex" :key="idx">
                                    <div class="card__head">
                                        <div class="gradient-over-image">
                                            <div
                                                :style="`background-image: url(${item.image});`"
                                                class="gradient-over-image__image--bg gradient-over-image__image">

                                            </div>
                                        </div>
                                        <div class="stats card__head-overlay font-white font-white"><span
                                            class="stats__num">{{item.volunteering}}</span> <span
                                            class="stats__des">volunteer opportunity</span>
                                        </div>
                                    </div>
                                    <!--Card Body-->
                                    <div class="card__body">
                                        <div>
                                            <h2 class="card__title break-word truncate">
                                                {{item.user_name}}
                                            </h2>
                                            <p class="truncate2 card__description break-word">{{$utils.sub(item.about,
                                                115)}}</p>
                                        </div>
                                        <div class="card__cta">
                                            <button @click="emitRemoveAction(item)" v-if="removeAction"
                                                    class="button-ctn button--full mb-8">{{!item.removed ? 'REMOVE':
                                                'FAVOURITE'}}
                                            </button>
                                            <button v-else @click="openOrganizeTab(item.user_id)"
                                                    class="btn button--no-bg button--full">
                                                LEARN MORE
                                            </button>
                                        </div>
                                    </div>
                                    <!--Card Body-->
                                    <!--Card Link-->
                                    <div>
                                        <a class="card__link" :href="`/organisation/profile/${item.user_id}`"
                                           target="_blank"></a>
                                    </div>
                                    <!--Card Link-->
                                </div>
                                <!--CardItem Organize-->
                            </template>
                        </template>
                    </template>
                    <!--ALL ITEM TYPE-->
                    <template v-else-if="displayType !== 'organize'">
                        <!--CardItem Volunteering-->
                        <div class="card card--flex" :key="idx"
                             v-for="(item, idx) in  postsData.activities.posts.data">
                            <div class="card__head">
                                <div class="gradient-over-image">
                                    <div
                                        :style="`background-image: url(${item.images_media[0].image_base64});`"
                                        class="gradient-over-image__image--bg gradient-over-image__image">

                                    </div>
                                </div>
                                <div class="stats card__head-overlay font-white font-white"><span
                                    class="stats__num">{{getTotalVacancies(item)}}</span> <span
                                    class="stats__des">openings</span>
                                </div>
                            </div>
                            <!--Card Body-->
                            <div class="card__body">
                                <h2 class="card__title break-word truncate">
                                    {{item.name}}
                                </h2>
                                <div class="media-by">
                                    <p
                                        class="body-txt body-txt--smaller body-txt--no-letter-space font-mid-grey break-word">
                                        by <span
                                        class="bold break-word">{{item.organize}}</span>
                                    </p>
                                </div>

                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">event</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                        {{ getMonthsTextRange(item) }}
                                    </div>
                                </div>

                                <!--<div class="media-obj mt-16">-->
                                <!--<div class="media-obj__asset"><i-->
                                <!--class="material-icons ico&#45;&#45;small">event</i></div>-->
                                <!--<div-->
                                <!--class="media-obj__main media-obj__main&#45;&#45;small-spacing body-txt body-txt&#45;&#45;small">-->
                                <!--Thu, 02 May 2019-->
                                <!--&lt;!&ndash;<span&ndash;&gt;-->
                                <!--&lt;!&ndash;class="other-date-label">+3 other dates</span>&ndash;&gt;-->
                                <!--</div>-->
                                <!--</div>-->
                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">query_builder</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space">
                                        <span class="volunteer-preview-frequency volunteer-preview-start-time">{{ getFrequency()[item.frequency]}} on {{ getDaysOfWeek(item.days_of_week)}}</span>
                                        <br><span
                                        class="font-mid-grey body-txt--small frequency_duration_view">{{ item.duration}} hours per session</span>
                                    </div>
                                </div>
                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">place</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                        {{ item.town }}
                                    </div>
                                </div>
                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">group</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                        Suitable for: {{item.suitablesTexts}}
                                    </div>
                                </div>
                                <div class="card__cta">
                                    <button @click="openVolunteeringTab(item.id)"
                                            class="btn button--no-bg button--full">
                                        LEARN MORE
                                    </button>
                                </div>
                            </div>
                            <!--Card Body-->
                            <!--Card Link-->
                            <div>
                                <a class="card__link" :href="`/posts/volunteer-activity/${item.id}`"
                                   target="_blank"></a>
                            </div>
                            <!--Card Link-->
                        </div>
                        <!--CardItem Volunteering-->
                    </template>
                    <template v-else>
                        <!--CardItem Organize-->
                        <div v-show="paginate.data && paginate.data.length > 0" class="card card--flex" :key="idx"
                             v-for="(item, idx) in  ((postsData.activities.organizations || {}).data)">
                            <div class="card__head">
                                <div class="gradient-over-image">
                                    <div
                                        :style="`background-image: url(${item.image});`"
                                        class="gradient-over-image__image--bg gradient-over-image__image">

                                    </div>
                                </div>
                                <div class="stats card__head-overlay font-white font-white"><span
                                    class="stats__num">{{item.volunteering}}</span> <span
                                    class="stats__des">volunteer opportunity</span>
                                </div>
                            </div>
                            <!--Card Body-->
                            <div class="card__body">
                                <div>
                                    <h2 class="card__title break-word truncate">
                                        {{item.name}}
                                    </h2>
                                    <p class="truncate2 card__description break-word">{{$utils.sub(item.about,
                                        115)}}</p>
                                </div>
                                <div class="card__cta">
                                    <button @click="openOrganizeTab(item.id)"
                                            class="btn button--no-bg button--full">
                                        LEARN MORE
                                    </button>
                                </div>
                            </div>
                            <!--Card Body-->
                            <!--Card Link-->
                            <div>
                                <a class="card__link" :href="`/organisation/profile/${item.id}`"
                                   target="_blank"></a>
                            </div>
                            <!--Card Link-->
                        </div>
                        <!--CardItem Organize-->
                    </template>
                </div>

                <div class="mt-24 text-center">
                    <!--paginate-->
                    <nav
                        v-show="paginate.data && paginate.data.length > 0"
                        class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative pagination-nav-bar">
                        <ul class="pagi mt-16-tablet-portrait-up-0 data-ctn flex-ml-auto flex-mr-auto">
                            <li class="pagi__item" data-role="page-prev">
                                <a :disabled="paginate.current_page===1"
                                   @click="prevPage(paginate.current_page - 1)"><span
                                    class="ico ico-page-prev cursor"></span></a></li>
                            <li :key="idx" v-for="(p, idx) in paginate.last_page"
                                class="pagi__item" :class="[{'is-active': p===paginate.current_page}]"
                                data-role="page-num"><a href=""
                                                        @click.prevent="paginateNavigator({pageNo: p})">{{p}}</a>
                            </li>
                            <li class="pagi__item" data-role="page-next"><a
                                :disabled="paginate.current_page===paginate.last_page"
                                @click="nextPage(paginate.current_page + 1)"><span
                                class="ico ico-page-next cursor"></span></a></li>
                        </ul>
                    </nav>
                    <!--paginate-->
                </div>
            </div>
            <!--List Items-->
        </div>
    </main>
</template>

<script>
    import FilterItem from '@com/Utils/FilterItem.vue'
    import {mapState} from 'vuex'

    export default {
        name: "VolunteeringFilter",
        props: {
            displayType: {
                default: ''
            },
            removeAction: {
                default: false
            },
            filters: {
                default: function () {
                    return {
                        causes: [],
                        post_type: '',
                        openings: [],
                        skills: [],
                        suitables: [],
                        date: '',
                        weekday_or_weekend: [],
                        commitment_duration: [],
                        frequency: []
                    };
                }
            },
            disableFilters: {
                default: function () {
                    return {
                        post_type: false,
                        causes: false,
                        openings: false,
                        skills: false,
                        suitables: false,
                        date: false,
                        weekday_or_weekend: false,
                        commitment_duration: false,
                        frequency: false
                    };
                }
            },
            paginate: {
                default: function () {
                    return {per_page: 10, data: [], current_page: 1, last_page: 0, total: 0};
                }
            },
            query: {
                default: ''
            },
            isSearch: {
                default: false
            },
            options: {
                default: function () {
                    return {
                        post_type: [],
                        all_causes: [],
                        dates: [
                            {name: 'All Dates', id: 1},
                            {name: 'Tomorrow', id: 2},
                        ],
                        all_suitables: [],
                        all_skills: [],
                    }
                }
            }
        },
        components: {
            FilterItem
        },
        data: () => ({
            showFilter: false,
        }),
        computed: {
            ...mapState(['postsData']),
        },
        methods: {
            removeClasses() {
                this.jq("body").removeClass("hidden sidebar");
                this.jq("html").removeClass("hidden sidebar");
            },
            addClasses() {
                this.jq("html").addClass("hidden sidebar");
                this.jq("body").addClass("hidden sidebar");
            },
            toggleShowFilter() {
                this.showFilter = !this.showFilter;
                if (this.showFilter) {
                    this.addClasses();
                } else {
                    this.removeClasses();
                }
            },
            clearFilters() {
                this.showFilter = false;
                this.removeClasses();

                for (let filter in this.$refs) {
                    if (this.$refs.hasOwnProperty(filter) && filter.indexOf('filter') !== -1) {
                        if (filter === 'date-filter') {
                            this.$refs[filter].setValue('all_date');
                        } else if (filter === 'post-type-filter') {
                            this.$refs[filter].setValue('');
                        } else {
                            this.$refs[filter].setValue([]);
                        }
                    }
                }
                this.$emit('onClearFilters');
            },
            emitRemoveAction(item) {
                this.$emit('onRemoveAction', item);
            },
            openVolunteeringTab(id) {
                window.open(`/posts/volunteer-activity/${id}`);
            },
            openOrganizeTab(id) {
                window.open(`/organisation/profile/${id}`);
            },
            getTotalVacancies(item) {
                let total_vacancies = 0;
                let suitablesTexts = [];
                item.positions.map(i => {
                    total_vacancies += parseInt(i.vacancies) || 0;
                    i.position_suitables.map(suitable => {
                        let mSuitable = this.options.all_suitables.filter((filter) => {
                            return filter.id === suitable;
                        }).map(i => i.name).join('');
                        if (suitablesTexts.indexOf(mSuitable) === -1) {
                            suitablesTexts.push(mSuitable);
                        }
                    });
                });
                item.suitablesTexts = suitablesTexts.join(', ');
                return total_vacancies;
            },
            getDaysOfWeek(days_of_week) {
                return days_of_week.map(i => {
                    return i.toLowerCase()
                }).join(' or ');
            },
            getFrequency() {
                return {
                    '1_DAY_PER_WEEK': 'One day per week',
                    '2_3_DAYS_PER_WEEK': '2-3 days per week',
                    'FORTNIGHTLY': 'Fortnightly',
                    'MONTHLY': 'Monthly',
                    'QUARTERLY': 'Quarterly',
                    'FLEXIBLE': 'Flexible',
                    'FULL_TIME': 'Full Time'
                }
            },
            getMonthsTextRange(item) {
                let months = this.getDiffMonths(item.start_date, item.end_date, 1);
                if (months <= 1) {
                    return `1 Month`;
                } else {
                    return `1 - ${months} Months`;
                }
            },
            getDiffMonths(date1, date2, includes = 0) {
                let months;
                date1 = new Date(date1);
                date2 = new Date(date2);
                months = (date2.getFullYear() - date1.getFullYear()) * 12 + (date2.getMonth() - date1.getMonth()) + includes;
                return months <= 0 ? 0 : months;
            },
            paginateNavigator(p) {
                this.$emit('onPaginateNavigator', p)
            },
            prevPage(pageNo) {
                if (this.paginate.current_page === 1) return;
                if (pageNo < 1) pageNo = 1;
                if (this.paginate.current_page === pageNo) return;
                this.paginateNavigator({pageNo, dr: 'prev'});
            },
            nextPage(pageNo) {
                if (this.paginate.current_page === this.paginate.last_page) return;
                if (pageNo > this.paginate.lastPage) pageNo = this.paginate.lastPage;
                if (this.paginate.current_page === pageNo) return;
                this.paginateNavigator({pageNo, dr: 'next'});
            },
        }
    }
</script>

<style scoped>

</style>
