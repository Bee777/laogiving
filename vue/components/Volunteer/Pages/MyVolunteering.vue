<template>
    <div class="ctn">
        <div class="cWidth-1200 pt-40 clearfix">
            <div
                class="flex-ctn flex-ctn--just-spc-btw flex-ctn--tablet-portrait-up-align-center flex-ctn--dir-col-tablet-portrait-up-row">
                <div class="dbl-stats">
                    <div class="dbl-stats__item">
                        <div class="dbl-stats__stats mb-8">{{statuses.CHECKIN_COUNT}}/{{
                            parseInt(statuses.CHECKIN_COUNT) + parseInt(statuses.CONFIRM_COUNT) }}
                        </div>
                        <div class="dbl-stats__desc"> attended</div>
                    </div>
                    <div class="dbl-stats__item">
                        <div class="dbl-stats__stats mb-8">{{statuses.LEADER_COUNT}}</div>
                        <div class="dbl-stats__desc"> as leader</div>
                    </div>
                    <div class="dbl-stats__item">
                        <div class="dbl-stats__stats mb-8">{{$utils.numSpace(statuses.HOURS_COUNT)}}</div>
                        <div class="dbl-stats__desc"> total hours</div>
                    </div>
                </div>
            </div>
            <hr class="hr">

            <div class="volunteer-admin__container" id="my-volunteer-activities">
                <div
                    class="volunteer-admin__container-nav grid-12 grid-custom-1024-up-3 pt-16-custom-1024-up-86">

                    <RadioToggle :items="filterItems" v-model="filters.volunteering"/>

                    <!--<div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">-->
                    <!--<div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span-->
                    <!--class="nav-acdr__title">Live</span> <span-->
                    <!--class="nav-acdr__stats live-count">3</span></div>-->
                    <!--<div class="nav-acdr__body">-->
                    <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
                    <!--<div class="radio-filters radio-filters&#45;&#45;blk"><label class="radio-filters__lbl">-->
                    <!--<input type="radio" checked=""-->
                    <!--name="filter_status"-->
                    <!--class="radio-filters__radio" value="LIVE">-->
                    <!--<span class="radio-filters__text-left">Live</span>-->
                    <!--<span class="radio-filters__text-right live-count">3</span>-->
                    <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
                    <!--</label>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
                    <!--<div class="radio-filters radio-filters&#45;&#45;blk">-->
                    <!--<label class="radio-filters__lbl">-->
                    <!--<input type="radio"-->
                    <!--name="filter_status"-->
                    <!--class="radio-filters__radio" value="CLOSED">-->
                    <!--<span class="radio-filters__text-left">Closed</span>-->
                    <!--<span class="radio-filters__text-right closed-count">1</span>-->
                    <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
                    <!--</label>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
                    <!--<div class="radio-filters radio-filters&#45;&#45;blk">-->
                    <!--<label class="radio-filters__lbl">-->
                    <!--<input type="radio"-->
                    <!--name="filter_status"-->
                    <!--class="radio-filters__radio" value="CANCELLED">-->
                    <!--<span class="radio-filters__text-left">Cancelled</span>-->
                    <!--<span class="radio-filters__text-right cancelled-count">0</span>-->
                    <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
                    <!--</label>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->

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
                                        v-model="filters.sort"
                                        class="select-ctn select--small select-btn__select">
                                    <option data-path=".volunteer-activity-name" value="name">Alphabetical
                                    </option>
                                    <option data-path=".volunteer-upcoming-datetime" value="date">Date
                                    </option>
                                    <option data-path=".volunteer-upcoming-datetime" value="latest">Show latest
                                        first
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--Controls-->
                    <!--Loading-->
                    <ItemsLoading v-if="validated().loading_searches"/>
                    <!--Loading-->
                    <!--Not found-->
                    <div
                        v-show="!validated().loading_searches && filterShortActivity.length <= 0"
                        class="no-result-card font-black bold caps search-result__result" style="font-size: 16px;">
                        <p>No results found</p>
                    </div>
                    <!--Not fount-->
                    <div id="volunteering-list-container"
                         style="position: relative; height: auto; visibility: hidden"></div>
                    <!--Items-->
                    <div class="volunteer-cards-wrapper volunteer-cards-container">


                        <div
                            v-show="!validated().loading_searches"
                            v-for="(item, idx) in filterShortActivity" :key="idx"
                            class="rounded-card--header-solid rounded-card--gray-border volunteer-card no-box-shadow">
                            <div
                                class="rounded-card--header-solid__header rounded-card--gray-border__header flex-ctn flex-ctn--just-spc-btw flex-ctn--dir-col-tablet-portrait-up-row">
                                <div>
                                    <div
                                        class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--just-start-mobile-tablet-portrait-up-center">
                                        <a target="_blank" :href="`/posts/volunteer-activity/${item.id}`"
                                           style="text-decoration: none;"><h3
                                            class="h3 mr-16 volunteer-activity-name">{{item.name}}</h3></a>
                                        <div class="font-green">Organised by {{item.organize_name}}</div>
                                    </div>
                                    <div class="flag-obj mb-8 mt-8">
                                        <div class="flag-obj__item flag-obj__item--top dark-grey"><i
                                            class="material-icons">place</i></div>
                                        <div class="flag-obj__item"><p class="pb-8 volunteer-activity-location">
                                            {{item.block_street}}</p></div>
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
                                                target="_blank" :href="`/posts/volunteer-activity/${item.id}`"
                                                style="text-decoration: none;"><h4
                                                class="mt-0 h4">{{item.start_date_formatted_name}} to
                                                {{item.end_date_formatted_name}} </h4></a>
                                                <div class="signup-status-select">
                                                    <div @click="item.toggleDetail=!item.toggleDetail"
                                                         class="cursor sign-detail">
                                                        <i
                                                            class="material-icons">
                                                            {{ item.toggleDetail ? 'visibility_off' : 'visibility' }}
                                                        </i>
                                                    </div>
                                                    <select
                                                        @change="changeSingUpStatus(item)"
                                                        v-show="!item.toggleDetail"
                                                        class="select-ctn select--small"
                                                        :disabled="item.sign_up_status !== 'pending'"
                                                        v-model="item.selectedStatus"
                                                        :style="`${item.sign_up_status !== 'pending' ? 'padding: 6px 12px; background-image:none;background-color: #eee;' : ''}`">
                                                        <option v-if="item.sign_up_status === 'checkin'"
                                                                value="checkin">Attended
                                                            {{item.sign_up_hour_per_volunteer}} hours
                                                        </option>
                                                        <option v-if="item.sign_up_status === 'confirm'"
                                                                value="confirm">Confirmed
                                                        </option>
                                                        <option v-if="item.sign_up_status === 'rejected'"
                                                                value="rejected">Rejected
                                                        </option>
                                                        <option v-if="item.sign_up_status === 'pending'"
                                                                value="pending">Pending
                                                        </option>
                                                        <option
                                                            v-if="item.sign_up_status === 'withdrawn' || item.sign_up_status === 'pending'"
                                                            value="withdrawn">Withdrawn
                                                        </option>
                                                    </select>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="flag-obj mb-8">
                                            <div class="flag-obj__item flag-obj__item--top"><i
                                                class="ico material-icons">query_builder</i></div>
                                            <div class="flag-obj__item"><p class="m-0 volunteer-activity-time"> {{
                                                getFrequency()[item.frequency]}} on {{
                                                getDaysOfWeek(item.days_of_week)}} </p></div>
                                        </div>
                                        <div class="flag-obj">
                                            <div class="flag-obj__item flag-obj__item--top"><i
                                                class="ico material-icons">group</i></div>
                                            <div class="flag-obj__item flag-obj__item-with-button"><p
                                                class="m-0 volunteer-activity-position">
                                                {{getVolunteeringSelectedPosition(item.sign_up_position_id,
                                                item).position_title}}</p>
                                                <p class="font-green m-0">Signed up for {{item.sign_up_slot}} slot on
                                                    {{getSignUpDate(item.sign_up_created_at)}}</p>
                                                <button v-if=" item.sign_up_leader === 'yes' && item.status === 'live' "
                                                        @click="Route({name: 'manage-sign-up-volunteers', query: {volunteering_id: item.id}})"
                                                        class="button-ctn button--ghost button--small manage-signup-button">
                                                    MANAGE
                                                </button>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--TEMP-->
                        <!--<div-->
                        <!--class="rounded-card&#45;&#45;header-solid rounded-card&#45;&#45;gray-border volunteer-card no-box-shadow">-->
                        <!--<div-->
                        <!--class="rounded-card&#45;&#45;header-solid__header rounded-card&#45;&#45;gray-border__header flex-ctn flex-ctn&#45;&#45;just-spc-btw flex-ctn&#45;&#45;dir-col-tablet-portrait-up-row">-->
                        <!--<div>-->
                        <!--<div-->
                        <!--class="flex-ctn flex-ctn&#45;&#45;dir-col-tablet-portrait-up-row flex-ctn&#45;&#45;just-start-mobile-tablet-portrait-up-center">-->
                        <!--<a href="/volunteer-event?event_activity_id=9109822"-->
                        <!--style="text-decoration: none;"><h3-->
                        <!--class="h3 mr-16 volunteer-activity-name">FOH Volunteers for-->
                        <!--TheatreWorks' Production</h3></a>-->
                        <!--<div class="font-green">Organised by Bee Organisation</div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj mb-8 mt-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top dark-grey"><i-->
                        <!--class="material-icons">place</i></div>-->
                        <!--<div class="flag-obj__item"><p class="pb-8 volunteer-activity-location">-->
                        <!--88 GEYLANG BAHRU</p></div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="rounded-card&#45;&#45;header-solid__body rounded-card&#45;&#45;gray-border__body">-->
                        <!--<ul class="list volunteer-admin__list">-->
                        <!--<li class="0 volunteer-activity-li event-li">-->
                        <!--<div class="flag-obj mb-8 ">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">event</i></div>-->
                        <!--<div class="flag-obj__item flag-obj__item-with-button"><a-->
                        <!--href="/volunteer-event?event_activity_id=9109822"-->
                        <!--style="text-decoration: none;"><h4-->
                        <!--class="mt-0 h4">08 May 2019 to 22 May-->
                        <!--2019 </h4></a>-->
                        <!--<div class="signup-status-select">-->
                        <!--<div @click="toggleDetail=!toggleDetail"-->
                        <!--class="cursor sign-detail">-->
                        <!--<i-->
                        <!--class="material-icons">-->
                        <!--{{ toggleDetail ? 'visibility_off' : 'visibility' }}-->
                        <!--</i>-->
                        <!--</div>-->
                        <!--<select v-show="!toggleDetail"-->
                        <!--class=" select-ctn select&#45;&#45;small"-->
                        <!--disabled=""-->
                        <!--style="padding: 6px 12px; background-image:none;">-->
                        <!--<option selected="" class="signup-status-selected"-->
                        <!--value="attended-hour">Attended 14 hours-->
                        <!--</option>-->
                        <!--</select>-->
                        <!--</div>-->

                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj mb-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">query_builder</i></div>-->
                        <!--<div class="flag-obj__item"><p class="m-0 volunteer-activity-time">-->
                        <!--2-3 days per week on weekday </p></div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">group</i></div>-->
                        <!--<div class="flag-obj__item flag-obj__item-with-button"><p-->
                        <!--class="m-0 volunteer-activity-position">Front of House</p>-->
                        <!--<p class="font-green m-0">Signed up for 1 slot on 02 May-->
                        <!--2019</p></div>-->
                        <!--</div>-->
                        <!--</li>-->
                        <!--</ul>-->
                        <!--</div>-->
                        <!--</div>-->


                        <!--<div-->
                        <!--class="rounded-card&#45;&#45;header-solid rounded-card&#45;&#45;gray-border volunteer-card no-box-shadow">-->
                        <!--<div-->
                        <!--class="rounded-card&#45;&#45;header-solid__header rounded-card&#45;&#45;gray-border__header flex-ctn flex-ctn&#45;&#45;just-spc-btw flex-ctn&#45;&#45;dir-col-tablet-portrait-up-row">-->
                        <!--<div>-->
                        <!--<div-->
                        <!--class="flex-ctn flex-ctn&#45;&#45;dir-col-tablet-portrait-up-row flex-ctn&#45;&#45;just-start-mobile-tablet-portrait-up-center">-->
                        <!--<a href="/volunteer-event?event_activity_id=9109822"-->
                        <!--style="text-decoration: none;"><h3-->
                        <!--class="h3 mr-16 volunteer-activity-name">FOH Volunteers for-->
                        <!--TheatreWorks' Production 1</h3></a>-->
                        <!--<div class="font-green">Organised by Bee Organisation</div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj mb-8 mt-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top dark-grey"><i-->
                        <!--class="material-icons">place</i></div>-->
                        <!--<div class="flag-obj__item"><p class="pb-8 volunteer-activity-location">-->
                        <!--88 GEYLANG BAHRU</p></div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="rounded-card&#45;&#45;header-solid__body rounded-card&#45;&#45;gray-border__body">-->
                        <!--<ul class="list volunteer-admin__list">-->
                        <!--<li class="0 volunteer-activity-li event-li">-->
                        <!--<div class="flag-obj mb-8 ">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">event</i></div>-->
                        <!--<div class="flag-obj__item flag-obj__item-with-button"><a-->
                        <!--href="/volunteer-event?event_activity_id=9109822"-->
                        <!--style="text-decoration: none;"><h4-->
                        <!--class="mt-0 h4">21 May 2019 to 30 May 2019 </h4></a>-->
                        <!--<select-->
                        <!--class="signup-status-select select-ctn select&#45;&#45;small">-->
                        <!--<option selected="" class="signup-status-selected"-->
                        <!--value="PENDING">Pending-->
                        <!--</option>-->
                        <!--<option value="WITHDRAWN">Withdrawn</option>-->
                        <!--</select>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj mb-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">query_builder</i></div>-->
                        <!--<div class="flag-obj__item"><p class="m-0 volunteer-activity-time">-->
                        <!--12:00 AM - 12:00 AM </p></div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">group</i></div>-->
                        <!--<div class="flag-obj__item flag-obj__item-with-button"><p-->
                        <!--class="m-0 volunteer-activity-position">Front of House</p>-->
                        <!--<p class="font-green m-0">Signed up for 1 slot on 08 May-->
                        <!--2019</p></div>-->
                        <!--</div>-->
                        <!--</li>-->
                        <!--</ul>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--TEMP-->
                    </div>
                    <!--Items-->
                    <!--paginate-->
                    <nav
                        v-show="!validated().loading_searches && filterShortActivity.length > 0"
                        class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative pagination-nav-bar">
                        <ul class="pagi mt-16-tablet-portrait-up-0">
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
        </div>
    </div>
