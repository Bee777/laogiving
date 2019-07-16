<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="company-profile__head">
                <div class="cWidth-1200 company-profile__head-title-logo object-fit">
                    <div class="company-profile__logo company-profile__logo--profile ">
                        <img :alt="authUserInfo.name" :src="`${baseUrl}${authUserInfo.image}`"></div>
                    <div class="company-profile__title-views-ctn"><h2 class="h2">{{authUserInfo.name}}</h2>
                        <div
                            class="font-dark-grey mt-16 body-txt--small flex flex-ctn--dir-col-tablet-landscape-up-row">
                            <div class="mr-0-tablet-landscape-up-24">
                                <span class="company-profile__views">{{userProfile.public_email||
                        authUserInfo.email}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Tabs-->
                <div class="cWidth-1200 company-profile__nav clearfix">
                    <nav class="hori-scroll-nav">
                        <ul class="hori-scroll-nav__list tabs list">
                            <li><a
                                @click="setRouteTab('dashboard')"
                                :class="[{' is-active': tab===0}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">Dashboard</a>
                            </li>
                            <li><a
                                @click="setRouteTab('activities')"
                                :class="[{' is-active': tab===1}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">My Volunteer
                                Activities</a>
                            </li>
                            <li><a @click="setRouteTab('saved')"
                                   :class="[{' is-active': tab===2}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Saved</a>
                            </li>
                            <li><a @click="setRouteTab('account')"
                                   :class="[{' is-active': tab===3}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Account</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <!--Tabs-->
            </section>

            <!--Tabs Content-->
            <!--Dashboard-->

            <div class="cWidth-1200 mb-40 plr-16neg" v-show="tab===0">
                <div
                    class="flex flex-ctn--just-spc-btw flex-ctn--align-center flex-ctn--dir-col-custom-1024-up-row mt-40">
                    <span class="body-txt body-txt--small font-mid-grey body-txt--italic mb-16-custom-1024-up-0">Updated as of {{dashboardData.updated_at}}</span>
                    <div class="month-range">
                        <span class="month-range__title">Showing data for</span>
                        <select v-model="volunteering.filter" class="select-ctn select--small"
                                :class="[{'is-hidden': volunteering.filter==='customMonth'}]">
                            <option selected="selected" value="this1Month">This month</option>
                            <option value="past1Month">Past 1 month</option>
                            <option value="past3Month">Past 3 months</option>
                            <option value="past6Month">Past 6 months</option>
                            <option value="customMonth">Custom</option>
                        </select>
                        <div class="month-range__body " :class="[{'is-hidden': volunteering.filter !== 'customMonth'}]">
                            <!-- is-hidden-->
                            <div class="month-range__item">
                                <select
                                    v-model="volunteering.from.monthFilter"
                                    class="month-range__month select-ctn select--small select--font-small">
                                    <option value="0">Jan</option>
                                    <option value="1">Feb</option>
                                    <option value="2">Mar</option>
                                    <option value="3">Apr</option>
                                    <option value="4">May</option>
                                    <option value="5">Jun</option>
                                    <option value="6">July</option>
                                    <option value="7">Aug</option>
                                    <option value="8">Sept</option>
                                    <option value="9">Oct</option>
                                    <option value="10">Nov</option>
                                    <option value="11">Dec</option>
                                </select>
                                <select v-model="volunteering.from.yearFilter"
                                        class="month-range__year select-ctn select--small select--font-small">
                                    <option :key="idx" :value="i" v-for="(i, idx) in buildYears()">{{i}}</option>
                                </select>
                            </div>
                            <div class="month-range__to">to</div>
                            <div class="month-range__item">
                                <select
                                    v-model="volunteering.to.monthFilter"
                                    class="month-range__month select-ctn select--small select--font-small">
                                    <option value="0">Jan</option>
                                    <option value="1">Feb</option>
                                    <option value="2">Mar</option>
                                    <option value="3">Apr</option>
                                    <option value="4">May</option>
                                    <option value="5">Jun</option>
                                    <option value="6">July</option>
                                    <option value="7">Aug</option>
                                    <option value="8">Sept</option>
                                    <option value="9">Oct</option>
                                    <option value="10">Nov</option>
                                    <option value="11">Dec</option>
                                </select>
                                <select v-model="volunteering.to.yearFilter"
                                        class="month-range__year select-ctn select--small select--font-small">
                                    <option :key="idx" :value="i" v-for="(i, idx) in buildYears()">{{i}}</option>
                                </select>
                            </div>
                            <div class="month-range__btns">
                                <button @click="fetchDashboardData({filters: volunteering})" class="button-ctn mr-16">
                                    {{validated().loading_dashboard_data ? 'UPDATING': 'UPDATE'}}
                                </button>
                                <button @click="volunteering.filter='this1Month'"
                                        class="button-ctn button--ghost cancel">CANCEL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="validated().custom_date_range" class="error-msg pt-8 month-range">Oops! You need to select a
                    valid custom date range.
                </div>
                <div class="data-ctn mb-40 mlr-16neg no-after no-before">
                    <div class="data-ctn__card" data-role="immersive-ctn__card">
                        <div class="data-ctn__title">Hours Volunteered</div>
                        <div class="data-ctn__details">
                            <div class="data-ctn__amount uf_volunteerHours">
                                {{$utils.numSpace(dashboardData.volunteering_hours)}}
                            </div>
                            <div class="dark-grey">hours across
                                <strong>{{dashboardData.volunteer_opportunities}}</strong> opportunity
                            </div>
                            <div class="mt-16 mb-16">Find out which causes you have given your time to.</div>
                            <i class="data-ctn__card-icon ico ico--large ico-volunteering-db"></i>
                            <div class="data-ctn__cta">
                                <button @click="$utils.Location('/posts/activities')" class="button-ctn button--ghost">
                                    VOLUNTEER NOW
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--EndDashboard-->
            <!--Volunteering-->
            <div class="ctn" v-show="tab===1">
                <MyVolunteering :visible="tab===1"/>
            </div>
            <!--EndVolunteering-->
            <!--Saved Activities-->
            <SavedBookmark v-show="tab===2" :visible="tab===2"/>
            <!--Saved EndActivities-->
            <!--Account-->
            <div class="ctn" v-show="tab===3">
                <Account :visible="tab===3"/>
            </div>
            <!--EndAccount-->
            <!--Tabs Content-->

        </main>
    </div>
</template>

<style>
</style>
<script>

    import Base from "@com/Bases/VolunteerBase.js";
    import {mapActions} from 'vuex'
    import Account from '@com/Volunteer/Pages/Account.vue'
    import MyVolunteering from '@com/Volunteer/Pages/MyVolunteering.vue'
    import SavedBookmark from '@com/Volunteer/Pages/SavedBookmark.vue'

    export default Base.extend({
        name: "Home",
        components: {
            Account,
            MyVolunteering,
            SavedBookmark
        },
        data: () => ({
            tab: 0,
            tabs: {dashboard: 0, activities: 1, saved: 2, account: 3},
            minYear: 2015,
            volunteering: {
                filter: 'this1Month',
                from: {monthFilter: 0, yearFilter: new Date().getFullYear()},
                to: {monthFilter: 0, yearFilter: new Date().getFullYear()},
            },
        }),
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            },
            'volunteering.filter': {
                deep: true,
                handler(n) {
                    if (n !== 'customMonth') {
                        this.fetchDashboardData({filters: this.volunteering});
                    }
                }
            }
        },
        methods: {
            ...mapActions(['fetchDashboardData']),
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                    this.$utils.setWindowTitle(`${this.$utils.firstUpper(tab)} | ${this.s.site_name}`);
                }
            },
            setRouteTab(n) {
                this.Route({name: 'home', query: {active_page: n}});
            },
            buildYears() {
                let data = [];
                for (let i = this.minYear; i <= new Date().getFullYear(); i++) {
                    data.push(i)
                }
                return data;
            }
        },
        mounted() {

        },
        created() {
            this.setPageTitle(`Dashboard`);
            this.fetchDashboardData({filters: this.volunteering});
            this.setTab();
        }
    });
</script>


