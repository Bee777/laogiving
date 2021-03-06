import Vue from 'vue'
import {mapActions, mapGetters, mapMutations, mapState} from 'vuex'

export default Vue.extend({
    components: {},
    data() {
        return {
            ...mapGetters(['validated', 'succeeded', 'getSideBarWidthForTabs', 'LoggedIn']),
            type: 'news',
            paginate: {per_page: 6, data: [], current_page: 1, last_page: 0, total: 0},
            isNavigator: false,
            isSearch: false,
            isTyped: false,
            query: '',
            filters: {},
            singleId: -1,
            options_request: {},
        }
    },
    computed: {
        ...mapState(['isMobile', 'authUserInfo', 'validate_errors', 'postsData', 'singlePostsData', 'homeData', 'searchQuery']),
    },
    watch: {
        query: function (n, o) {
            this.isTyped = true;
            if (n === '' && o !== '') {
                this.getItems();
            }
        }
    },
    methods: {
        ...mapMutations([]),
        ...mapActions(['setPageTitle', 'fetchHomeData', 'fetchPostsData', 'fetchSinglePostsData', 'postSaveBookMark']),
        /***@Posts */
        getDetail(type, data) {
            this.Route({name: `${type}-single`, params: {id: data.id}});
        },
        getPosts(name) {
            this.Route({name});
        },
        registerWatches() {
            this.$watch(`postsData.${this.type}`, (n, o) => {
                this.setItems(n);
            });
            this.$watch(`singlePostsData.${this.type}`, (n, o) => {
                this.setItem(n);
            });
        },
        isNotFound() {
            return this.paginate.data.length <= 0 && this.isSearch;
        },
        setItems(data) {
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
                type: this.type, q: this.query,
                limit: this.paginate.per_page, page: this.paginate.current_page
            });
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
        getCalendarDate(date) {
            let d = this.$utils.getDateTime(date);
            return `<span>${d.days}</span><span>${d.months} ${d.years}</span>`;
        },
        shouldLoading(type) {
            return this.validated().loading_search_posts && !this.postsData[type].posts.data
                || this.validated().loading_search_posts && this.isTyped;
        },
        /***@Posts */
        /***@SinglePost*/
        setItem(data) {
        },
        shouldLoadingSingle(type) {
            return this.validated().loading_single_posts && !this.singlePostsData[type].data.id
                || this.validated().loading_single_posts && this.singlePostsData[type].data.id !== this.$utils.toInt(this.singleId)
        },
        shouldShowSingle(type) {
            return !this.$utils.isEmptyObject(this.singlePostsData[type].data);
        },
        sharer(w, type, data, link) {
            let res = this.baseUrl;
            switch (w) {
                case 'fb': {
                    res = `https://www.facebook.com/sharer/sharer.php?u=${link}`;
                    break;
                }
                case 'twitter': {
                    res = `https://twitter.com/share?url=${link}&amp;text=${this.$utils.sub(this.$utils.strip(data.title), 120)}, ${type} - ${this.s['site_name']}&amp;hashtags=${this.s['site_name']}`;
                    break;
                }
            }
            return res;
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
        getTotalVacancies(item) {
            let total_vacancies = 0;
            let suitablesTexts = [];
            item.positions.map(i => {
                total_vacancies += parseInt(i.vacancies) || 0;
                i.position_suitables.map(suitable => {
                    let mSuitable = this.homeData.all_suitables.filter((filter) => {
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
        //Toaster
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
        //Toaster
        /***@SinglePost*/
    },
    created() {
        this.getItems = this.debounce(this.getItems, 150);
    }
});

