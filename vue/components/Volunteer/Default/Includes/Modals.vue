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
                        <form name="loginform" v-on:submit.prevent method="post">
                            <label> Email
                                <input autocomplete="username email" name="email" value="" type="text"></label>
                            <label>
                                Password <span class="tooltip__mark" data-toggle="tooltip" data-placement="right"
                                               title="Your password must be between 8-24 characters with at least one number. Only special characters @$!%*?&amp;+-.=^_|~ are accepted.">?</span>
                                <input autocomplete="current-password" name="password" value="" type="password">
                            </label>
                            <label class="mb-16"><a>Forgot Password?</a></label>
                            <button class="button-ctn button--large button--full">Login</button>
                            <p class="p-modal-footer"> Don't have an account? <a @click="Route({name: 'register-overview'})" class="cursor">Create an Account</a> now! </p>
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
                                <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg"
                                     class="profile-pic profile-pic--small mr-16"
                                     id="yui_patched_v3_11_0_1_1556981879776_1415">
                                <h4 class="h2">Hello, Bee Organization</h4>
                                <p class="body-txt body-txt--small mb-16">You are signing up as <b>Individual</b>.</p>
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
                                            <h3 class="h3 mt-16 font-dark-grey">Front of House</h3>
                                            <h3 class="h3 mt-16 font-dark-grey" style="font-weight:normal;">for</h3>
                                            <h3 class="h3 mt-16 font-dark-grey">FOH Volunteers for TheatreWorks'
                                                Production</h3>
                                            <h3 class="h3 mt-16 mb-16 font-dark-grey" style="font-weight:normal;">
                                                on</h3>
                                            <h3 class="h3 mb-16 font-dark-grey">21 May 2019 - 30 May 2019</h3>
                                            <p class="body-txt mb-16"><span><b>12:00 AM to 12:00 AM</b></span> <br> <br>at
                                                88 GEYLANG BAHRU </p>
                                        </div>
                                        <hr class="hr">
                                        <div
                                            class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                            <div class="rounded-card__head rounded-card__head--white">
                                                <h3 class="h3 font-dark-grey">Points To Note</h3>
                                            </div>
                                            <div class="rounded-card__body font-dark-grey">
                                                <p>We are looking for volunteers to help out with FOH duties such as
                                                    sale of programmes, answering enquires, and ushering. Volunteers
                                                    will also assist in carrying out other duties such as headphones
                                                    distributions, drinks services and managing sale of accessories.</p>
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
                                        <div class="input-ctrl">
                                            <label class="lbl">Date of Birth
                                            </label>
                                            <input id="volunteer-date-picker" name="date_of_birth"
                                                   :data-value="`${new Date().getFullYear()}/01/01`"
                                                   placeholder="DD M, YYYY" maxlength="10" type="text"
                                                   class="input-ctn" readonly="" aria-haspopup="true"
                                                   aria-expanded="false" aria-readonly="false"
                                                   aria-owns="date_of_birth">
                                        </div>
                                        <div class="input-ctrl">
                                            <label class="lbl">Contact Number
                                            </label>
                                            <input type="text" class="input-ctn" placeholder="" name="contactNumber"
                                                   value="030984832">
                                        </div>
                                    </form>
                                </div>
                                <!--END FORM-->
                                <div class="create-volunteer-act__footer"
                                     style="margin-top: 80px!important; text-align:center;">
                                    <button class="button-ctn button--135 button--large join-volunteer-button">JOIN
                                    </button>
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
    export default {
        name: "Modals",
        data: () => ({
            modalNames: {login: 'signin', signUpVolunteer: 'volunteer-signup'},
            modalWidth: MODAL_WIDTH,
        }),
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
            beforeOpen(e) {
                this.jq("html").addClass("hidden sidebar");
                this.jq("body").addClass("hidden sidebar");
            },
            beforeClose(e) {
                /*
                Stopping close event execution
                */
                if (e.name === "volunteer-signup" && !(e.params && e.params.close)) {
                    e.stop();
                    return;
                }
                this.jq("body").removeClass("hidden sidebar");
                this.jq("html").removeClass("hidden sidebar");
            },
            hide(n, params) {
                this.$modal.hide(n, params);
            },
            loginForm() {
                this.jq('[data-toggle="tooltip"]').tooltip();
            },
            volunteerForm() {
                const volunteerForm = this.$refs['volunteer-form'],
                    formHeight = volunteerForm.clientHeight;
                setTimeout(() => {
                    let pickerEl = this.jq('#volunteer-date-picker');
                    pickerEl.on('mousedown', function (e) {
                        e.preventDefault();
                    });
                    pickerEl.pickadate({
                        selectMonths: true,
                        selectYears: 80,
                        formatSubmit: 'yyyy-mm-dd',
                        max: new Date(),
                        onOpen: () => {
                            setTimeout(() => {
                                const pickerHeight = this.jq('.picker__holder').height(),
                                    percent = pickerHeight - (pickerHeight * 26 / 100);
                                volunteerForm.style.height = `${formHeight + percent}px`;
                            }, 100);
                        },
                        onClose: function () {
                            console.log(this.get('select', 'yyyy-mm-dd'))
                        }
                    });
                }, 300)
            }
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
