<template>
    <div class="cWidth-1200 pt-16-custom-1024-up-0 clearfix">
        <div class="volunteer-admin__container" id="my-volunteer-activities">
            <div
                class="grid-12 grid-custom-1024-up-3 mt-0-custom-1024-up-114">


                <RadioToggle :items="filterItems" v-model="filters.role"/>

                <!--<div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">-->
                <!--<div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span-->
                <!--class="nav-acdr__title">All Members</span> <span-->
                <!--class="nav-acdr__stats live-count">1</span></div>-->
                <!--<div class="nav-acdr__body">-->

                <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
                <!--<div class="radio-filters radio-filters&#45;&#45;blk"><label-->
                <!--class="radio-filters__lbl">-->
                <!--<input type="radio" checked=""-->
                <!--name="categories"-->
                <!--class="radio-filters__radio" value="LIVE">-->
                <!--<span class="radio-filters__text-left">All Members</span>-->
                <!--<span class="radio-filters__text-right live-count">1</span>-->
                <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
                <!--</label>-->
                <!--</div>-->
                <!--</div>-->

                <!--<div class="nav-acdr__grp by-roles">-->
                <!--<div class="nav-acdr__grp-title">ROLES</div>-->

                <!--<div class="radio-filters radio-filters&#45;&#45;blk">-->
                <!--<label class="radio-filters__lbl">-->
                <!--<input type="radio" name="categories" class="radio-filters__radio">-->
                <!--<span class="radio-filters__text-left" data-no-item="You have no Volunteer Leader">Volunteer Leader</span>-->
                <!--<span class="radio-filters__text-right">0</span>-->
                <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
                <!--</label>-->
                <!--</div>-->

                <!--</div>-->

                <!--</div>-->
                <!--</div>-->

            </div>
            <div class="grid-12 grid-custom-1024-up-9-last">
                <div class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--just-spc-btw mt-40 mb-24">
                    <button style="padding: 0;"
                            class="button-ctn button--with-icon button--no-bg button--no-left-pad"></button>
                    <div class="search-result__field-right input-ctrl mb-0"><input v-model="searchName"
                                                                                   type="text"
                                                                                   class="input-ctn input--icon input--bold input--h-40"
                                                                                   placeholder="Search all users">
                        <i class="ico material-icons input-ctrl__icon">search</i>
                    </div>
                </div>

                <div id="item-list">

                    <!--Loading-->
                    <ItemsLoading v-if="validated().loading_all_volunteers"/>
                    <!--Loading-->

                    <div v-show="!validated().loading_all_volunteers" v-for="(item, idx) in allSignUpVolunteers"
                         :key="idx"
                         class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--border-grey-rounded-corners flex-ctn--just-spc-btw">
                        <div class="media-obj">
                            <div class="media-obj__asset">
                                <img class="profile-pic profile-pic--small-all"
                                     :src="`${baseUrl}/assets/images/user_profiles/96x96-${item.image}`">
                            </div>
                            <div class="media-obj__main">
                                <h4 class="h4 mt-0 body-txt font-dark-grey mb-0">{{item.user_name}}</h4>
                                <p class=" mb-0">{{item.public_email}}</p>
                                <div class="ribbon--container">
                                    <div v-if="item.leader==='yes'" class="ribbon ribbon--role">Community-based Leader
                                        Admin
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div v-for="i in 1" :key="100+ `${i}-abs`"-->
                    <!--class="flex-ctn flex-ctn&#45;&#45;dir-col-tablet-portrait-up-row flex-ctn&#45;&#45;border-grey-rounded-corners flex-ctn&#45;&#45;just-spc-btw">-->
                    <!--<div class="media-obj">-->
                    <!--<div class="media-obj__asset">-->
                    <!--<img class="profile-pic profile-pic&#45;&#45;small-all"-->
                    <!--src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg">-->
                    <!--</div>-->
                    <!--<div class="media-obj__main">-->
                    <!--<h4 class="h4 mt-0 body-txt font-dark-grey mb-0">Bee Organization</h4>-->
                    <!--<p class=" mb-0">beeostin@gmail.com</p>-->
                    <!--<div class="ribbon&#45;&#45;container">-->
                    <!--<div class="ribbon ribbon&#45;&#45;role">Community-based Group Admin</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState, mapGetters} from 'vuex'
    import RadioToggle from '@com/Utils/RadioToggle.vue'
    import ItemsLoading from '@com/Utils/ItemsLoading.vue';

    export default {
        name: "Members",
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
            // toggleRadio: false,
            paginate: {per_page: 8, data: [], current_page: 1, last_page: 0, total: 0},
            isNavigator: false,
            isSearch: false,
            isTyped: false,
            query: '',
            searchName: '',
            filters: {role: 'all'},
            filterItems: [
                {text: 'All Members', value: 'all', count: 0},
                {
                    group: {
                        name: 'ROLES',
                        items: [
                            {text: 'Volunteer Leader', value: 'leader', count: 0}
                        ]
                    }
                },
            ],
        }),
        computed: {
            ...mapState([]),
            allSignUpVolunteers() {
                let data = this.paginate.data || [];
                data = data.filter(filter => {
                    if (this.searchName !== '') {
                        return filter.user_name.indexOf(this.searchName) !== -1 ||
                            (filter.public_email || '').indexOf(this.searchName) !== -1;
                    }
                    return filter;
                });
                return data;
            }
        },
        watch: {
            visible: function (n) {
                if (n) {
                    this.getAllVolunteers();
                }
            },
            'filters.role': function (n) {
                this.paginate.current_page = 1;//reset current page
                this.getAllVolunteers();
            },
        },
        methods: {
            ...mapActions(['fetchAllVolunteers']),
            getAllVolunteers(t = '') {
                if (!this.isTyped && t === 'click') {//check if user never type in search box but got click search button
                    return;
                }
                if (!this.isNavigator) {
                    this.paginate.current_page = 1;
                }
                this.isSearch = false;//set user searching to false
                //reset scroll bar position
                this.$nextTick(() => {
                    let posY = this.$utils.findPos(this.jq('#item-list').get(0)).y;
                    this.$utils.animateScrollToY('html,body', posY - 300);
                });
                this.fetchAllVolunteers({
                    filters: this.filters,
                    q: this.query,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                }).then(res => {

                    if (!res.success) {
                        this.Route({name: 'home', query: {'active_page': 'our-volunteering'}});
                    } else {
                        this.paginate = res.data;
                        let statuses = res.statuses;
                        this.filterItems.map(item => {
                            if (item.group) {
                                item.group.items[0].count = statuses['total_leaders'];
                            } else {
                                item.count = statuses['total_volunteers'];
                            }
                        });
                    }
                }).catch(err => {

                });
            },
            paginateNavigator(p) {
                this.isNavigator = true; //set to true to tell the request this is navigator action
                this.paginate.current_page = p.pageNo; //set current page next or prev page for pagination
                this.getAllVolunteers();
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
        },
        created() {
            if (this.visible) {
                this.getAllVolunteers = this.debounce(this.getAllVolunteers, 150);
                this.getAllVolunteers();
            }
        }
    }
</script>

<style scoped>

</style>