</template>

<script>
    import RadioToggle from '@com/Utils/RadioToggle.vue'
    import ItemsLoading from '@com/Utils/ItemsLoading.vue';
    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'

    export default {
        name: "MyVolunteering",
        components: {
            RadioToggle,
            ItemsLoading
        },
        props: {
            visible: {
                default: false
            }
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            filterItems: [
                {text: 'Live', value: 'LIVE', count: 0},
                {text: 'Closed', value: 'CLOSED', count: 0},
                {text: 'Cancelled', value: 'CANCELLED', count: 0},
            ],
            paginate: {per_page: 8, data: [], current_page: 1, last_page: 0, total: 0},
            filters: {volunteering: 'LIVE', sort: 'name'},
            isSearch: false,
            isNavigator: false,
            query: '',
            isTyped: false,
            type: 'volunteering',
            toggleDetail: false,
            statuses: {CHECKIN_COUNT: 0, CONFIRM_COUNT: 0, LEADER_COUNT: 0, HOURS_COUNT: 0},
        }),
        watch: {
            visible: function (n) {
                if (n) {
                    this.getVolunteering();
                }
            },
            'searchesData.volunteering': function (n) {
                this.paginate = n;
            },
            'filters.volunteering': function (n) {
                this.paginate.current_page = 1;//reset current page
                this.getVolunteering();
            },
            'searchesData.options.volunteering': function (n) {
                this.filterItems.map(item => {
                    item.count = n.volunteering_activities[`${item.value}_COUNT`];
                    return item;
                });
                this.statuses = n.volunteering_statuses;
            }
        },
        computed: {
            ...mapState(['isMobile', 'authUserInfo', 'searchesData']),
            filterShortActivity() {
                let data = this.searchesData.volunteering.data || [];
                let sort = this.filters.sort;
                if (sort === 'name') {
                    data.sort((a, b) => {
                        return a.name.localeCompare(b.name);
                    });
                } else if (sort === 'latest') {
                    data.sort((a, b) => {
                        let a_date = new Date(a.created_at).getTime(),
                            b_date = new Date(b.created_at).getTime();
                        return b_date - a_date;
                    });
                } else if (sort === 'date') {
                    data.sort((a, b) => {
                        let a_date = new Date(a.updated_at).getTime(),
                            b_date = new Date(b.updated_at).getTime();
                        return b_date - a_date;
                    });
                }

                return data;
            }
        },
        methods: {
            ...mapMutations(['setClearValidate']),
            ...mapActions(['showErrorToast', 'showInfoToast', 'fetchSearches', 'postChangeSignUpVolunteeringStatus']),
            getVolunteering(t = '') {
                if (!this.isTyped && t === 'click') {//check if user never type in search box but got click search button
                    return;
                }
                if (!this.isNavigator) {
                    this.paginate.current_page = 1;
                }
                this.isSearch = false;//set user searching to false
                //reset scroll bar position
                this.$nextTick(() => {
                    let posY = this.$utils.findPos(this.jq('#volunteering-list-container').get(0)).y;
                    this.$utils.animateScrollToY('html,body', posY - 300);
                });
                this.fetchSearches({
                    filters: this.filters,
                    type: this.type, q: this.query,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                });
            },
            paginateNavigator(p) {
                this.isNavigator = true; //set to true to tell the request this is navigator action
                this.paginate.current_page = p.pageNo; //set current page next or prev page for pagination
                this.getVolunteering();
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
            getTotalOpportunityVacancies(positions, key) {
                let total = 0;
                positions.map(pos => {
                    total += pos[key] || 0;
                    return pos;
                });
                return total;
            },
            toaster(msg, delay = 3500) {
                let toaster = this.jq('.toast');
                if (!toaster.length) {
                    return;
                }
                toaster.get(0).innerHTML = msg;
                toaster.css('display', 'block');
                setTimeout(() => {
                    toaster.get(0).innerHTML = '';
                    toaster.css('display', 'none');
                }, delay)
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
            getSignUpDate(date) {
                //02 May 2019
                date = this.$utils.getDateTime(date);
                return `${date.days} ${date.months} ${date.years}`;
            },
            getVolunteeringSelectedPosition(pos_id, item) {
                return (item.positions || []).filter(pos => {
                    return pos.id === pos_id;
                }).shift() || {};
            },
            changeSingUpStatus(item) {
                let res = confirm(`Are you sure you want to ${item.selectedStatus} this activity?`);
                if (res) {
                    this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                    item.sign_up_status = item.selectedStatus;
                    this.postChangeSignUpVolunteeringStatus({id: item.id, data: item}).then(res => {
                        if (!res.success) {
                            item.selectedStatus = 'pending';
                        }
                        this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                    }).catch(() => {
                        this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                        item.selectedStatus = 'pending';
                    })
                } else {
                    item.selectedStatus = 'pending';
                }
            }
        },
        created() {
            this.getVolunteering = this.debounce(this.getVolunteering, 150);
            if (this.visible) {
                this.getVolunteering();
            }
        }
    }
</script>

<style scoped>

</style>
