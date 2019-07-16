<template>
    <div>
        <main class="laogiving activity pad clearfix" v-if="isFiltering">
            <section class="company-profile__head">
                <div class="cWidth-1200 company-profile__head-title-logo">

                    <div class="search-result__field">
                        <div class="search-result__field-left"><h3
                            class="h3 h3--no-bold nowrap tp-search-result__search-lbl">Search results for</h3></div>
                        <div class="search-result__field-right input-ctrl">
                            <input v-model="query" type="text"
                                   @keyup.enter="triggerButton()"
                                   class="input-ctn input--icon input--bold"
                                   placeholder="Search campaigns, organisations, groups and causes"
                                   name="search_term"
                                   id="search_term" value=""><span
                            class="ico ico-search-black input-ctrl__icon no-top"></span>
                            <input ref="search-button" v-show="false" value="Search"
                                   class="search-submit btn btn-default">
                        </div>
                    </div>
                </div>

                <div class="cWidth-1200" id="search-text-error">
                    <label class="error-msg" style="margin-left: 240px;">Please
                        enter alphabets, numbers or these characters only '.,*;:_!/@&amp;#()-</label>
                </div>

                <!--Tabs-->
                <div class="cWidth-1200 company-profile__nav clearfix">
                    <nav class="hori-scroll-nav">
                        <ul class="hori-scroll-nav__list tabs list">

                            <!--<li><a-->
                            <!--@click="tab=0"-->
                            <!--:class="[{' is-active': tab===0}]"-->
                            <!--class="cursor text-link text-link&#45;&#45;no-underline text-link&#45;&#45;black tabs__a  ">-->
                            <!--All Results (<span id="allAmount">{{total_result_count}}</span>)</a></li>-->

                            <li><a @click="tab=0"
                                   :class="[{' is-active': tab===0}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Volunteer
                                (<span id="volunteerAmount">{{postsData.activities.total_count || 0 }}</span>)</a>
                            </li>
                            <li><a @click="tab=1"
                                   :class="[{' is-active': tab===1}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Organisations
                                (<span
                                    id="orgAmount">{{ postsData.activities.total_count_organization || 0 }}</span>)</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!--Tabs-->
            </section>
        </main>
        <VolunteeringFilter ref="volunteeringFilter" @onPaginateNavigator="paginateNavigator" :options="homeData"
                            :displayType="filters.type"
                            @onClearFilters="clearFilters()" :isSearch="isSearch" :query="query"
                            :filters="filters" :paginate="paginate"/>
    </div>
</template>


<script>

    import Base from '@com/Bases/GeneralBase.js'
    import VolunteeringFilter from '@com/Utils/VolunteeringFilter.vue'

    export default Base.extend({
        components: {
            VolunteeringFilter
        },
        data: () => ({
            type: 'activities',
            tab: 0,
            isFiltering: false,
            filters: {
                causes: [],
                openings: [],
                skills: [],
                suitables: [],
                weekday_or_weekend: [],
                commitment_duration: [],
                frequency: [],
                date: 'all_date',
                type: '',
                is_filtering: false
            },
            displayType: 'volunteer',
        }),
        watch: {
            '$route.query': function (n) {
                this.setFilteringGetData();
            },
            'validate_errors.loading_search_posts': function (n) {
                //please clone the queries for editable queries working
                if (n) {
                    this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                } else {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                }
            },
            filters: {
                deep: true,
                handler(n, o) {
                    this.setQueryString();
                }
            },
            tab: function (n) {
                //reset by tab
                this.paginate.data = [];
                this.isSearch = false;
                //reset by tab
                if (n === 0) {
                    this.filters.type = 'volunteer';
                } else if (n === 1) {
                    this.filters.type = 'organize';
                } else {
                    this.filters.type = '';
                }
            }
        },
        methods: {
            setItems(data) {
                if (this.tab === 1 && data.organizations) {
                    this.paginate = data.organizations;
                } else {
                    this.paginate = data.posts;
                }
                this.isNavigator = false; //set to false to tell the request this is not navigator action
                //check if user search or not
                if (this.query !== '') {
                    this.isSearch = true;
                }
                this.isTyped = false;
            },
            setQueryString() {
                //please clone the queries for editable queries working
                let q = JSON.parse(JSON.stringify(this.$route.query));
                //type
                q.type = this.filters.type;
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
                q.weekday_or_weekend = this.filters.weekday_or_weekend.join(',');
                q.commitment_duration = this.filters.commitment_duration.join(',');
                q.frequency = this.filters.frequency.join(',');

                q.date = this.filters.date;
                //set query
                this.$router.replace({path: this.$route.path, query: q});
            },
            setFilteringGetData(firstLoad = false) {
                let q = this.$route.query;
                //set active tab
                if (q.type === '' || q.type === 'volunteer') {
                    this.tab = 0;
                } else {
                    this.tab = 1;
                }
                //tab
                this.isFiltering = (q.type === '' || q.type !== 'volunteer' || q.search === 'yes');
                //is filtering search non volunteer
                this.filters.is_filtering = this.isFiltering;
                this.query = q.q || '';
                //type
                this.filters.type = q.type || '';
                //cause
                this.filters.causes = q.causes ? q.causes.split(',') : [];
                if (!q.causes && firstLoad && !this.$utils.getCookie('clearUserCauses')) {
                    this.filters.causes = this.homeData.user_causes.map(d => {
                        return d.cause_id;
                    });
                }
                //skills
                this.filters.skills = q.skills ? q.skills.split(',') : [];
                //suitables
                this.filters.suitables = q.suitables ? q.suitables.split(',') : [];
                //openings
                this.filters.openings = q.openings ? q.openings.split(',') : [];
                this.filters.weekday_or_weekend = q.weekday_or_weekend ? q.weekday_or_weekend.split(',') : [];
                this.filters.commitment_duration = q.commitment_duration ? q.commitment_duration.split(',') : [];
                this.filters.frequency = q.frequency ? q.frequency.split(',') : [];
                //date
                this.filters.date = q.date || 'all_date';
                //set filters
                this.options_request = this.filters;
                this.paginate.per_page = 12;
                //get data
                this.getItems('no-scroll');
            },
            clearFilters() {
                this.filters = {
                    causes: [],
                    openings: [],
                    skills: [],
                    suitables: [],
                    weekday_or_weekend: [],
                    commitment_duration: [],
                    frequency: [],
                    date: 'all_date',
                    type: this.filters.type,
                    is_filtering: false
                };
                if (this.homeData.user_causes.length > 0) {
                    this.$utils.setCookie('clearUserCauses', true, 600)
                }
            },
            triggerButton() {
                this.setQueryString();
                this.$utils.hideKeyboard(this.$refs['search-button']);
            }
        },
        created() {
            this.registerWatches();
            this.setPageTitle('Activities');
            this.setFilteringGetData(true);
        }
    });
</script>

<style scoped>

</style>
