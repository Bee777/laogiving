<template>
    <div>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="admin-dashboard-page">
                    <div class="p-header" p-header-host>
                        <div>
                            <!--Make app-nav-bar transparent works -->
                            <div class="fire-feature-bar-image" p-header-host-1></div>
                            <!--Make app-nav-bar transparent works -->
                            <div class="feature-bar-content" p-content>
                                <div class="feature-bar-core" p-content>
                                    <div class="title-lockup stretch-across" p-content></div>
                                    <div class="feature-app-selector" p-content></div>
                                </div>
                                <div class="admin-dashboard-page-inner">
                                    <div class="page-project">
                                        <div class="page-project-name">
                                            <div class="fire-feature-bar-title" p-header-host-2>
                                                <h1 class="fire-featurebar-title" p-content-1>{{s.site_name}}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div @click="goTo('members')" style="cursor: pointer;" class="count-items">
                                        <div>Latest Users Count</div>
                                        <div class="value">{{ dashboardData.latest_members_count }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlaying page-content p-main top-less" p-header-host-3>
                        <div class="page-inner-content">
                            <!--Overview Items-->
                            <div class="items items-stability">
                                <section>
                                    <h2 class="items-title">Overview Posts</h2>
                                    <div class="items-row sidekick items-hero">
                                        <div class="p-card">
                                            <div class="admin-mat-card">
                                                <div class="p-card-header">
                                                    <i class="material-icons"> chrome_reader_mode </i>
                                                    <h3 @click="goTo('event')" class="p-card-title"> Activities, Hours Volunteered. </h3>
                                                </div>
                                                <SpinnerLoading v-if="validated().loading_dashboard_data"/>
                                                <div class="p-posts-card">
                                                    <div class="p-columns">
                                                        <!--Activities Count-->
                                                        <div class="p-column">
                                                            <div @click="goTo('activities')" style="cursor: pointer;"
                                                                 class="items-counter align-horizontal-center target-host">
                                                                <div class="counter-header">
                                                                    <div class="counter-title-label">
                                                                        <h4 class="counter-title">Active Activities
                                                                            Count</h4>
                                                                        <div class="p-label">(Current)</div>
                                                                    </div>
                                                                </div>
                                                                <div class="value-delta">
                                                                    <div class="value">
                                                                        <span class="value-container">{{dashboardData.activities_count.active}} Activities</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--End Activities Count-->
                                                        <!--Hours Volunteered Count-->
                                                        <div class="p-column">
                                                            <div @click="goTo('activities')" style="cursor: pointer;"
                                                                 class="items-counter align-horizontal-center target-host">
                                                                <div class="counter-header">
                                                                    <div class="counter-title-label">
                                                                        <h4 class="counter-title">Hours Volunteered</h4>
                                                                        <div class="p-label">(Current)</div>
                                                                    </div>
                                                                </div>
                                                                <div class="value-delta">
                                                                    <div class="value">
                                                                        <span class="value-container">{{$utils.numSpace(dashboardData.volunteering_hours)}} Hours</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--End Hours Volunteered Count-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!--End Overview Items-->
                            <!--<hr class="splitter-items">-->

                            <!--Member Overview Items-->
                            <div class="items">
                                <!-- items-stability -->
                                <section>
                                    <h2 class="items-title">All Members Status</h2>
                                    <div class="items-row sidekick">
                                        <CounterCard :isLoading="validated().loading_dashboard_data"
                                                     @onCardClick="goTo('volunteer')" title="Volunteer"
                                                     icon="face"
                                                     :count="{text: 'Signups', value: dashboardData.latest_volunteers_count}"/>

                                        <CounterCard :isLoading="validated().loading_dashboard_data"
                                                     @onCardClick="goTo('organize')" title="Organize or Group"
                                                     icon=" group "
                                                     :count="{text: 'Signups', value: dashboardData.latest_organizes_count}"/>
                                    </div>
                                </section>
                            </div>
                            <!--End Member Overview Items-->

                            <!--Volunteering Overview Items-->
                            <div class="items">
                                <!-- items-stability -->
                                <section>
                                    <h2 class="items-title">All Volunteering Status</h2>
                                    <div class="items-row sidekick">
                                        <CounterCard :isLoading="validated().loading_dashboard_data"
                                                     @onCardClick="goTo('volunteering')"
                                                     title="Success"
                                                     :count="{text: 'Activities', value: dashboardData.activities_count.success }"
                                                     icon="verified_user"/>
                                        <CounterCard :isLoading="validated().loading_dashboard_data"
                                                     @onCardClick="goTo('volunteering')"
                                                     title="Opening(Active)"
                                                     :count="{text: 'Activities', value: dashboardData.activities_count.active }"
                                                     icon="description"/>
                                    </div>
                                </section>
                            </div>
                            <!--End Volunteering Overview Items-->

                            <!--Posts Items-->
                            <div class="items">
                                <!-- items-stability -->
                                <section>
                                    <h2 class="items-title">All Posts Status</h2>
                                    <div class="items-row sidekick">
                                        <!--Scholarships Card-->
                                        <CounterCard :isLoading="validated().loading_dashboard_data"
                                                     @onCardClick="goTo('scholarship')" title="Activities"
                                                     icon="school"
                                                     :count="{text: 'Posts', value: dashboardData.activities_count.all }"/>
                                        <!--Scholarships Card-->
                                    </div>
                                    <div class="items-row sidekick">
                                        <!-- items-hero  -->
                                        <!--News Card-->
                                        <CounterCard :isLoading="validated().loading_dashboard_data"
                                                     @onCardClick="goTo('news')" title="News" icon="rss_feed"
                                                     :count="{text: 'Posts', value: dashboardData.news_count.all}"/>
                                        <!--News Card-->
                                    </div>

                                </section>
                            </div>
                            <!--End Posts Items-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapState, mapGetters, mapActions} from 'vuex'
    import CounterCard from '@cus-com/Admin/DashboardItems/CounterItemCard.vue';

    export default {
        components: {
            CounterCard
        },
        data() {
            return {
                ...mapGetters(['validated', 'succeeded', 'getSideBarWidthForTabs']),
            }
        },
        computed: {
            ...mapState(['isMobile', 'isSidebarCollapsed', 'dashboardData']),
        },
        watch: {},
        methods: {
            ...mapActions(['setPageTitle', 'fetchDashboardData']),
            setEnterParentData() {
                let data = this.$parent.$data;
                data.showFeatureBar = false;
                data.addTranscludeClass = true;
                data.hasHeaderTransparent = true;
            },
            setOutParentData() {
                let data = this.$parent.$data;
                data.showFeatureBar = true;
                data.addTranscludeClass = false;
                data.hasHeaderTransparent = false;
            },
            goTo(n) {
                this.Route({name: n});
            }
        },
        mounted() {
            this.setPageTitle('Dashboard');
        },
        beforeRouteLeave: function (to, from, next) {
            this.setOutParentData();
            next();
        },
        created() {
            this.setEnterParentData();
            this.fetchDashboardData();
        }
    }
</script>
<style scoped>
</style>
