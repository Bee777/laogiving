<template>
    <div class="ctn">
        <div class="cWidth-1200 clearfix">
            <div class="volunteer-admin__container" id="my-volunteer-activities">
                <form class="form" @submit.prevent>
                    <div
                        class="volunteer-admin__container-nav grid-12 grid-custom-1024-up-3 pt-16-custom-1024-up-86">
                        <!--Radios


                        <div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">
                            <div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span
                                class="nav-acdr__title">Live</span> <span
                                class="nav-acdr__stats live-count">3</span></div>
                            <div class="nav-acdr__body">
                                <div class="nav-acdr__grp nav-acdr__grp--single">
                                    <div class="radio-filters radio-filters--blk"><label
                                        class="radio-filters__lbl">
                                        <input type="radio" checked=""
                                               name="filter_status"
                                               class="radio-filters__radio" value="LIVE">
                                        <span class="radio-filters__text-left">Current Opportunities</span>
                                        <span class="radio-filters__text-right live-count">2</span>
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
                                            <span class="radio-filters__text-left">Past Opportunities</span>
                                            <span class="radio-filters__text-right closed-count">5</span>
                                            <div class="radio-filters--blk__hilite"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="nav-acdr__grp nav-acdr__grp--single">
                                    <div class="radio-filters radio-filters--blk">
                                        <label class="radio-filters__lbl">
                                            <input type="radio"
                                                   name="filter_status"
                                                   class="radio-filters__radio" value="DRAFT">
                                            <span class="radio-filters__text-left">Drafts</span>
                                            <span class="radio-filters__text-right cancelled-count">0</span>
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
                        <-->
                        <RadioToggle :items="filterItems" v-model="filters.volunteering"/>
                    </div>
                    <div class="grid-12 grid-custom-1024-up-9-last">
                        <!--Controls-->
                        <div class="volunteer-admin__container-controls">

                            <button @click="Route({name: 'create-activity'})" class="button-ctn">CREATE NEW
                            </button>
                            <button @click="Route({name: 'all-volunteers'})" class="button-ctn button--ghost">
                                VIEW ALL VOLUNTEERS
                            </button>

                            <div id="sortSelectButton" class="search-result__sort-filter">
                                <div class="select-btn selectInButton">


                                    <label class="mb-0 select-btn__lbl">
                                            <span
                                                class="select-btn__lbl-lbl mr-8 font-mid-grey body-txt body-txt--small"
                                                style="padding-bottom:10px">Sort By</span>
                                    </label>
                                    <select name="" id="sort-listing"
                                            v-model="filters.sort"
                                            class="select-ctn select--small select-btn__select">
                                        <option data-path=".volunteer-activity-name" value="name">
                                            Alphabetical
                                        </option>
                                        <option data-path=".volunteer-upcoming-datetime" value="date">Date
                                        </option>
                                        <option data-path=".volunteer-upcoming-datetime" value="latest">Show
                                            latest
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
                        <!--Items-->
                        <div v-show="!validated().loading_searches"
                             v-for="(item, idx) in filterShortActivity" :key="idx"
                             class="volunteer-cards-wrapper volunteer-cards-container">

                            <div
                                class="rounded-card--header-solid rounded-card--gray-border volunteer-card no-box-shadow">
                                <div
                                    class="rounded-card--header-solid__header rounded-card--gray-border__header flex-ctn flex-ctn--just-spc-btw flex-ctn--dir-col-tablet-portrait-up-row">
                                    <div>
                                        <div
                                            class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--just-start-mobile-tablet-portrait-up-center">
                                            <a @click="$utils.Location(`/posts/volunteer-activity/${item.id}`)"
                                               style="text-decoration: none;"><h3
                                                class="h3  cursor mr-16 volunteer-activity-name">{{item.name}}</h3></a>
                                        </div>


                                        <div class="flag-obj mb-8 mt-8">
                                            <div class="flag-obj__item flag-obj__item--top dark-grey"><i
                                                class="material-icons">place</i></div>
                                            <div class="flag-obj__item"><p
                                                class="pb-8 volunteer-activity-location">{{item.block_street}}</p></div>
                                        </div>

                                        <div class="flag-obj mb-8 mt-8">
                                            <div class="flag-obj__item flag-obj__item--top dark-grey"><i
                                                class="material-icons">event</i></div>
                                            <div class="flag-obj__item"><p class="pb-8">{{item.active_opportunity}}
                                                active
                                                opportunity</p>
                                            </div>
                                        </div>

                                        <div class="flag-obj mb-8 mt-8">
                                            <div class="flag-obj__item flag-obj__item--top dark-grey"><i
                                                class="material-icons">group</i></div>
                                            <div class="flag-obj__item">
                                                <p v-if="item.volunteer_signups_confirm==='yes'"
                                                   class="font-orange pb-8">{{item.signup_pending_confirmation}} signup
                                                    pending confirmation</p>
                                                <p v-else
                                                   class="pb-8">This activity does not require confirmation</p></div>
                                        </div>
                                    </div>

                                    <div class="flex-ctn flex-ctn--align-center">
                                        <button
                                            @click="Route({name: 'create-activity',  query: {active_page: 'general-info-&-permissions', volunteering_id: item.id}})"
                                            class="button-ctn button--103 button--small ml-40-mr-16 edit-volunteer-button">
                                            EDIT
                                        </button>
                                        <button
                                            v-if="item.status !== 'draft'"
                                            @click="duplicateData(item)"
                                            class="button-ctn button--ghost button--103 button--small duplicate-volunteer-button">
                                            DUPLICATE
                                        </button>
                                        <button
                                            v-else
                                            @click="disCardVolunteering(item)"
                                            class="button-ctn button--ghost button--103 button--small duplicate-volunteer-button">
                                            DISCARD
                                        </button>
                                    </div>

                                </div>

                                <div class="rounded-card--header-solid__body rounded-card--gray-border__body">
                                    <ul class="list volunteer-admin__list">
                                        <li class="0 volunteer-activity-li event-li">
                                            <div class="flag-obj mb-8 ">
                                                <div class="flag-obj__item flag-obj__item--top"><i
                                                    class="ico material-icons">event</i></div>
                                                <div class="flag-obj__item flag-obj__item-with-button"><a
                                                    @click="$utils.Location(`/posts/volunteer-activity/${item.id}`)"
                                                    style="text-decoration: none;"><h4
                                                    class="mt-0 h4 cursor">{{item.start_date_formatted}} to
                                                    {{item.end_date_formatted}} </h4></a>

                                                </div>
                                            </div>
                                            <div class="flag-obj">
                                                <div class="flag-obj__item flag-obj__item--top"><i
                                                    class="ico material-icons">group</i></div>
                                                <div class="flag-obj__item flag-obj__item-with-button">
                                                    <p v-if="item.status==='live'" class="font-green m-0">Registration
                                                        open</p>
                                                    <p v-if="item.status==='closed'" class="m-0">Registration closed</p>
                                                    <p :key="jdx" v-if="jitem.vacancies"
                                                       v-for="(jitem, jdx) in item.positions" class="m-0"> {{
                                                        jitem.position_title }}:
                                                        {{jitem.active_opportunity}}/{{jitem.vacancies}} </p>
                                                    <!--<p class="m-0">Front of House: 1/10</p>-->
                                                    <button v-if="item.status !== 'draft'"
                                                            @click="Route({name: 'manage-sign-up-volunteers'})"
                                                            class="button-ctn button--ghost button--small manage-signup-button">
                                                        MANAGE
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>


                        </div>

                        <!--Temp-->
                        <!--<div class="volunteer-cards-wrapper volunteer-cards-container">-->

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
                        <!--</div>-->


                        <!--<div class="flag-obj mb-8 mt-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top dark-grey"><i-->
                        <!--class="material-icons">place</i></div>-->
                        <!--<div class="flag-obj__item"><p-->
                        <!--class="pb-8 volunteer-activity-location">-->
                        <!--88 GEYLANG BAHRU</p></div>-->
                        <!--</div>-->

                        <!--<div class="flag-obj mb-8 mt-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top dark-grey"><i-->
                        <!--class="material-icons">event</i></div>-->
                        <!--<div class="flag-obj__item"><p class="pb-8">1 active-->
                        <!--opportunity</p>-->
                        <!--</div>-->
                        <!--</div>-->

                        <!--<div class="flag-obj mb-8 mt-8">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top dark-grey"><i-->
                        <!--class="material-icons">group</i></div>-->
                        <!--<div class="flag-obj__item"><p class="font-orange pb-8">0 signup-->
                        <!--pending confirmation</p></div>-->
                        <!--</div>-->
                        <!--</div>-->

                        <!--<div class="flex-ctn flex-ctn&#45;&#45;align-center">-->
                        <!--<button-->
                        <!--class="button-ctn button&#45;&#45;103 button&#45;&#45;small ml-40-mr-16 edit-volunteer-button">-->
                        <!--EDIT-->
                        <!--</button>-->
                        <!--<button-->
                        <!--class="button-ctn button&#45;&#45;ghost button&#45;&#45;103 button&#45;&#45;small duplicate-volunteer-button">-->
                        <!--DUPLICATE-->
                        <!--</button>-->
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
                        <!--class="mt-0 h4">08/05/2019 to 22/05/2019 </h4></a>-->

                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="flag-obj">-->
                        <!--<div class="flag-obj__item flag-obj__item&#45;&#45;top"><i-->
                        <!--class="ico material-icons">group</i></div>-->
                        <!--<div class="flag-obj__item flag-obj__item-with-button"><p-->
                        <!--class="font-green m-0">Registration open</p>-->
                        <!--<p class="m-0">Front of House: 1/10</p>-->
                        <!--<button @click="Route({name: 'manage-sign-up-volunteers'})"-->
                        <!--class="button-ctn button&#45;&#45;ghost button&#45;&#45;small manage-signup-button">-->
                        <!--MANAGE-->
                        <!--</button>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</li>-->
                        <!--</ul>-->
                        <!--</div>-->

                        <!--</div>-->


                        <!--</div>-->
                        <!--Temp-->
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
                                    data-role="page-num"><a href="" @click.prevent="paginateNavigator({pageNo: p})">{{p}}</a>
                                </li>
                                <li class="pagi__item" data-role="page-next"><a
                                    :disabled="paginate.current_page===paginate.last_page"
                                    @click="nextPage(paginate.current_page + 1)"><span
                                    class="ico ico-page-next cursor"></span></a></li>
                            </ul>
                        </nav>
                        <!--paginate-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import RadioToggle from '@com/Utils/RadioToggle.vue'
    import ItemsLoading from '@com/Utils/ItemsLoading.vue';
    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'

    export default {
        name: "Volunteering",
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
                {text: 'Current Opportunities', value: 'LIVE', count: 0},
                {text: 'Past Opportunities', value: 'CLOSED', count: 0},
                {text: 'Drafts', value: 'DRAFT', count: 0},
                {text: 'Cancelled', value: 'CANCELLED', count: 0},
            ],
            paginate: {per_page: 2, data: [], current_page: 1, last_page: 0, total: 0},
            filters: {volunteering: 'LIVE', sort: 'name'},
            isSearch: false,
            isNavigator: false,
            query: '',
            isTyped: false,
            type: 'volunteering',
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
                    item.count = n[`${item.value}_COUNT`];
                    return item;
                });
            }
        },
        computed: {
            ...mapState(['authUserInfo', 'searchesData']),
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
            ...mapMutations(['setClearValidate', 'setVolunteeringDuplicateData']),
            ...mapActions(['showErrorToast', 'showInfoToast', 'fetchSearches', 'discardVolunteeringActivityData']),
            getVolunteering(t = '') {
                if (!this.isTyped && t === 'click') {//check if user never type in search box but got click search button
                    return;
                }
                if (!this.isNavigator) {
                    this.paginate.current_page = 1;
                }
                this.isSearch = false;//set user searching to false
                //reset scroll bar position
                this.$utils.animateScrollToY('html,body', 10);
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
            duplicateData(data) {
                let duplicateData = JSON.parse(JSON.stringify(data));
                //reset data
                duplicateData.frequency = '';
                duplicateData.duration = '';
                duplicateData.days_of_week = [];
                duplicateData.start_date = '';
                duplicateData.end_date = '';
                duplicateData.deadline_sign_ups_date = '';
                //reset data
                this.setVolunteeringDuplicateData(duplicateData);
                this.Route({
                        name: 'create-activity',
                        query: {
                            active_page: 'general-info-&-permissions',
                            volunteering_id: duplicateData.id,
                            duplicate_id: duplicateData.id
                        }
                    },
                    300
                );
            },
            disCardVolunteering(data) {
                let res = confirm('Are you sure you want to discard this?')
                if (res) {
                    this.discardVolunteeringActivityData(data)
                        .then(res => {
                            if (res.success) {
                                this.toaster('The volunteer activity discarded.');
                                this.paginate.current_page = 1;//reset current page
                                this.getVolunteering();
                            } else {
                                this.toaster('Opps!, Failed to discarded.');
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        })
                }
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
            }

        },
        created() {
            if (this.visible) {
                this.getVolunteering = this.debounce(this.getVolunteering, 150);
                this.getVolunteering();
            }
        }
    }
</script>

<style scoped>

</style>
