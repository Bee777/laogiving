<template>
    <div class="cWidth-1200 mt-40 mb-40">
        <form @submit.prevent>
            <div
                class="rounded-card rounded-card__body--responsive rounded-card--height-auto rounded-card--full rounded-card--clean-tablet-portrait-down account">
                <div class="rounded-card__body rounded-card__body--responsive rounded-card__body">
                    <h3 class="h3 font-dark-grey">Profile</h3>
                    <hr>
                    <div class="input-ctrl">
                        <label class="lbl">Profile Picture</label>
                        <div class="file-upload file-upload--w270">
                            <div class="file-upload__holder">
                                <div class="file-upload__spacer"></div>
                                <div class="file-upload__image lfr-change-logo">
                                    <img v-if="userProfile.profile_image_base64!==''" class="img-placeholder"
                                         :src="`${userProfile.profile_image_base64}`">
                                    <img v-else class="img-placeholder"
                                         :src="`${baseUrl}${authUserInfo.thumb_image}`">
                                    <a
                                        @click="chooseProfileImage"
                                        class="button-ctn button--small button--icon file-upload__cancel imageUploadBtn"><i
                                        class="ico ico-upload button--icon__icon"></i></a></div>
                                <AdminInput ref="profile-image" v-show="false"
                                            @inputImageBase64="(d)=>userProfile.profile_image_base64=d"
                                            @inputFile="(d)=> userProfile.profile_image=d"
                                            :inputType="'file'"/>
                            </div>
                        </div>
                        <label v-if="validated().profile_image" style="display: block"
                               class="error-msg">{{validated().profile_image}}</label>
                    </div>
                    <div class="input-ctrl">
                        <label class="lbl" for="displayName">Display Name</label>
                        <input type="text"
                               v-model="userProfile.display_name"
                               name="displayName"
                               id="displayName"
                               placeholder="Display name"
                               class="form-control input-ctn field-required">
                        <label v-if="validated().display_name" style="display: block" for="displayName"
                               class="error-msg">{{validated().display_name}}</label>
                    </div>

                    <div class="input-ctrl">
                        <label class="lbl" for="email">Email Address</label> <input
                        name="email" id="email" placeholder="Email"
                        class="form-control input-ctn field-required" type="email"
                        v-model="userProfile.public_email"
                        value="beeostin@gmail.com">
                        <label v-if="validated().public_email" style="display: block" for="email" id="emailError"
                               class="error-msg">{{validated().public_email}}</label>
                    </div>
                    <div class="input-ctrl success">
                        <div class="datepicker clearfix">
                            <label class="lbl"
                                   for="dateOfBirth">Birth Date</label>
                            <div class="controls">
                                <input
                                    type="text" class="input-ctn pickadate-datepicker picker__input valid"
                                    name="dateOfBirth" id="dateOfBirth"
                                    placeholder="dd/mm/yyyy" maxlength="10"
                                    :data-value="userProfile.date_of_birth_formatted"
                                    readonly="">
                            </div>
                            <div class="error">
                                <label v-if="validated().date_of_birth" style="display: block"
                                       class="error-msg">{{ validated().date_of_birth }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix input-ctrl success">
                        <label class="lbl">Salutation</label>
                        <select name="salutation"
                                v-model="userProfile.salutation"
                                class="select-giving1 span12 select-ctn select--full valid" id="user_sal">
                            <option value="none">Please Select</option>
                            <option value="mr" selected="">Mr</option>
                            <option value="ms">Ms</option>
                            <option value="mrs">Mrs</option>
                            <option value="miss">Miss</option>
                            <option value="mdm">Mdm</option>
                            <option value="dr">Dr</option>
                        </select> <label v-if="validated().salutation" for="user_sal" class="error-msg"
                                         style="display: block;">{{ validated().salutation }}</label>
                    </div>
                    <div class="input-ctrl">
                        <label class="lbl">Gender</label>
                        <div class="radio-btn">
                            <label class="radio-btn__lbl"> <input
                                v-model="userProfile.gender"
                                class="radio-btn__radio" type="radio"
                                name="gender" value="male"
                                checked="">
                                <span class="radio-btn__value">Male</span>
                            </label>
                        </div>
                        <div class="radio-btn">
                            <label class="radio-btn__lbl">
                                <input class="radio-btn__radio" type="radio"
                                       v-model="userProfile.gender"
                                       name="gender"
                                       value="female">
                                <span class="radio-btn__value">Female</span>
                            </label>
                        </div>
                    </div>
                    <hr class="hr">
                    <h3 class="h3 font-dark-grey">Contact Details</h3>
                    <div class="input-ctrl"><label class="lbl" for="phoneNo">Contact Number</label>
                        <div class="controls">
                            <input type="text"
                                   v-model="userProfile.phone_number"
                                   name="phoneNo" id="phoneNo" placeholder="Contact number"
                                   class="form-control input-ctn">
                            <label style="display:block;" v-if="validated().phone_number" for="phoneNo"
                                   class="error-msg">{{validated().phone_number}}</label>
                        </div>
                    </div>
                    <hr class="hr">
                    <h3 class="h3 font-dark-grey">My Causes (Optional)</h3>
                    <!--<div class="error-msg">You have not select anything</div>-->
                    <!--Causes-->
                    <Causes ref="user-causes" :max="4" v-model="userCauses" :items="causes"/>
                    <!--End Causes-->
                    <hr class="hr">
                    <h3 class="h3 font-dark-grey passwordLabel">Change Password (Optional)</h3>
                    <div class="input-ctrl passwordLabel " id="controlCurrent">
                        <label class="lbl">Current Password</label>
                        <div class="controls input-ctrl" :class="[{'error': validated().current_password}]">
                            <input name="currentPassword"
                                   v-model="userCredential.current_password"
                                   id="currentPassword" placeholder="" class="form-control input-ctn"
                                   type="password"
                                   maxlength="24">
                            <label for="currentPassword" style="display: block" id="currentPwdError"
                                   class="error-msg">{{validated().current_password}}</label>
                            <span class="help-block"></span><br>
                        </div>
                    </div>

                    <div class="input-ctrl passwordLabel" id="controlNew">
                        <label class="lbl">New Password</label>
                        <div class="controls input-ctrl" :class="[{'error': validated().new_password}]">
                            <input name="newPassword"
                                   v-model="userCredential.new_password"
                                   id="newPassword" placeholder="" class="form-control input-ctn"
                                   type="password"
                                   maxlength="24">
                            <label
                                style="display:block;"
                                class="error-msg">{{validated().new_password}}</label>
                            <span class="help-block"></span><br>
                        </div>
                    </div>

                    <div class="input-ctrl passwordLabel">
                        <label class="lbl">Confirm New Password</label>
                        <div class="controls input-ctrl" :class="[{'error': validated().new_password_confirmation}]">
                            <input
                                v-model="userCredential.new_password_confirmation"
                                name="confirmNewPassword" placeholder="" class="form-control input-ctn"
                                type="password"
                                maxlength="24">
                            <label
                                style="display:block;"
                                class="error-msg">{{validated().new_password_confirmation}}</label>
                            <span class="help-block"></span><br>
                        </div>
                    </div>
                    <div class="text-right text-center-tablet-portrait-down mt-40">
                        <button @click="resetProfileData()"
                                class="mr-16 button-ctn button--135 button--ghost button--large">
                            CLEAR
                            <span class="show-tablet-portrait-up-inline">CHANGES</span>
                        </button>
                        <button v-if="!isLoading" @click="saveProfileSettings()" class="button-ctn button--135 button--large">SAVE
                        </button>
                        <button v-else  class="button-ctn button--135 button--large">SAVING...
                        </button>

                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Causes from '@com/Utils/Causes.vue'
    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'

    export default {
        name: "Account",
        components: {
            Causes
        },
        props: {
            visible: {
                default: false
            }
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            userCredential: {},
            userCauses: [],
            isLoading: false,
            causes: [],
            datePicker: null,
        }),
        watch: {
            visible: function (n) {
                if (n) {
                    this.getUserProfile();
                }
            }
        },
        computed: {
            ...mapState(['authUserInfo', 'userProfile']),
        },
        methods: {
            ...mapMutations(['setClearValidate', 'setUserProfile', 'setUserProfileKey']),
            ...mapActions(['showErrorToast', 'showInfoToast', 'postManageUserProfile', 'postChangeCredentialsUser', 'fetchAuthUserInfo', 'fetchOptionProfileData']),
            resetProfileData() {
                this.setClearValidate(this.userProfile);
                this.setClearValidate(this.userCredential);
                this.userCredential = {};
                this.getUserProfile();
                this.$utils.scrollToY('html,body', 292);
            },
            chooseProfileImage() {
                this.$refs['profile-image'].triggerInputClick();
            },
            saveProfileSettings() {
                let dt = 3500;
                this.isLoading = true;
                this.setUserProfileKey({key: 'user_causes', value: this.userCauses});

                if (!this.$utils.isEmptyObject(this.userCredential)) {
                    this.saveUserCredentials();
                    return;
                }

                this.postManageUserProfile(this.userProfile)
                    .then(res => {
                        if (res.success) {
                            this.showInfoToast({msg: 'Your profile was updated!', dt});
                            this.getUserProfile();
                            this.$utils.scrollToY('html,body', 292);
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to update your profile!', dt});
                        this.isLoading = false;
                    })
            },
            saveUserCredentials() {
                let dt = 3500;
                this.isLoading = true;
                this.postChangeCredentialsUser(this.userCredential)
                    .then(res => {
                        if (res.success) {
                            this.getUserProfile();
                            this.userCredential = {};
                            this.showInfoToast({msg: 'Your credentials was updated!', dt});
                        } else {
                            this.showErrorToast({msg: 'Failed to update your credentials!', dt});
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to update your credentials!', dt});
                        this.isLoading = false;
                    });
            },
            getUserProfile() {
                this.fetchOptionProfileData()
                    .then(res => {
                        let s = res.success, d = res.data;
                        if (s) {
                            if (!this.$utils.isEmptyVar(d.user_profile)) {
                                this.setUserProfile(d.user_profile);
                            } else {
                                this.setUserProfileKey({key: 'display_name', value: d.name});
                                this.setUserProfileKey({key: 'public_email', value: d.email});
                            }
                            this.userCauses = d.user_causes;
                            this.$refs['user-causes'].setValue(this.userCauses);
                            this.causes = d.causes;
                            this.fetchAuthUserInfo();
                            this.$nextTick(() => {
                                this.setDatePicker(this.userProfile.date_of_birth);
                            })
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to load your profile!', dt: 3500});
                        this.isLoading = false;
                    })
            },
            setDatePicker(date) {
                let that = this;
                let dateOfBirthPickerEl = this.jq('#dateOfBirth');
                if (this.datePicker) {
                    let picker = dateOfBirthPickerEl.pickadate('picker');
                    picker.set('select', new Date(date));
                    return;
                }
                dateOfBirthPickerEl.on('mousedown', function (e) {
                    e.preventDefault();
                });
                this.datePicker = dateOfBirthPickerEl.pickadate({
                    selectMonths: true,
                    selectYears: 80,
                    formatSubmit: 'dd/mm/yyyy',
                    today: false,
                    max: new Date(),
                    onOpen: () => {
                    },
                    onSet: function(){
                        that.setUserProfileKey({key: 'date_of_birth', value: this.get('select', 'yyyy-mm-dd')});
                        //console.log(this.get('select', 'yyyy-mm-dd'))
                    }
                });
            }
        },
        created() {
            this.getUserProfile();
        },

    }
</script>

<style scoped>

</style>
