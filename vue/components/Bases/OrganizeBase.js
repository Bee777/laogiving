import Vue from 'vue'
import {mapActions, mapGetters, mapMutations, mapState} from 'vuex'

export default Vue.extend({
    components: {},
    data() {
        return {
            ...mapGetters(['validated', 'succeeded', 'getSideBarWidthForTabs']),
            type: 'news',
            paginate: {per_page: 8, data: [], current_page: 1, last_page: 0, total: 0},
            isNavigator: false,
            isSearch: false,
            isTyped: false,
            query: '',
            filters: {},
            singleId: -1,
        }
    },
    computed: {
        ...mapState(['isMobile', 'postsData', 'singlePostsData', 'authUserInfo', 'dashboardData', 'searchQuery', 'userProfile']),
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
        ...mapActions(['setPageTitle', 'fetchHomeData', 'fetchPostsData', 'fetchSinglePostsData', 'postAutoUserLogin']),
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
            this.$utils.animateScrollToY('html,body', t === 'no-scroll' ? 0 : 10);
            this.fetchPostsData({
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
        /***@SinglePost*/
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
        },
        //Toaster
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
        getTotalVacancies(item) {
            let total_vacancies = 0;
            (item.positions || []).map(i => {
                total_vacancies += parseInt(i.vacancies) || 0;
            });
            return total_vacancies;
        },
        getVolunteersStatus(data) {

            let confirm = 0, confirm_checkin = 0;
            let pending = 0, leader = 0, leader_checkin = 0;
            let confirm_users = [];
            let total_vacancies = 0;
            let positionsData = data && data.positions || [];

            positionsData.map(pos => {
                total_vacancies += pos.vacancies;
                confirm += pos.active_opportunity || 0;
                pending += pos.total_pending || 0;
                confirm_users = [...confirm_users, ...pos.confirm_users];
                (pos.confirm_users || []).map((user) => {
                    if (user.leader === 'yes') {
                        leader += 1;
                    }
                    if (user.status === 'checkin') {
                        if (user.leader === 'yes') {
                            leader_checkin += 1;
                        }
                        confirm_checkin += 1;
                    }
                })
            });
            return {
                leader: leader,
                leader_checkin: leader_checkin,
                confirm_checkin: confirm_checkin,
                confirm: confirm,
                pending: pending,
                confirm_users: confirm_users,
                total_vacancies: total_vacancies,
                positions: positionsData,
            };
        },
        getVolunteeringSelectedPosition(pos_id, item) {
            return (item.positions || []).filter(pos => {
                return pos.id === pos_id;
            }).shift() || {};
        },
        downloadExportFile(data) {
            this.postAutoUserLogin()
                .then(res => {
                    if (res.success) {
                        let req = `?redirect_url=${encodeURIComponent(`/${data.type_user}/me/download/${data.type}?export_type=${data.export_type}`)}`;
                        let url = res.data + req;
                        this.$utils.downloadURL(url, 'frame-download')
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        }
    },
    created() {
        this.getItems = this.debounce(this.getItems, 150);
    }
});

