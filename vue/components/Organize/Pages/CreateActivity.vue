<template>
    <main class="laogiving activity clearfix" style="padding-right: 1rem; padding-left: 1rem;">
        <div
            class="pad-navbar hero-container hero-container--light-grey hero-container--auto-w create-volunteer-act__head">
            <h2 class="h2 create-volunteer-act__title text-center">New Volunteering Opportunity</h2>
            <p class="body-txt body-txt--small mb-16"> You are setting up a volunteer activity for <b>Bee
                Organisation</b></p>
            <div class="cWidth-1200">
                <div
                    class="create-volunteer-act__hero-ctn hero-container__body hero-container__body--no-pad hero-container__body--auto relative js-bcrumb bcrumb bcrumb--grey-back bcrumb--center js-create-volunteer-act__bcrumb">
                    <div class=" bcrumb__child bcrumb__child--responsive bcrumb__child no-before "
                         :class="[{'is-active': tab === 0, 'is-complete': tab > 0 }]"><span
                        class="bcrumb__number">1</span><img
                        :src="`${baseUrl}${baseRes}assets/svg/ic-checked-small-pending-purple.svg`" alt="checked"
                        class="bcrumb__complete">
                        <p class="">General info &amp; permissions</p></div>
                    <div class=" bcrumb__child bcrumb__child--responsive bcrumb__child"
                         :class="[{'is-active': tab === 1 , 'is-complete': tab > 1}]"><span
                        class="bcrumb__number">2</span><img
                        :src="`${baseUrl}${baseRes}assets/svg/ic-checked-small-pending-purple.svg`" alt="checked"
                        class="bcrumb__complete">
                        <p class="">Schedule &amp; location</p></div>
                    <div class=" bcrumb__child bcrumb__child--responsive bcrumb__child"
                         :class="[{'is-active': tab === 2, 'is-complete': tab > 2 }]"><span
                        class="bcrumb__number">3</span><img
                        :src="`${baseUrl}${baseRes}assets/svg/ic-checked-small-pending-purple.svg`" alt="checked"
                        class="bcrumb__complete">
                        <p class="">Volunteer positions</p></div>
                    <div class=" bcrumb__child bcrumb__child--responsive bcrumb__child"
                         :class="[{'is-active': tab === 3, 'is-complete': tab > 3 }]"><span
                        class="bcrumb__number">4</span><img
                        :src="`${baseUrl}${baseRes}assets/svg/ic-checked-small-pending-purple.svg`" alt="checked"
                        class="bcrumb__complete">
                        <p class="">Contact details</p></div>
                </div>

            </div>

        </div>

        <div class="cWidth-1200">
            <div
                class="rounded-card rounded-card--no-pad rounded-card--light-shadow rounded-card--height-auto rounded-card--full create-volunteer-act__main">
                <StepOne v-show="tab===0"/>
                <StepTwo v-show="tab===1"/>
                <StepThree v-show="tab===2"/>
                <StepFour v-show="tab===3"/>
                <StepFive v-show="tab===4"/>
                <div class="clearfix"></div>
                <div class="create-volunteer-act__footer"> <!-- mobile back btn-->
                    <button
                        class="create-volunteer-act__footer-show-mobile button-ctn button--icon button--ghost mr-24">
                        <i class="ico material-icons">keyboard_backspace</i></button> <!-- desktop back btn-->
                    <button id="volunteer-prev-btn"
                            @click="Route({name: 'create-activity', query: { active_page: nextPages[active_page].prev }})"
                            style="display: inline-block;"
                            class="create-volunteer-act__footer-hide-mobile button-ctn button--with-icon button--no-bg button--large mr-8 button-page-back"
                            v-show="tab !== 0">
                        <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                            class="ico material-icons button--with-icon__icon">keyboard_backspace</i> BACK
                        </div>
                    </button> <!-- mobile save draft btn-->
                    <button
                        class="create-volunteer-act__footer-show-mobile button-ctn button--icon button--ghost mr-24"><i
                        class="ico ico--small material-icons" style="padding-top: 1px; padding-left: 1px;">save</i>
                    </button>
                    <!-- desktop save draft btn-->
                    <button
                        class="button-ctn button--135 button--large create-volunteer-act__footer-hide-mobile mr-24 button-save-draft">
                        SAVE DRAFT
                    </button>
                    <button id="volunteer-submit-btn"
                            class="button-ctn button--135 button--large mr-24 button-page-submit"
                            v-show="tab > 3">PUBLISH
                    </button>
                    <button id="volunteer-next-btn"
                            v-show="tab <= 3"
                            @click="Route({name: 'create-activity', query: { active_page: nextPages[active_page].next }})"
                            class="button-ctn button--135 button--large js-create-volunteer-act__next button-page-next"
                            style="display: inline-block;">{{(nextPages[active_page].next !== 'preview') ?
                        'NEXT' : 'QUICK PREVIEW' }}
                    </button>
                </div>

            </div>
        </div>
    </main>
</template>

<script>

    import Base from "@com/Bases/OrganizeBase.js";

    import StepOne from "@com/Organize/Pages/Includes/ActivityStepOne.vue"
    import StepTwo from "@com/Organize/Pages/Includes/ActivityStepTwo.vue"
    import StepThree from "@com/Organize/Pages/Includes/ActivityStepThree.vue"
    import StepFour from "@com/Organize/Pages/Includes/ActivityStepFour.vue"
    import StepFive from "@com/Organize/Pages/Includes/ActivityStepFive.vue"

    import {mapActions} from 'vuex'

    export default Base.extend({
        name: "CreateActivity",
        components: {
            StepOne,
            StepTwo,
            StepThree,
            StepFour,
            StepFive
        },
        data: () => ({
            tab: 0,
            tabs: {
                'general-info-&-permissions': 0,
                'schedule-and-location': 1,
                'volunteer-positions': 2,
                'contact-details': 3,
                'preview': 4
            },
            active_page: 'general-info-&-permissions',
            nextPages: {
                'general-info-&-permissions': {next: 'schedule-and-location', prev: ''},
                'schedule-and-location': {next: 'volunteer-positions', prev: 'general-info-&-permissions'},
                'volunteer-positions': {next: 'contact-details', prev: 'schedule-and-location'},
                'contact-details': {next: 'preview', prev: 'volunteer-positions'},
                'preview': {next: '', prev: 'contact-details'},
            }
        }),
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            }
        },
        methods: {
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                    this.active_page = tab;
                    this.$utils.scrollToY('html,body', 0);
                }
            },
            setRouteTab(n) {
                this.Route({name: 'create-activity', query: {active_page: n}});
            },
        },
        mounted() {
        },
        created() {
            this.setPageTitle(`Start Volunteer`);
            this.setTab();
        }
    });
</script>

<style scoped>

</style>
