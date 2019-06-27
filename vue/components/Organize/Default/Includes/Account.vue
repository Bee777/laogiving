<template>
    <div class="cWidth-1200 mt-40 mb-40">

        <div
            class="rounded-card rounded-card__body--responsive rounded-card--height-auto rounded-card--full rounded-card--clean-tablet-portrait-down account">
            <div class="rounded-card__body rounded-card__body--responsive rounded-card__body">
                <form @submit.prevent>
                    <h3 class="h3 mb-8 font-dark-grey">Basic Info</h3>
                    <div class="input-ctrl">
                        <label class="lbl">Logo</label>
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
                        <label style="display: block"
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
                        <label style="display: block" for="displayName"
                               class="error-msg">{{validated().display_name}}</label>
                    </div>

                    <div class="input-ctrl success">
                        <div class="datepicker clearfix">
                            <label class="lbl"
                                   for="dateOfBirth">Organisation/Group
                                Registration Date
                            </label>
                            <div class="controls">
                                <input
                                    type="text" class="input-ctn pickadate-datepicker picker__input valid"
                                    name="dateOfBirth" id="dateOfBirth"
                                    placeholder="dd/mm/yyyy" maxlength="10"
                                    :data-value="userProfile.registration_date_formatted"
                                    readonly="">

                            </div>
                            <label style="display: block"
                                   class="error-msg">{{ validated().registration_date }}</label>
                        </div>
                    </div>

                    <hr class="hr">

                    <form class="form" novalidate="novalidate">
                        <h3 class="h3 mb-8 font-dark-grey">Organisation/Group Information</h3>

                        <div class="input-ctrl success"><label
                            class="lbl" for="employeeSize">Employee/Group Size </label>
                            <div class="controls"><select
                                v-model="userProfile.group_size"
                                name="employeeSize"
                                class="select-ctn select--full select-giving span12 valid"
                                id="employeeSize">
                                <option value="0" disabled="">Select employee/group size</option>
                                <option value="10">1 - 10</option>
                                <option value="50">11 - 50</option>
                                <option value="200">51 - 200</option>
                                <option value="201">Over 200</option>
                            </select>
                                <label for="employeeSize" class="error-msg"
                                       style="display: block;">{{ validated().group_size }}</label></div>
                        </div>

                        <hr class="hr">
                    </form>

                    <form class="form" novalidate="novalidate">
                        <h3 class="h3 mb-8 font-dark-grey">Address</h3>
                        <div class="input-ctrl">
                            <label class="lbl" for="address">Current</label>
                            <textarea v-model="userProfile.address" maxlength="150" rows="5" class="textarea-ctn"
                                      id="address">{{userProfile.address}}</textarea>
                            <label for="address" class="error-msg"
                                   style="display: block;">{{ validated().address }}</label>
                        </div>

                        <hr class="hr">
                    </form>

                    <form class="form" novalidate="novalidate">
                        <h3 class="h3 mb-8 font-dark-grey">About Organisation/Group</h3>
                        <div class="input-ctrl">
                            <label class="lbl" for="summary">Description
                                of Organisation/Group
                            </label>
                            <div class="controls">
                                <textarea v-model="userProfile.about" class="span12 textarea-ctn" rows="8"
                                          style="height: 250px"
                                          name="summary" id="summary"
                                          placeholder="Describe your organisation" maxlength="1500">{{userProfile.about}}</textarea>
                                <label :style="`opacity: ${(userProfile.about || '').length > 0 ? '':'0'};`"
                                       id="summary-count">
                                    Maximum 1500 characters ( {{ 1500 - (userProfile.about
                                    || '').length}} remaining )</label>
                                <label for="summary" style="display: block;"
                                       class="help-block error-msg">{{ validated().about }}</label>
                            </div>
                        </div>

                        <hr class="hr">
                    </form>

                    <h3 class="h3 font-dark-grey">Our Causes</h3>
                    <div v-if="validated().user_causes" style="display:block;" class="error-msg">You have not select
                        anything
                    </div>
                    <label class="lbl">Please select at least ONE and at most FOUR causes</label>

                    <Causes ref="user-causes" :max="4" v-model="userCauses" :items="causes"/>

                    <hr class="hr">
                    <form class="form">
                        <h3 class="h3 mb-8 font-dark-grey">Contact Info</h3>
                        <div class="input-ctrl"><label class="lbl" for="pubEnquiryPerson">Contact
                            Person </label>
                            <div class="controls"><input
                                v-model="userProfile.contact_person"
                                name="pubEnquiryPerson"
                                id="pubEnquiryPerson" placeholder="Contact Person"
                                class="form-control field-required input-ctn" type="text">
                                <label for="pubEnquiryPerson"
                                       class="help-block error-msg"
                                       style="display: block;">{{ validated().contact_person }}</label>
                            </div>
                        </div>
                        <div class="input-ctrl">
                            <label class="lbl" for="email">Email</label> <input
                            v-model="userProfile.public_email"
                            name="email" id="email" placeholder="Public email"
                            class="form-control input-ctn field-required" type="email">
                            <label for="email" style="display: block;" id="emailError"
                                   class="error-msg">{{ validated().public_email }}</label>

                        </div>
                        <div class="input-ctrl">
                            <label class="lbl" for="pubEnquiryContact">Contact Number
                            </label>
                            <div class="controls">
                                <input name="pubEnquiryContact"
                                       v-model="userProfile.phone_number"
                                       id="pubEnquiryContact" placeholder="Contact Number"
                                       class="form-control input-ctn" type="text">
                                <label for="pubEnquiryContact" style="display: block;"
                                       class="help-block error-msg">{{ validated().phone_number }}</label>
                            </div>
                        </div>
                        <hr class="hr">
                    </form>

                    <form id="orgOnlineInfo" novalidate="novalidate">
                        <div class="input-ctrl">
                            <label class="lbl" for="webURL">Website (Optional)</label>
                            <div class="controls">
                                <input name="webURL" id="webURL"
                                       v-model="userProfile.website"
                                       placeholder="Website" class="form-control input-ctn"
                                       type="text" value="">
                                <label style="display: block;" for="webURL"
                                       class="help-block error-msg">{{validated().website}}</label>
                            </div>
                        </div>
                        <div class="input-ctrl">
                            <label class="lbl" for="givingUrl">URL in LaoGiving.la</label>
                            <div class="controls">
                                <input name="givingUrl" id="givingUrl"
                                       readonly
                                       v-model="userProfile.website_in_our_site"
                                       placeholder="URL in LaoGiving.la i.e.redcross"
                                       class="form-control input-ctn" type="text"
                                       value="bee-organisation">
                                <label style="display: block;" for="givingUrl"
                                       id="givingUrlError"
                                       class="help-block error-msg">{{validated().website_in_our_site}}</label>
                            </div>
                        </div>
                        <div class="input-ctrl"><label class="lbl" for="facebookLink">Facebook Link
                            (Optional)</label>
                            <div class="controls"> facebook.com/ <input
                                name="facebookLink" id="facebookLink"
                                v-model="userProfile.facebook"
                                placeholder="e.g. NVPCla" class="form-control p-bot0 input-ctn"
                                type="text" value="" style="width: 78%">
                                <label for="facebookLink" style="display:block;" class="help-block error-msg">{{validated().facebook}}</label>
                            </div>
                        </div>
                        <hr class="hr">
                    </form>


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
                            <input name="confirmNewPassword" placeholder="" class="form-control input-ctn"
                                   type="password"
                                   v-model="userCredential.new_password_confirmation"
                                   maxlength="24">
                            <label
                                style="display:block;"
                                class="error-msg">{{validated().new_password_confirmation}}</label>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <hr class="hr">

                    <div class="text-right text-center-tablet-portrait-down">
                        <button
                            @click="resetProfileData()"
                            class="mr-16 button-ctn button--135 button--ghost button--large">
                            CLEAR
                            <span class="show-tablet-portrait-up-inline">CHANGES</span>
                        </button>
                        <button v-if="!isLoading" @click="saveProfileSettings()"
                                class="button-ctn button--135 button--large">SAVE
                        </button>
                        <button v-else class="button-ctn button--135 button--large">SAVING...
                        </button>

                    </div>

                </form>

            </div>
        </div>

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
                                this.setDatePicker(d.user_profile.registration_date);
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
                dateOfBirthPickerEl.on('mousedown', function (e) {
                    e.preventDefault();
                });
                if (this.datePicker) {
                    let picker = dateOfBirthPickerEl.pickadate('picker');
                    picker.set('select', new Date(date));
                    return;
                }
                this.datePicker = dateOfBirthPickerEl.pickadate({
                    selectMonths: true,
                    selectYears: 80,
                    formatSubmit: 'dd/mm/yyyy',
                    today: false,
                    max: new Date(),
                    onOpen: () => {
                    },
                    onSet: function () {
                        that.setUserProfileKey({key: 'registration_date', value: this.get('select', 'yyyy-mm-dd')});
                        //console.log(this.get('select', 'yyyy-mm-dd'))
                    }
                });

            }
        },
        created() {
            if (this.visible) {
                this.getUserProfile();
            }
        }
    }
</script>

<style scoped>

</style>
