<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="company-profile__head">
                <div class="cWidth-1200 company-profile__head-title-logo object-fit">
                    <div class="company-profile__logo">
                        <img :alt="authUserInfo.name" :src="`${baseUrl}${authUserInfo.image}`">
                    </div>
                    <div class="company-profile__title-views-ctn"><h2 class="h2">{{authUserInfo.name}}</h2>
                        <div
                            class="font-dark-grey mt-16 body-txt--small flex flex-ctn--dir-col-tablet-landscape-up-row">
                            <div class="mr-0-tablet-landscape-up-24">
                                <span class="company-profile__views">{{userProfile.view_count || 0}} views </span>

                                <div class="social-list mt-8">
                                    <a v-if="userProfile.website_in_our_site"
                                       class="button-ctn button--icon button--ghost"
                                       target="_blank"
                                       :href="`https://www.facebook.com/sharer/sharer.php?u=${userProfile.website_in_our_site}`"
                                       title="Facebook"> <i class="material-icons button--icon__icon">share</i>
                                        <span class="button--icon__name">SHARE</span>
                                    </a>
                                    <a v-else
                                       disabled=""
                                       class="button-ctn button--icon button--ghost"
                                       title="Facebook"> <i class="material-icons button--icon__icon">share</i>
                                        <span class="button--icon__name">SHARE</span>
                                    </a>
                                    <!--<label class="btn-checkbox-btn btn-checkbox-btn&#45;&#45;save ">-->
                                    <!--<input type="checkbox" name="saving-bookmark">-->
                                    <!--<span class="button-ctn button&#45;&#45;icon button&#45;&#45;ghost">-->
                                    <!--<i class="material-icons ico-save button&#45;&#45;icon__icon">bookmark_border</i>-->
                                    <!--<span class="button&#45;&#45;icon__name">SAVE</span>-->
                                    <!--</span>-->
                                    <!--</label>-->
                                    <a v-if="userProfile.website_in_our_site"
                                       @click="copyToClipboard({text: userProfile.website_in_our_site})"
                                       class="button-ctn button--icon button--ghost "
                                       title="Link copy to clipboard"> <i
                                        class="material-icons button--icon__icon">link</i>
                                        <span class="button--icon__name">LINK</span>
                                    </a>
                                    <a v-else
                                       disabled
                                       class="button-ctn button--icon button--ghost "
                                       title="Link copy to clipboard"> <i
                                        class="material-icons button--icon__icon">link</i>
                                        <span class="button--icon__name">LINK</span>
                                    </a>
                                </div>

                            </div>
                            <div class="mt-24-tablet-landscape-up-0">
                                <div class="mb-8 company-profile__info ios-switch__on-content is-visible">
                                    <em>Your organisation profile is set to be visible to public but your organisation
                                        is not live yet</em>
                                </div>
                                <div class="mb-8 company-profile__info ios-switch__off-content ">
                                    <em>Your organisation profile is not visible to public</em>
                                </div>
                                <div
                                    class="flex-ctn flex-ctn--align-center flex-ctn--stack-res flex-ctn--just-center flex-ctn--just-start-tablet-landscape-up">
                                    <div class="company-profile__switch">
                                        <label class="ios-switch">
                                            <input
                                                @change="changeUserVisibility()"
                                                type="checkbox" id="chkIsOrgPrivate"
                                                name="visibility"
                                                v-model="userProfile.visibility"
                                                class="js-ios-switch__checkbox ios-switch__checkbox">
                                            <span class="ios-switch__off">PRIVATE</span>
                                            <div class="ios-switch__base"></div>
                                            <span class="ios-switch__on">PUBLIC</span> </label></div>
                                </div>

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
                                @click="setRouteTab('our-volunteering')"
                                :class="[{' is-active': tab===1}]"
                                class="cursor text-link text-link--no-underline text-link--black tabs__a  ">Our
                                Volunteering</a>
                            </li>
                            <li><a @click="setRouteTab('members')"
                                   :class="[{' is-active': tab===2}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Members</a>
                            </li>

                            <li><a @click="setRouteTab('saved')"
                                   :class="[{' is-active': tab===3}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Saved</a>
                            </li>

                            <li><a @click="setRouteTab('profile')"
                                   :class="[{' is-active': tab===4}]"
                                   class="cursor text-link text-link--no-underline text-link--black tabs__a home ">Profile</a>
                            </li>
                            <li><a @click="setRouteTab('account')"
                                   :class="[{' is-active': tab===5}]"
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
                                <select v-model="volunteering.from.monthFilter"
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
                                    <!--<option value="2019">2019</option>-->
                                    <!--<option value="2018">2018</option>-->
                                    <!--<option value="2017">2017</option>-->
                                    <!--<option value="2016">2016</option>-->
                                    <!--<option value="2015">2015</option>-->
                                </select>
                            </div>
                            <div class="month-range__to">to</div>
                            <div class="month-range__item">
                                <select v-model="volunteering.to.monthFilter"
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
                <div class="data-ctn mb-40 mlr-16neg">
                    <div class="data-ctn__card">
                        <div class="data-ctn__title">Volunteer Opportunities</div>
                        <div class="data-ctn__details">
                            <div class="data-ctn__amount uf_volunteerHours">{{dashboardData.volunteer_opportunities}}
                            </div>
                            <div class="dark-grey">volunteer opportunities</div>
                            <div class="mt-16 mb-16">Find out how many opportunities have been created and how many
                                hours will be raised.
                            </div>
                            <i class="data-ctn__card-icon ico ico--large ico-clock-db"></i>
                            <div class="data-ctn__cta">
                                <button @click="Route({name: 'create-activity'})" class="button-ctn button--ghost">
                                    CREATE AN ACTIVITY
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="data-ctn__card">
                        <div class="data-ctn__title">My Volunteers</div>
                        <div class="data-ctn__details">
                            <div class="data-ctn__amount uf_volunteerHours">{{dashboardData.volunteers}}</div>
                            <div class="dark-grey">volunteer(s)</div>
                            <div class="mt-16 mb-16">Find out how active your individual volunteers are.</div>
                            <i class="data-ctn__card-icon ico ico--large ico-volunteering-db"></i>
                            <div class="data-ctn__cta">
                                <button @click="Route({name: 'home', query: {'active_page': 'members'}})"
                                        class="button-ctn button--ghost">
                                    VIEW MEMBERS
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!--EndDashboard-->
            <!--Volunteering-->
            <!---->
            <Volunteering v-show="tab===1" :visible="tab===1"/>
            <!--EndVolunteering-->
            <!--Members-->
            <Members v-show="tab===2" :visible="tab===2"/>
            <!--EndMembers-->
            <!--Saved Activities-->
            <SavedBookmark v-show="tab===3" :visible="tab===3" />
            <!--Saved EndActivities-->
            <!--OrganizeProfile-->
            <div v-show="tab===4">
                <OrganizeProfile :visible="tab===4" @editProfileClicked="()=> { setRouteProfile('true') }"
                                 v-if="!isEditProfile"/>
                <EditOrganizeProfile @cancelEditProfile="()=> {setRouteProfile(''); $utils.scrollToY('html,body', 2); }"
                                     v-if="isEditProfile"/>
            </div>
            <!--ENDOrganizeProfile-->
            <!--Account-->
            <div class="ctn" v-show="tab===5">
                <Account :visible="tab===5"/>
            </div>
            <!--EndAccount-->
            <!--Tabs Content-->

        </main>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/OrganizeBase.js";
    import Volunteering from '@com/Organize/Default/Includes/Volunteering.vue'
    import Members from "@com/Organize/Default/Includes/Members.vue"
    import OrganizeProfile from "@com/Organize/Default/Includes/OrganizeProfile.vue"
    import EditOrganizeProfile from '@com/Organize/Default/Includes/EditOrganizeProfile.vue'
    import Account from '@com/Organize/Default/Includes/Account.vue'
    import SavedBookmark from '@com/Organize/Default/Includes/SavedBookmark.vue'

    import {mapActions, mapState} from 'vuex'

    export default Base.extend({
        name: "Home",
        components: {
            Members,
            OrganizeProfile,
            EditOrganizeProfile,
            Account,
            Volunteering,
            SavedBookmark
        },
        data: () => ({
            tab: 0,
            tabs: {dashboard: 0, 'our-volunteering': 1, members: 2, saved: 3, profile: 4, account: 5},
            minYear: 2015,
            volunteering: {
                filter: 'this1Month',
                from: {monthFilter: 0, yearFilter: new Date().getFullYear()},
                to: {monthFilter: 0, yearFilter: new Date().getFullYear()},
            },
            isEditProfile: false,
        }),
        computed: {
            ...mapState(['dashboardData']),
        },
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
            ...mapActions(['copyToClipboard', 'postManageVisibilityUserProfile', 'fetchDashboardData']),
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                    this.isEditProfile = this.$route.query.edit === 'true';
                    this.$utils.setWindowTitle(`${this.$utils.firstUpper(tab)} | ${this.s.site_name}`);
                }
            },
            setRouteTab(n) {
                this.Route({name: 'home', query: {active_page: n}});
            },
            setRouteProfile(n) {
                this.Route({name: 'home', query: {active_page: 'profile', edit: n}});
            },
            changeUserVisibility() {
                let visibility = this.userProfile.visibility;
                this.postManageVisibilityUserProfile(this.userProfile)
                    .then(res => {
                        if (res.success) {
                            this.toaster(res.msg);
                            this.userProfile.website_in_our_site = visibility ? res.data : '';
                        } else {
                            this.toaster(res.msg);
                            this.userProfile.visibility = !visibility;
                        }
                    })
                    .catch(err => {
                        // console.log(err);
                    });
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


