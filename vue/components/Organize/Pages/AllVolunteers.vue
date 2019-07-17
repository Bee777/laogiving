<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="page-top pt-40">
                <div class="cWidth-1200">
                    <button @click="Route({name: 'home', query: {active_page: 'our-volunteering' } })"
                            class="button-ctn font-bold button--with-icon button--no-bg button--large button--no-left-pad back-button">
                        <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                            class="ico material-icons button--with-icon__icon">keyboard_backspace</i> BACK
                        </div>
                    </button>
                    <h2 class="h3-tablet-landscape-up-h2 mt-24"><span class="mr-8">View All Volunteers</span></h2>
                    <div class="flex-ctn flex-ctn--dir-col-custom-768-up-row flex-ctn--just-spc-btw">
                        <div>
                            <div class="media-obj">
                                <div class="media-obj__main media-obj__main--small-spacing"></div>
                            </div>
                        </div>
                        <div class="mt-16-custom-768-up-0"></div>
                    </div>
                </div>

                <div class="cWidth-1200 company-profile__nav">
                    <nav class="hori-scroll-nav"></nav>
                </div>

            </section>

            <div class="ctn" id="manage-volunteer-contact">
                <div class="cWidth-1200 pt-40">
                    <div
                        class="flex-ctn flex-ctn--just-spc-btw flex-ctn--tablet-portrait-up-align-center flex-ctn--dir-col-tablet-portrait-up-row">
                        <div class="dbl-stats">
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats">{{statuses.total_volunteers}}</div>
                                <div class="dbl-stats__desc">Volunteer Total</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats">{{statuses.total_leaders}}</div>
                                <div class="dbl-stats__desc">Leaders</div>
                            </div>
                        </div>
                        <form class="activity" @submit.prevent>
                            <button @click="downloadExcelFile()" class="button-ctn mt-16-tablet-portrait-down"> Export
                                All
                            </button>
                        </form>
                    </div>
                    <hr class="hr">

                    <div class="flex-ctn flex-ctn--just-end flex-ctn--dir-col-rev-tablet-portrait-up-row">
                        <div class="flex-ctn flex-ctn--align-center" style="justify-content: flex-end;">
                            <div
                                class="select-btn select-btn--w-auto mr-0-tablet-portrait-up-16 mt-16-tablet-portrait-up-0">
                                <label class="mb-0 select-btn__lbl no-mrt"
                                       style="display: inline-block;width: auto;">
                                    <span class="select-btn__lbl-lbl mr-8 font-mid-grey body-txt">Sorted By</span>
                                </label>
                                <select v-model="sortBy" name="" class="select-ctn select-btn__select select--small">
                                    <option data-order="asc" data-path=".volunteer-username" data-type="text"
                                            value="nameAsc">
                                        Name Asc
                                    </option>
                                    <option data-order="desc" data-path=".volunteer-username" data-type="text"
                                            value="nameDesc">
                                        Name Desc
                                    </option>
                                    <option data-order="asc" data-path=".volunteer-activities-no" data-type="number"
                                            value="numberAsc">No. Activities Asc
                                    </option>
                                    <option data-order="desc" data-path=".volunteer-activities-no" data-type="number"
                                            value="numberDesc">No. Activities Desc
                                    </option>
                                </select></div>
                        </div>
                        <div class="input-ctrl mb-0 w-211 ">
                            <input v-model="searchName" type="text" class="input-ctn input--h-36 input--icon"
                                   placeholder="Search volunteer name"> <i
                            class="ico material-icons input-ctrl__icon">search</i></div>
                    </div>

                    <table class="table-ctn res-tbl mt-16 volunteer-contact-list">
                        <thead>
                        <tr>
                            <th class="dark-grey">Name</th>
                            <th class="dark-grey">Contact</th>
                            <th class="dark-grey">No. of Activities</th>
                        </tr>
                        </thead>

                        <tbody> <!-- Start of for loop -->
                        <tr v-for="(item, idx) in allSignUpVolunteers"
                            class="volunteer-contact-list-item data-list-item" style="display: table-row;" :key="idx">
                            <th>
                                <div class="media-obj">
                                    <div>
                                        <div class="body-txt volunteer-username name">{{item.user_name}}</div>
                                        <span class="nric-name">{{$utils.firstUpper(item.salutation)}}</span></div>
                                </div>
                            </th>
                            <td>
                                <div class="media-obj">
                                    <div class="body-txt">{{item.phone_number}}</div>
                                </div>
                                <span class="block"><a href="javascript: void(0);" class="text-link text-link--blue">{{item.public_email}}</a></span>
                            </td>
                            <td>
                                <div><span class="block p-top12"><strong
                                    class="number-of-activities volunteer-activities-no">{{item.activities_count}}</strong> activity</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                    <div><p class="text-align-left-on-mobile mt-16">{{paginate.current_page}}-{{paginate.last_page}} OF
                        {{paginate.total}} VOLUNTEER</p>

                        <nav
                            class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative">
                            <ul class="pagi mt-16-tablet-portrait-up-0">
                                <li class="pagi__item"><a class="cursor" :disabled="paginate.current_page===1"
                                                          @click="prevPage(paginate.current_page - 1)"><span
                                    class="ico ico-page-prev"></span></a></li>
                                <li :key="idx" v-for="(p, idx) in paginate.last_page"
                                    :class="[{'is-active': p===paginate.current_page}]"
                                    class="pagi__item"><a href=""
                                                          @click.prevent="paginateNavigator({pageNo: p})">{{p}}</a>
                                </li>
                                <li class="pagi__item"><a class="cursor"
                                                          :disabled="paginate.current_page===paginate.last_page"
                                                          @click="nextPage(paginate.current_page + 1)"><span
                                    class="ico ico-page-next"></span></a></li>
                            </ul>
                        </nav>

                    </div>

                </div>
            </div>


        </main>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/OrganizeBase.js";
    import {mapActions} from 'vuex'

    export default Base.extend({
        name: "AllVolunteers",
        data: () => ({
            sortBy: 'nameAsc',
            searchName: '',
            statuses: {
                total_volunteers: 0,
                total_leaders: 0,
            }
        }),
        computed: {
            allSignUpVolunteers() {
                let data = this.paginate.data || [];
                let sort = this.sortBy;
                if (sort === 'nameAsc') {
                    data.sort((a, b) => {
                        return b.user_name.localeCompare(a.user_name);
                    });
                } else if (sort === 'nameDesc') {
                    data.sort((a, b) => {
                        return a.user_name.localeCompare(b.user_name);
                    });

                } else if (sort === 'numberAsc') {
                    data.sort((a, b) => {
                        return a.id - b.id;
                    });
                } else if (sort === 'numberDesc') {
                    data.sort((a, b) => {
                        return b.id - a.id;
                    });
                }

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
        watch: {},
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
                if (t !== 'no-loading') {
                    this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                } else {
                    this.$utils.animateScrollToY('html,body', 10);
                }
                this.fetchAllVolunteers({
                    filters: this.filters,
                    q: this.query,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                }).then(res => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                    if (!res.success) {
                        this.Route({name: 'home', query: {'active_page': 'our-volunteering'}});
                    } else {
                        this.paginate = res.data;
                        this.statuses = res.statuses;
                    }
                }).catch(err => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
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
            downloadExcelFile() {
                this.downloadExportFile({
                    type_user: 'organize',
                    type: 'excel',
                    export_type: 'all-sign-up-volunteers'
                });
            }
        },
        mounted() {
        },
        created() {
            this.setPageTitle(`All Volunteers`);
            this.getAllVolunteers = this.debounce(this.getAllVolunteers, 150);
            this.getAllVolunteers();
        }
    });
</script>


