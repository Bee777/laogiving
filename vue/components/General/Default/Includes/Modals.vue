<template>
    <div>
        <modal id="signinmodal" transition="nice-modal-fade" :name="modalNames.login" classes="modal-ctn" height="auto"
               @before-open="beforeOpen"
               @opened="loginForm"
               @before-close="beforeClose">
            <div class="content-area">
                <main class="site-main activity">
                    <div class="login-form form">
                        <h2 class="h2 text-center mb-16">Login</h2>
                        <div class="cursor" @click="hide('signin')">
                            <i class="material-icons close-modal-ctn">close</i>
                        </div>
                        <div class="body-txt body-txt--smaller body-txt--no-letter-space pt-8 text-center">Your
                            information is safe and secure with us.
                        </div>
                        <form name="loginform" @submit.prevent method="post" class="activity">
                            <label> Email
                                <input v-model="user.email" class="input-ctn" autocomplete="username email" name="email"
                                       value=""
                                       type="email">
                            </label>

                            <label v-if="validated().email" class="error-msg" style="display: block;">{{
                                validated().email }}</label>

                            <label class="mt-16">
                                Password <span class="tooltip__mark" data-toggle="tooltip" data-placement="right"
                                               title="Your password must be between 8-24 characters with at least one number. Only special characters @$!%*?&amp;+-.=^_|~ are accepted.">?</span>
                                <input
                                    v-model="user.password"
                                    autocomplete="current-password" name="password" value=""
                                    class="input-ctn"
                                    type="password">
                            </label>

                            <label v-if="validated().password" class="error-msg" style="display: block;">{{
                                validated().password }}</label>

                            <div v-if="validated().auth_failed" class="error-msg pt-8" style="display: block;">{{
                                validated().auth_failed }}
                            </div>

                            <label class="mb-16"><a @click="Route({name: 'forgot-password'})">Forgot
                                Password?</a></label>
                            <button
                                @click="LoginUser({userInfo: user, refreshPage: true})"
                                class="button-ctn button--large button--full">
                                Login
                            </button>
                            <p class="p-modal-footer"> Don't have an account? <a
                                @click="Route({name: 'register-overview'})" class="cursor">Create an Account</a> now!
                            </p>
                        </form>
                    </div>
                </main>
            </div>
        </modal>

        <modal id="volunteer-signup-modal" transition="pop-out" :name="modalNames.signUpVolunteer" classes="modal-ctn"
               :width="modalWidth"
               height="auto"
               :scrollable="true"
               @opened="volunteerForm"
               @before-open="beforeOpen"
               @before-close="beforeClose">
            <div class="content-area">
                <div class="site-main activity">
                    <div class="modal-header-ctn">
                        <div class="cursor" @click="hide('volunteer-signup', {close: true})">
                            <i class="material-icons close-modal-ctn">close</i>
                        </div>
                        <h3 class="h3">&nbsp;</h3>
                    </div>
                    <div class="height-auto">
                        <div class="form">
                            <div class="modal-header-ctn">
                                <img :src="`${baseUrl}${authUserInfo.thumb_image}`"
                                     class="profile-pic profile-pic--small mr-16">
                                <h4 class="h2">Hello, {{authUserInfo.name}}</h4>
                                <p class="body-txt body-txt--small mb-16">You are signing up as <b>{{$utils.firstUpper(authUserInfo.decodedType)}}</b>.
                                </p>
                                <div class="centered"><span class="bold"> You are attempting to sign up for an activity that conflicts with another activity you've already signed up for. </span>
                                </div>
                            </div>
                            <!--Start FORM-->
                            <div
                                style="max-width: 100%;margin-left: 5px;margin-right: 5px;"
                                class="rounded-card rounded-card--no-pad rounded-card--light-shadow rounded-card--height-auto">
                                <div
                                    ref="volunteer-form"
                                    class="rounded-card__body rounded-card__body--responsive">
                                    <form class="activity" v-on:submit.prevent method="post">
                                        <div class="input-ctrl volunteer-activity-info">
                                            <h3 class="h3 font-dark-grey">Yes, I want to sign up as a</h3>
                                            <template
                                                v-if="isMultiplePositions()">
                                                <select
                                                    @change="checkingVolunteeringPosition()"
                                                    v-model="modalData[modalNames.signUpVolunteer].model.volunteer_position"
                                                    class="select-ctn select--full valid"
                                                    name="volunteersignup_positionId">
                                                    <option value="" disabled selected>Please select position</option>
                                                    <!--data-require-min-age="true"-->
                                                    <!--data-min-age="17"-->
                                                    <!--data-position-left="10"-->
                                                    <option v-for="(item, idx) in getVolunteering().positions"
                                                            :key="idx" :value="item.id">{{item.position_title}}
                                                    </option>
                                                </select>
                                                <label style="display: block;" class="error-msg">{{
                                                    validated().volunteer_position }}</label>
                                            </template>
                                            <template v-else>
                                                <h3 class="h3 mt-16 font-dark-grey">
                                                    {{getVolunteeringSelectedPosition().position_title}}</h3>
                                            </template>


                                            <h3 class="h3 mt-16 font-dark-grey" style="font-weight:normal;">for</h3>
                                            <h3 class="h3 mt-16 font-dark-grey">{{ getVolunteering().name }}</h3>
                                            <h3 class="h3 mt-16 mb-16 font-dark-grey" style="font-weight:normal;">
                                                on</h3>
                                            <h3 class="h3 mb-16 font-dark-grey">
                                                {{ getVolunteering().start_date_formatted_number
                                                }} - {{ getVolunteering().end_date_formatted_number }}</h3>
                                            <p class="body-txt mb-16"><span><b>{{ getFrequency()[getVolunteering().frequency]}} on {{ getDaysOfWeek(getVolunteering().days_of_week || [])}}</b></span>
                                                <br> <br>at {{getVolunteering().block_street}}
                                                <template v-if="getVolunteering().building_name">
                                                    <br>
                                                    {{getVolunteering().building_name}}
                                                    {{getVolunteering().building_unit_number ? ' - ' +
                                                    getVolunteering().building_unit_number : '' }}
                                                </template>
                                            </p>
                                        </div>
                                        <hr class="hr">
                                        <div
                                            class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                            <div class="rounded-card__head rounded-card__head--white">
                                                <h3 class="h3 font-dark-grey">Points To Note</h3>
                                            </div>
                                            <div class="rounded-card__body font-dark-grey">
                                                <p v-html="getVolunteering().points_to_note"></p>
                                                <div class="mt-16"><span class="bold">Your request will go through an approval process by our Volunteer Manager or Volunteer Leader</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="hr">
                                        <div class="input-ctrl">
                                            <label class="lbl">
                                                <h3
                                                    class="h3 font-dark-grey font-16-tablet-portrait-down">Personal
                                                    details</h3>
                                                <p class="body-txt body-txt--small mb-16">We need the following
                                                    details from you to sign up! </p></label>
                                        </div>
                                        <div class="input-ctrl"
                                             v-if="modalData[modalNames.signUpVolunteer].need_date_of_birth">
                                            <label class="lbl">Date of Birth
                                            </label>
                                            <input id="volunteer-date-picker" name="date_of_birth"
                                                   placeholder="DD M, YYYY" maxlength="10" type="text"
                                                   :data-value="''"
                                                   class="input-ctn" readonly="" aria-haspopup="true"
                                                   aria-expanded="false" aria-readonly="false"
                                                   aria-owns="date_of_birth">
                                            <label style="display: block"
                                                   class="error-msg">{{ validated().your_date_of_birth ||
                                                validated().your_minimum_age }}</label>
                                        </div>
                                        <div class="input-ctrl"
                                             v-if="getVolunteering().volunteer_contact_phone_number==='yes'">
                                            <label class="lbl">Contact Number
                                            </label>
                                            <input
                                                v-model="modalData[modalNames.signUpVolunteer].model.volunteer_contact_phone_number"
                                                type="text" class="input-ctn" placeholder="Phone Number"
                                                name="contactNumber">
                                            <label style="display: block"
                                                   class="error-msg">{{ validated().volunteer_contact_phone_number
                                                }}</label>
                                        </div>

                                        <div class=" input-ctrl"
                                             v-if="!$utils.isEmptyVar(getVolunteering().other_response_required)"><h3
                                            class="h3 font-dark-grey font-16-tablet-portrait-down">Other
                                            Information</h3>
                                            <p class="body-txt body-txt--small mb-16">
                                                {{getVolunteering().other_response_required}}</p>
                                            <TextareaLimit ref="questionResponse-textarea-limit"
                                                           :height="70" classes="m-0" max="500" rows="3"
                                                           placeholder="Is there anything else you'd like the organiser to know about you?"
                                                           v-model="modalData[modalNames.signUpVolunteer].model.other_response_answer"/>
                                            <label style="display: block;" class="error-msg">{{
                                                validated().other_response_answer }}</label></div>
                                    </form>
                                </div>
                                <!--END FORM-->
                                <div class="create-volunteer-act__footer"
                                     style="margin-top: 80px!important; text-align:center;">
                                    <button v-if="!modalData[modalNames.signUpVolunteer].loading" @click="SignUpVolunteer()"
                                            class="button-ctn button--135 button--large join-volunteer-button">JOIN
                                    </button>
                                    <button v-else
                                            class="button-ctn button--135 button--large join-volunteer-button">SIGNING...
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

        <modal id="volunteer-signup-modal" transition="pop-out" :name="modalNames.signUpVolunteerSuccess"
               classes="modal-ctn"
               :width="modalWidth"
               height="auto"
               :scrollable="true"
               @before-open="beforeOpen"
               @before-close="beforeClose">
            <div class="content-area">
                <div class="site-main activity">
                    <div class="modal-header-ctn">
                        <div class="cursor" @click="hide(modalNames.signUpVolunteerSuccess, {close: true})">
                            <i class="material-icons close-modal-ctn">close</i>
                        </div>
                        <h3 class="h3">&nbsp;</h3>
                    </div>
                    <div class="height-auto">
                        <div class="form">
                            <div class="modal-header-ctn">
                                <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg"
                                     class="profile-pic profile-pic--small mr-16">
                                <h4 class="h2">Thank you, Bee Organization</h4>
                                <p class="body-txt body-txt--small mb-16">for signing up for this activity!</p>
                            </div>

                            <div
                                style="max-width: 100%;margin-left: 5px;margin-right: 5px;"
                                class="rounded-card rounded-card--no-pad rounded-card--light-shadow rounded-card--height-auto">

                                <div
                                    class="rounded-card__body rounded-card__body--responsive">

                                    <div
                                        class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                        <div class="rounded-card__head rounded-card__head--white"><h3
                                            class="h3 font-dark-grey">SIGNUP INFO</h3></div>
                                        <div class="rounded-card__body font-dark-grey"><h3
                                            class="h3 font-dark-grey font-16-tablet-portrait-down">Signup Date</h3>
                                            <p class="body-txt body-txt--small mb-16">08 May 2019</p>
                                            <h3 class="h3 font-dark-grey font-16-tablet-portrait-down">Signup Time</h3>
                                            <p class="body-txt body-txt--small mb-16">01:25 PM</p>
                                            <h3 class="h3 font-dark-grey font-16-tablet-portrait-down">Contact
                                                Number</h3>
                                            <p class="body-txt body-txt--small mb-16">030984832</p>
                                            <h3 class="h3 font-dark-grey font-16-tablet-portrait-down">Gender</h3>
                                            <p class="body-txt body-txt--small mb-16">MALE</p>
                                            <h3 class="h3 font-dark-grey font-16-tablet-portrait-down ">Status</h3>
                                            <p class="body-txt body-txt--small mb-16 font-orange">PENDING APPROVAL</p>
                                            <h3 class="h3 font-dark-grey font-16-tablet-portrait-down ">Signup
                                                Slot(s)</h3>
                                            <p class="body-txt body-txt--small mb-16">1</p></div>
                                    </div>

                                    <div
                                        class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                        <div class="rounded-card__head rounded-card__head--white"
                                             id="yui_patched_v3_11_0_1_1557293114053_1154">
                                            <h3 class="h3 font-dark-grey">
                                                ACTIVITY</h3></div>
                                        <div class="rounded-card__body font-dark-grey"><h2
                                            class="h2 volunteer-event__title">FOH Volunteers for
                                            TheatreWorks' Production 2</h2>
                                            <div class="volunteer-event__venue">
                                                <div class="flag-obj volunteer-event__venue-item">
                                                    <div class="flag-obj__item"><i class="ico material-icons">event</i>
                                                    </div>
                                                    <div
                                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                                        08 May 2019 - 10
                                                        May 2019
                                                    </div>
                                                </div>
                                                <div class="flag-obj volunteer-event__venue-item">
                                                    <div class="flag-obj__item"><i
                                                        class="ico material-icons">query_builder</i></div>
                                                    <div
                                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                                        Fortnightly on
                                                        weekday
                                                        <div class="font-mid-grey body-txt--small">10 hours per
                                                            session
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flag-obj volunteer-event__venue-item">
                                                    <div class="flag-obj__item"><i class="ico material-icons">place</i>
                                                    </div>
                                                    <div
                                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                                        <!-- Kallang -->
                                                        <div class="font-mid-grey body-txt--small"> 88 GEYLANG BAHRU
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flag-obj volunteer-event__venue-item">
                                                    <div class="flag-obj__item"><i class="ico material-icons">group</i>
                                                    </div>
                                                    <div
                                                        class="flag-obj__item flag-obj__item--mid flag-obj__item--narrow flag-obj__item--text">
                                                        Front of House
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                        <div class="rounded-card__body font-dark-grey"><p>We've sent an acknowledgement
                                            of your request to<br> <b>beeostin@gmail.com</b>
                                        </p>
                                        </div>
                                    </div>

                                    <div
                                        class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                        <div class="rounded-card__head rounded-card__head--white"
                                        ><h3 class="h3 font-dark-grey">
                                            CONTACT INFO</h3></div>
                                        <div class="rounded-card__body font-dark-grey">
                                            <div class="volunteer-event__by font-mid-grey"><img
                                                src="https://www.giving.sg/image/organization_logo?img_id=9128818"
                                                class="profile-pic profile-pic--small mr-16"> <span class="bold">Bee Organisation</span>
                                            </div>
                                            <h4 class="mt-16">Mr Front of
                                                House, Front of House</h4>
                                            <div class="mb-16 mt-16">
                                                <i class="ico material-icons gray mr-6">call</i>
                                                <a href="tel:68017449"
                                                   class="text-link text-link--dark-grey"
                                                >029483893</a>
                                            </div>
                                            <div class="mb-16"><i class="ico material-icons gray mr-6">email</i><a
                                                class="text-link text-link--dark-grey" href="mailto:bee@gmail.com"
                                            >bee@gmail.com</a></div>
                                        </div>
                                    </div>

                                    <div
                                        class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                        <div class="rounded-card__head rounded-card__head--white"
                                        ><h3 class="h3 font-dark-grey">
                                            TELL YOUR FRIENDS AND FAMILY</h3>
                                            <p class="non-printable" style="color: #666666; font-weight: normal;">Make
                                                giving a part of who
                                                we are</p></div>
                                        <div class="rounded-card__body font-dark-grey share-box"><a
                                            class="cursor" href="javascript: void(0);"
                                            title="Facebook"><i
                                            class="fab fa-facebook-square"></i></a> <a
                                            class="cursor" href="javascript: void(0);"
                                            title="Tweet"><i
                                            class="fab fa-twitter-square"></i></a> <a
                                            class="cursor" href="javascript: void(0);"
                                            title="LinkedIn" target="_blank"><i class="fab fa-linkedin"></i></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    const MODAL_WIDTH = 858, SCROLL_WIDTH = 32;
    import {mapActions, mapGetters, mapMutations, mapState} from 'vuex'
    import TextareaLimit from '@com/Utils/TextAreaLimiter.vue'

    export default {
        name: "Modals",
        components: {
            TextareaLimit
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            modalNames: {
                login: 'signin',
                signUpVolunteer: 'volunteer-signup',
                signUpVolunteerSuccess: 'volunteer-signup-success'
            },
            modalWidth: MODAL_WIDTH,
            user: {},
            excludeOutSideClose: {'volunteer-signup': true},
            modalData: {'volunteer-signup': {datePicker: null, model: {}}},
        }),
        computed: {
            ...mapState(['authUserInfo']),
        },
        watch: {
            '$route.path': function (n, o) {
                for (let m in this.modalNames) {
                    if (this.modalNames.hasOwnProperty(m)) {
                        this.hide(this.modalNames[m], {close: true});
                    }
                }
            }
        },
        methods: {
            ...mapMutations(['setClearValidate']),
            ...mapActions(['Login', 'postSignUpVolunteering']),
            beforeOpen(e) {
                this.jq("html").addClass("hidden sidebar");
                this.jq("body").addClass("hidden sidebar");
                this.modalData[e.name] = e.params;
            },
            LoginUser(credentials) {
                this.Login(credentials);
            },
            beforeClose(e) {
                /*
                Stopping close event execution
                */
                if (this.excludeOutSideClose[e.name] && !(e.params && e.params.close)) {
                    e.stop();
                    return;
                }
                this.setClearValidate(this.modalData[e.name]);
                this.setClearValidate(this.modalData[e.name].model);
                this.modalData[e.name] = {};
                this.jq("body").removeClass("hidden sidebar");
                this.jq("html").removeClass("hidden sidebar");
            },
            hide(n, params) {
                this.$modal.hide(n, params);
            },
            show(n, params) {
                this.$modal.show(n, params);
            },
            loginForm() {
                this.jq('[data-toggle="tooltip"]').tooltip();
            },
            //volunteering activity
            volunteerForm() {
                this.setDatePicker(new Date().toLocaleDateString())
            },
            setDatePicker(date) {
                let data = this.modalData[this.modalNames.signUpVolunteer];
                let dateOfBirthPickerEl = this.jq('#volunteer-date-picker');
                const volunteerForm = this.$refs['volunteer-form'],
                    formHeight = volunteerForm.clientHeight;
                dateOfBirthPickerEl.on('mousedown', function (e) {
                    e.preventDefault();
                });
                if (!dateOfBirthPickerEl.length) {
                    data.datePicker = null;
                    return;
                }
                this.$nextTick(() => {
                    if (data.datePicker) {
                        let picker = dateOfBirthPickerEl.pickadate('picker');
                        if (date) {
                            picker.set('select', new Date(date));
                        } else {
                            picker.clear();
                        }
                        return;
                    }
                    data.datePicker = dateOfBirthPickerEl.pickadate({
                        selectMonths: true,
                        selectYears: 80,
                        formatSubmit: 'dd/mm/yyyy',
                        today: false,
                        max: new Date(),
                        onOpen: () => {
                            setTimeout(() => {
                                // const pickerHeight = this.jq('.picker__holder').height(),
                                //     percent = pickerHeight - (pickerHeight * 30 / 100);
                                volunteerForm.style.height = `${formHeight + 30}px`;
                            }, 100);
                        },
                        onSet: function () {
                            data.model.your_date_of_birth = this.get('select', 'yyyy-mm-dd');
                            //console.log(this.get('select', 'yyyy-mm-dd'))
                        }
                    });
                })
            },
            SignUpVolunteer() {
                let data = this.modalData[this.modalNames.signUpVolunteer];
                let which = this.getVolunteeringWhichPosition();
                data.model.other_response_answer = data.model.other_response_answer;
                if (which !== 'all') {
                    data.model.volunteer_position = which;
                } else if (!this.isMultiplePositions()) {
                    data.model.volunteer_position = this.getVolunteeringSelectedPosition().id;
                }
                if (data.need_date_of_birth) {
                    data.model.your_date_of_birth = data.model.your_date_of_birth;
                }
                //submit form
                data.loading = true;
                this.postSignUpVolunteering(data).then(res => {
                    data.loading = false;
                    console.log(res);
                    this.hide(this.modalNames.signUpVolunteer, {close: true});
                    this.show(this.modalNames.signUpVolunteerSuccess);
                }).catch(err => {
                    data.loading = false;
                });
            },
            getVolunteeringWhichPosition() {
                return this.modalData[this.modalNames.signUpVolunteer].position
            },
            getVolunteering() {
                return this.modalData[this.modalNames.signUpVolunteer].activity || {}
            },
            checkingVolunteeringPosition() {
                let data = this.modalData[this.modalNames.signUpVolunteer];
                this.setVolunteeringPosition(data.model.volunteer_position);
                //wait view render
                data.model.your_date_of_birth = null;
                this.$nextTick(() => {
                    this.setDatePicker();
                });
            },
            setVolunteeringPosition(compare) {
                let data = this.modalData[this.modalNames.signUpVolunteer];
                let position = this.getVolunteering().positions.filter(p => {
                    return p.id === compare;
                }).shift();
                data.need_date_of_birth = position.minimum_age && parseInt(position.minimum_age) > 12;
                return position
            },
            getVolunteeringSelectedPosition() {
                let which = this.getVolunteeringWhichPosition();
                if (!this.$utils.isEmptyVar(which)) {
                    if (which !== 'all') {
                        return this.setVolunteeringPosition(which);
                    } else if (!this.isMultiplePositions()) {
                        which = (this.getVolunteering().positions[0] || {}).id;
                        return this.setVolunteeringPosition(which);
                    }
                }
                return {};
            },
            isMultiplePositions() {
                let data = this.modalData[this.modalNames.signUpVolunteer];
                return data.position === 'all' && data.activity.positions.length > 1;
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
            //volunteering activity
        },
        created() {
            let wWidth = this.jq(document).width();
            this.modalWidth = wWidth - SCROLL_WIDTH < MODAL_WIDTH
                ? wWidth - ((wWidth + SCROLL_WIDTH) * 8 / 100)
                : MODAL_WIDTH;
        }
    }
</script>

<style lang="scss">

    .pop-out-enter-active,
    .pop-out-leave-active {
        transition: all 0.5s;
    }

    .pop-out-enter,
    .pop-out-leave-active {
        opacity: 0;
        transform: translateY(24px);
    }
</style>
