<template>
    <main class="laogiving activity clearfix" style="padding-right: 1rem; padding-left: 1rem;">
        <div
            class="pad-navbar hero-container hero-container--light-grey hero-container--auto-w create-volunteer-act__head">
            <h2 class="h2 create-volunteer-act__title text-center">{{$utils.isEmptyVar(id)? 'New': (isDuplicate ?
                'Duplicate' : 'Edit')}} Volunteering
                Opportunity</h2>
            <p class="body-txt body-txt--small mb-16"> You are setting up a volunteer activity for <b>{{authUserInfo.name}}</b></p>
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
                <StepTwo :edit="!$utils.isEmptyVar(id)"
                         :disabled-required-field="status==='cancelled' || status === 'closed' || isHaveSignUpUsers " ref="step-2"
                         v-show="tab===1"/>
                <StepThree :edit="!$utils.isEmptyVar(id)" :skills="skills" :suitables="suitables" ref="step-3"
                           v-show="tab===2"/>
                <StepFour :edit="!$utils.isEmptyVar(id)" ref="step-4" v-show="tab===3"/>
                <StepFive :edit="!$utils.isEmptyVar(id)" :suitables="suitables"
                          :finalData="{formData: this.formData, volunteering: this.volunteering}"
                          :visible="tab===4"
                          ref="step-5" v-show="tab===4"/>
                <div class="clearfix"></div>
                <div class="create-volunteer-act__footer"> <!-- mobile back btn-->
                    <button
                        v-show="tab !== 0"
                        @click="Route({name: 'create-activity', query: { active_page: nextPages[active_page].prev, volunteering_id: id }})"
                        class="create-volunteer-act__footer-show-mobile button-ctn button--icon button--ghost mr-24">
                        <i class="ico material-icons">keyboard_backspace</i></button> <!-- desktop back btn-->
                    <button id="volunteer-prev-btn"
                            @click="Route({name: 'create-activity', query: { active_page: nextPages[active_page].prev, volunteering_id: id }})"
                            class="create-volunteer-act__footer-hide-mobile button-ctn button--with-icon button--no-bg button--large mr-8 button-page-back"
                            v-show="tab !== 0">
                        <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                            class="ico material-icons button--with-icon__icon">keyboard_backspace</i> BACK
                        </div>
                    </button> <!-- mobile save draft btn-->
                    <button
                        v-if="!((tab > 3 && !(status==='' || status==='draft' || isDuplicate)))"
                        @click="saveVolunteering()"
                        class="create-volunteer-act__footer-show-mobile button-ctn button--icon button--ghost mr-24"><i
                        class="ico ico--small material-icons" style="padding-top: 1px; padding-left: 1px;">save</i>
                    </button>
                    <!-- desktop save draft btn-->
                    <button
                        v-if="!((tab > 3 && !(status==='' || status==='draft' || isDuplicate)))"
                        @click="saveVolunteering()"
                        class="button-ctn button--135 button--large create-volunteer-act__footer-hide-mobile mr-24 button-save-draft">
                        {{ status==='' || status==='draft' || isDuplicate ? 'SAVE DRAFT' : 'SAVE'}}
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

    import {mapActions, mapState, mapMutations} from 'vuex'

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
            status: '',
            isHaveSignUpUsers: false,
            isDraft: false,
            isDuplicate: false,
            stepSave: 0,
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
        computed: {
            ...mapState(['volunteeringDuplicateData']),
        },
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            }
        },
        methods: {
            ...mapActions(['fetchVolunteeringActivityData', 'saveVolunteeringActivityData', 'updateVolunteeringActivityData', 'showErrorToast', 'showInfoToast',]),
            ...mapMutations(['setVolunteeringDuplicateData']),
            setTab() {
                this.id = this.$route.query.volunteering_id;
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
                            query: {active_page: this.nextPages[this.active_page].prev, volunteering_id: this.id}
                        });
                    }
                }
            },
            setRouteTab(n) {
                this.Route({name: 'create-activity', query: {active_page: n, volunteering_id: this.id}});
            },
            getVolunteeringActivityData(id = null) {
                this.isHaveSignUpUsers = false;
                this.fetchVolunteeringActivityData({id: id || this.id})
                    .then(res => {
                        if (res.success) {
                            this.causes = res.data.causes;
                            this.skills = res.data.skills;
                            this.suitables = res.data.suitables;
                            if (this.id !== null) {
                                if (res.data.volunteering) {
                                    this.setData(res.data.volunteering);
                                    if (!this.$utils.isEmptyObject(this.volunteeringDuplicateData)
                                        && this.$route.query.duplicate_id === this.$route.query.volunteering_id) {
                                        this.setData(this.volunteeringDuplicateData);
                                        this.isDuplicate = true;
                                    } else {
                                        let signUpUsers = res.data.volunteering.positions.filter(f => {
                                            return f.active_opportunity > 0 || f.total_pending > 0;
                                        });
                                        this.isHaveSignUpUsers = signUpUsers.length > 0;
                                    }
                                } else {
                                    this.id = null;
                                    this.Route({
                                        name: 'create-activity',
                                        query: {active_page: this.tabs[0]}
                                    });
                                }
                            }
                        }
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to load volunteering activity!', dt: 3500});
                        console.log(err);
                    })
            },
            serializeFormData(callback, stepSave = 0) {
                this.formData = new FormData();
                let maxStep = stepSave > 0 ? stepSave : this.step;
                maxStep = maxStep > 4 ? 4 : maxStep;//max is 4
                for (let i = 0; i < maxStep; i++) {
                    this.$refs[`step-${(i + 1)}`].getData().then(res => {
                        this.volunteering = {...this.volunteering, ...res.data};
                        for (let pair of res.formData.entries()) {
                            pair[1] = pair[1] === 'null' ? '' : pair[1];
                            this.formData.append(pair[0], pair[1] || '');
                        }
                        if (i === maxStep - 1) {
                            callback();
                        }
                    }).catch(() => {
                        if (stepSave > 0) {
                            this.showErrorToast({msg: 'Please check your form again!', dt: 3500});
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
                                query: {active_page: this.nextPages[this.active_page].next, volunteering_id: this.id}
                            });
                        });
                    }).catch(() => {
                    this.showErrorToast({msg: 'Please check your form again!', dt: 3500});
                });
            },
            publishVolunteering() {
                this.serializeFormData(() => {
                    this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                    this.formData.append('step', this.stepSave);
                    if (this.isDraft) {
                        this.formData.append('draft', 'true');
                    }
                    if (this.isDuplicate) {
                        this.formData.append('duplicate', this.id);
                    }
                    if (this.id && !this.isDuplicate) {
                        this.updateVolunteeringActivityData({id: this.id, data: this.formData}).then(res => {
                            if (res.success) {
                                //reset data
                                this.isDraft = false;
                                this.stepSave = 0;
                                //reset data
                                this.toaster('Volunteer activity saved.');
                                this.Route({
                                    name: 'create-activity',
                                    query: {active_page: 'general-info-&-permissions', volunteering_id: res.data.id}
                                });
                                this.getVolunteeringActivityData();
                                this.$utils.scrollToY('html,body', 0);
                            }
                            this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                        }).catch(err => {
                            console.log(err);
                            this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                        });

                    } else {
                        this.saveVolunteeringActivityData(this.formData).then(res => {
                            if (res.success) {
                                //reset data
                                this.isDraft = false;
                                this.isDuplicate = false;
                                this.stepSave = 0;
                                this.setVolunteeringDuplicateData({});//reset duplicate data
                                //reset data
                                this.toaster('Volunteer activity created.');
                                this.Route({
                                    name: 'create-activity',
                                    query: {active_page: 'general-info-&-permissions', volunteering_id: res.data.id}
                                });
                                this.getVolunteeringActivityData(res.data.id);
                                this.$utils.scrollToY('html,body', 0);
                            }
                            this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                        }).catch(err => {
                            console.log(err);
                            this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                        });
                    }
                }, this.stepSave);
            },
            saveVolunteering() {
                this.isDraft = this.status === '' || this.status === 'draft' || this.isDuplicate;
                this.stepSave = this.tab + 1;
                this.publishVolunteering();
            },
            setData(data) {
                this.step = data.step;
                this.status = data.status;

                if (!this.$refs[`step-1`]) {
                    return;
                }

                this.$refs[`step-1`].setTile(data.name);
                this.$refs[`step-1`].setDescription(data.description);

                this.$refs[`step-1`].setMedia(data.video_media, data.images_media);
                this.$refs[`step-1`].setCauses(data.activity_causes);

                this.$refs[`step-2`].setData({
                    frequency: data.frequency,
                    duration: data.duration,
                    days_of_week: data.days_of_week,
                    commitment_from_date: data.start_date,
                    commitment_to_date: data.end_date,
                    deadline_for_sign_ups_date: data.deadline_sign_ups_date,
                    town: data.town,
                    block_street: data.block_street,
                    building_name: data.building_name,
                    unit: data.building_unit_number
                });

                this.$refs[`step-3`].setData({
                    points_to_note: data.points_to_note,
                    volunteer_gender: data.volunteer_gender === 'yes',
                    volunteer_contact_phone_number: data.volunteer_contact_phone_number === 'yes',
                    other_response_required: data.other_response_required,
                    volunteer_signups_confirm: data.volunteer_signups_confirm === 'yes',
                    positions: data.positions
                });
                this.$refs[`step-4`].setData({
                    contact_title: data.contact_title,
                    contact_name: data.contact_name,
                    contact_designation: data.contact_designation,
                    contact_phone_number: data.contact_phone_number,
                    contact_email: data.contact_email
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
