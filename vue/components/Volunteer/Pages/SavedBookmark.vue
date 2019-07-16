<template>
    <VolunteeringFilter ref="volunteeringFilter" @onPaginateNavigator="paginateNavigator" :options="homeData"
                        :displayType="displayType" :removeAction="true"
                        @onRemoveAction="removeSaveBookmark"
                        @onClearFilters="clearFilters()"
                        :disableFilters="disableFilters"
                        :isSearch="isSearch" :query="query"
                        :filters="filters" :paginate="paginate"/>
</template>

<script>
    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'
    import VolunteeringFilter from '@com/Utils/VolunteeringFilter.vue'

    export default {
        name: "SavedBookmark",
        components: {
            VolunteeringFilter
        },
        props: {
            visible: {
                default: false
            }
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            isFiltering: false,
            paginate: {per_page: 12, data: [], current_page: 1, last_page: 0, total: 0},
            options_request: {},
            isNavigator: false,
            isSearch: false,
            isTyped: false,
            query: '',
            type: 'saved_bookmark',
            filters: {
                causes: [],
                post_type: '',
                is_filtering: false
            },
            displayType: 'all',
            disableFilters: {
                post_type: false,
                causes: false,
                openings: true,
                skills: true,
                suitables: true,
                weekday_or_weekend: true,
                commitment_duration: true,
                frequency: true,
                date: true,
            }
        }),
        watch: {
            visible: function (n) {
                if (n) {
                    this.setFilteringGetData();
                }
            },
            '$route.query': function (n) {
                if (this.visible) {
                    this.setFilteringGetData();
                }
            },
            filters: {
                deep: true,
                handler(n, o) {
                    if (this.visible) {
                        this.setQueryString();
                    }
                }
            },
            query: function (n, o) {
                this.isTyped = true;
                if (n === '' && o !== '' && this.visible) {
                    this.getItems();
                }
            }
        },
        computed: {
            ...mapState(['homeData', 'postsData']),
        },
        methods: {
            ...mapActions(['fetchPostsData', 'postSaveBookMark']),
            ...mapMutations(['setPostsData']),
            registerWatches() {
                this.$watch(`postsData.${this.type}`, (n, o) => {
                    this.setItems(n);
                });
            },
            setItems(data) {
                //count
                let count = data.count;
                this.homeData.post_type[0].count = count.organizations_or_groups;
                this.homeData.post_type[1].count = count.volunteering;
                //paginate
                this.paginate = data.posts;
                this.isNavigator = false; //set to false to tell the request this is not navigator action
                //check if user search or not
                if (this.query !== '') {
                    this.isSearch = true;
                }
                this.isTyped = false;
            },
            getItems(t = '') {
                if (!this.isTyped && t === 'click') {//check if user never type in search box but got click search button
                    return;
                }
                //check if should reset current page when user have search not navigate data
                if (!this.isNavigator) {
                    this.paginate.current_page = 1;
                }
                this.isSearch = false;//set user searching to false
                //reset scroll bar position
                if (t !== 'no-scroll')
                    this.$utils.animateScrollToY('html,body', 10);
                this.fetchPostsData({
                    options: this.options_request,
                    type: this.type,
                    q: this.query,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                });
            },
            setQueryString() {
                //please clone the queries for editable queries working
                let q = JSON.parse(JSON.stringify(this.$route.query));
                //query
                q.q = this.query;
                //post type
                q.post_type = this.filters.post_type;
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
            setFilteringGetData() {
                let q = this.$route.query;
                //tab
                this.query = q.q || '';
                //cause
                this.filters.causes = q.causes ? q.causes.split(',') : [];
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
                    post_type: [],
                    causes: [],
                    openings: [],
                    skills: [],
                    suitables: [],
                    weekday_or_weekend: [],
                    commitment_duration: [],
                    frequency: [],
                    date: 'all_date',
                    is_filtering: false
                };
            },
            paginateNavigator(p) {
                this.isNavigator = true; //set to true to tell the request this is navigator action
                this.paginate.current_page = p.pageNo; //set current page next or prev page for pagination
                this.getItems();
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
            removeSaveBookmark(item) {
                let post_id = 0;
                if (item.post_type === 'organize') {
                    post_id = item.user_id;
                } else {
                    post_id = item.activity_id;
                }
                this.postSaveBookMark({post_id, checked: item.removed, type: item.post_type})
                    .then(res => {
                        if (res.success) {
                            item.removed = !item.removed;
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },
        created() {
            this.registerWatches();
            this.getItems = this.debounce(this.getItems, 150);
            if (this.visible) {
                this.setFilteringGetData();
            }
        }
    }
</script>

<style scoped>

</style>
