<template>
    <main class="laogiving activity clearfix" style="padding-right: 1rem; padding-left: 1rem;">
        <div
            class="pad-navbar hero-container hero-container--light-grey hero-container--auto-w create-volunteer-act__head">
            <h2 class="h2 create-volunteer-act__title text-center">New Volunteering Opportunity</h2>
            <p class="body-txt body-txt--small mb-16"> You are setting up a volunteer activity for <b>Bee
                Organisation</b></p>
            <!--Tabs-->
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
            <!--Tabs-->

        </div>

        <div class="cWidth-1200">
            <div
                class="rounded-card rounded-card--no-pad rounded-card--light-shadow rounded-card--height-auto rounded-card--full create-volunteer-act__main">
                <StepOne :edit="!$utils.isEmptyVar(id)" ref="step-1" :causes="causes" v-show="tab===0"/>
                <StepTwo ref="step-2" v-show="tab===1"/>
                <StepThree :skills="skills" :suitables="suitables" ref="step-3" v-show="tab===2"/>
                <StepFour ref="step-4" v-show="tab===3"/>
                <StepFive :suitables="suitables" :finalData="{formData: this.formData, volunteering: this.volunteering}"
                          :visible="tab===4"
                          ref="step-5" v-show="tab===4"/>
                <div class="clearfix"></div>
                <div class="create-volunteer-act__footer"> <!-- mobile back btn-->
                    <button
                        v-show="tab !== 0"
                        @click="Route({name: 'create-activity', query: { active_page: nextPages[active_page].prev }})"
                        class="create-volunteer-act__footer-show-mobile button-ctn button--icon button--ghost mr-24">
                        <i class="ico material-icons">keyboard_backspace</i></button> <!-- desktop back btn-->
                    <button id="volunteer-prev-btn"
                            @click="Route({name: 'create-activity', query: { active_page: nextPages[active_page].prev }})"
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
                            @click="publishVolunteering()"
                            class="button-ctn button--135 button--large mr-24 button-page-submit"
                            v-show="tab > 3">PUBLISH
                    </button>
                    <button id="volunteer-next-btn"
                            v-show="tab <= 3"
                            @click="processSteps()"
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

    import {mapActions, mapMutations} from 'vuex'

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
            id: null,
            tab: 0,
            tabs: {
                'general-info-&-permissions': 0,
                'schedule-and-location': 1,
                'volunteer-positions': 2,
                'contact-details': 3,
                'preview': 4
            },
            active_page: 'general-info-&-permissions',
            step: 0,
            nextPages: {
                'general-info-&-permissions': {
                    next: 'schedule-and-location', prev: ''
                },
                'schedule-and-location': {
                    next: 'volunteer-positions',
                    prev: 'general-info-&-permissions',
                    passed: false
                },
                'volunteer-positions': {next: 'contact-details', prev: 'schedule-and-location'},
                'contact-details': {next: 'preview', prev: 'volunteer-positions'},
                'preview': {next: '', prev: 'contact-details'},
            },
            causes: [],
            skills: [],
            suitables: [],
            formData: null,
            volunteering: {}
        }),
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            }
        },
        methods: {
            ...mapActions(['fetchVolunteeringActivityData', 'saveVolunteeringActivityData', 'showErrorToast', 'showInfoToast',]),
            ...mapMutations([]),
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                    this.active_page = tab;
                    this.$utils.scrollToY('html,body', 0);
                    this.$utils.setWindowTitle(`Start Volunteer - ${this.$utils.firstUpper(tab, true)} | ${this.s.site_name}`);
                    //if not edit and step not passed
                    if (!(this.step >= this.tab)) {
                        this.Route({
                            name: 'create-activity',
                            query: {active_page: this.nextPages[this.active_page].prev}
                        });
                    }
                }
            },
            setRouteTab(n) {
                this.Route({name: 'create-activity', query: {active_page: n}});
            },
            getVolunteeringActivityData() {
                this.fetchVolunteeringActivityData({id: this.id})
                    .then(res => {

                        if (res.success) {

                            this.causes = res.data.causes;
                            this.skills = res.data.skills;
                            this.suitables = res.data.suitables;

                            this.setData();
                        }
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to load volunteering activity!', dt: 3500});
                        console.log(err);
                    })
            },
            serializeFormData(callback) {
                this.formData = new FormData();
                for (let i = 0; i < this.step; i++) {
                    this.$refs[`step-${(i + 1)}`].getData().then(res => {
                        this.volunteering = {...this.volunteering, ...res.data};
                        for (let pair of res.formData.entries()) {
                            this.formData.append(pair[0], pair[1]);
                        }
                        if (i === this.step - 1) {
                            callback();
                        }
                    });
                }
            },
            processSteps() {
                this.$refs[`step-${(this.tab + 1)}`].getData()
                    .then(() => {
                        this.step = this.tab + 1;
                        this.serializeFormData(() => {
                            this.Route({
                                name: 'create-activity',
                                query: {active_page: this.nextPages[this.active_page].next}
                            });
                        });
                    }).catch(() => {
                    this.showErrorToast({msg: 'Please check your form again!', dt: 3500});
                });
            },
            publishVolunteering() {
                this.serializeFormData(() => {
                    this.saveVolunteeringActivityData(this.formData).then(res => {
                        console.log(res);
                    }).catch(err => {
                        console.log(err);
                    });
                });
            },
            setData() {
                //this.id = 1;
                this.$refs[`step-1`].setTile('Activity Landscape Farm Maintenance @  Kampung Kampus (May 2019)');
                this.$refs[`step-1`].setDescription('Activity description\n' +
                    'What is it about? Who are the beneficiaries? What purpose does it serve?');

                this.$refs[`step-1`].setMedia(
                    {validated: '', url: 'https://www.youtube.com/watch?v=gv5ZTtBUjVM'},
                    [{
                        id: 12,
                        url: 'https://yt3.ggpht.com/proxy/OO1RWLgzGwj2A_u4crEwMlp8RN8949sLgmDodG_cAGBiIVUlUHZ9ArPQsMmmzypbdf1KxXIrETUgY-UUbLE=-w480-h360',
                        image_base64: 'https://yt3.ggpht.com/proxy/OO1RWLgzGwj2A_u4crEwMlp8RN8949sLgmDodG_cAGBiIVUlUHZ9ArPQsMmmzypbdf1KxXIrETUgY-UUbLE=-w480-h360',
                        image: 'https://yt3.ggpht.com/proxy/OO1RWLgzGwj2A_u4crEwMlp8RN8949sLgmDodG_cAGBiIVUlUHZ9ArPQsMmmzypbdf1KxXIrETUgY-UUbLE=-w480-h360',
                        validated: '',
                        removable: false,
                    }]);
                this.$refs[`step-1`].setCauses([1, 3, 4]);

                this.$refs[`step-2`].setData({
                    frequency: '2_3_DAYS_PER_WEEK',
                    duration: 2,
                    days_of_week: ['WEEKDAY', 'WEEKEND'],
                    commitment_from_date: '2019/07/01',
                    commitment_to_date: '2019/07/04',
                    deadline_for_sign_ups_date: '2019/07/03',
                    town: `Boon Lay`,
                    block_street: `88 Geylang Bahru Singapore 339696`,
                    building_name: `Tampines`,
                    unit: 13
                });


                this.$refs[`step-3`].setData({
                    points_to_note: '"no matter how close I get to you, my heart is(ou) that of one"\n' +
                        '(it\'s a pun on his name)\n',
                    volunteer_gender: true,
                    volunteer_contact_phone_number: true,
                    other_response_required: `Do you have some money?`,
                    volunteer_signups_confirm: true,
                    positions: [
                        {
                            collapsed: false,
                            position_title: 'Position Title 1',
                            vacancies: 13,
                            minimum_age: 13,
                            position_skills: [1, 2, 5],
                            position_suitables: [2, 3, 1],
                            key_responsibilities: `คำอ่าน+คำแปลน้าา❤
                        ねぇ、もしも全て投げ捨てられたら
                        笑って生きることが楽になるの？
                        また胸が痛くなるから
                        もう何も言わないでよ
                        nee moshimo subete nagesuteraretara
                        waratte ikiru koto ga raku ni naru no?
                        mata mune ga itakunaru kara
                        mou nani mo iwanaide yo

                        นี่ หากโยนทุกสิ่งทิ้งไปได้แล้ว
                        ฉันจะยิ้มและมีชีวิตอยู่ได้อย่างสบายใจใช่ไหม?
                        หัวใจของฉันมันจะเจ็บปวดขึ้นมาอีก
                        ดังนั้นเธอไม่ต้องพูดอะไรอีกต่อไปแล้ว`,
                            validated: {},
                        },
                        {
                            collapsed: false,
                            position_title: 'Position Title 2',
                            vacancies: 13,
                            minimum_age: 13,
                            position_skills: [1, 2, 5],
                            position_suitables: [4, 3, 1, 5],
                            key_responsibilities: `nee moshimo subete nagesuteraretara
                        waratte ikiru koto ga raku ni naru no?
                        mata mune ga itakunaru kara
                        mou nani mo iwanaide yo`,
                            validated: {},
                        }
                    ]
                });

                this.$refs[`step-4`].setData({
                    contact_title: 'mr',
                    contact_name: 'SKT MM',
                    contact_designation: 'Leader of faker',
                    contact_phone_number: `020 533339696`,
                    contact_email: `Tampines@gmail.com`
                });

            }
        },
        mounted() {
        },
        created() {
            this.setPageTitle(`Start Volunteer`);
            this.setTab();
            this.getVolunteeringActivityData();
        }
    });
</script>

<style scoped>

</style>
