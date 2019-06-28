<template>
    <div class="ctn">
        <div class="cWidth-1200 flex-ctn flex-ctn--just-end mt-24  clearfix">
            <div class="grid-12 grid-tablet-landscape-up-4-last text-center">
                <button @click="resetProfileData()"
                        class="button-ctn button--ghost button--min-width mr-16">CANCEL
                </button>
                <button v-if="!isLoading" @click="saveProfileSettings()" class="button-ctn button--min-width">SAVE
                </button>
                <button v-else class="button-ctn button--min-width">SAVING...</button>
            </div>
        </div>
        <div class="cWidth-1200 clearfix">
            <section class="company-profile__body ctn clearfix">
                <div class="company-profile__main company-profile__options">
                    <!--Images-->
                    <div class="ctn company-profile__edit-carousel clearfix">
                        <!--<div class="ctn gallery gallery-tablet-portrait-up-6">-->


                        <!--<div class="file-upload gallery__item">-->
                        <!--<div class="file-upload__holder">-->
                        <!--<div class="file-upload__spacer"></div>-->
                        <!--<div class="file-upload__video">-->
                        <!--<div class="file-upload__video-icon">-->
                        <!--<div class="video_icon_container">-->
                        <!--<i class="video_icon material-icons">videocam</i>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="error-msg video-upload" style="display:none;">Please upload a valid-->
                        <!--youtube link-->
                        <!--</div>-->
                        <!--<div class="input-ctrl input-ctrl&#45;&#45;full"><label class="lbl"><p-->
                        <!--class="body-txt body-txt&#45;&#45;small mb-0">Add YouTube video (optional)</p>-->
                        <!--</label>-->
                        <!--<input type="text" class="input-ctn" name="orgVideo" value=""-->
                        <!--placeholder="Enter YouTube link e.g. https://www.youtube.com/watch?v=gXLkWYR_JI">-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="file-upload__lbl bold font-black body-txt body-txt&#45;&#45;small">SLIDE 1</div>-->
                        <!--</div>-->


                        <!--<div class="file-upload gallery__item item image-upload-div">-->
                        <!--<div class="file-upload__holder" data-index="1">-->
                        <!--<div class="file-upload__spacer"></div>-->
                        <!--<div class="file-upload__image">-->
                        <!--<img class="img-placeholder"-->
                        <!--src="https://www.giving.sg/image/logo?img_id=9128828">-->
                        <!--<div><a-->
                        <!--class="file-upload__upload-btn imageUploadBtn upload-image-button hide">-->
                        <!--<i class="ico ico-upload"></i>-->
                        <!--<div class="file-upload__upload-btn-text">UPLOAD IMAGE</div>-->
                        <!--</a></div>-->
                        <!--<a class="button-ctn button&#45;&#45;small button&#45;&#45;icon file-upload__cancel remove-image-button show">-->
                        <!--<i style="color: #ffffff;" class="ico material-icons button&#45;&#45;icon__icon">close</i></a>-->
                        <!--<div class="error-msg img-upload" style="display:none;">-->
                        <!--You need to upload at least one image-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="file-upload__lbl bold font-black body-txt body-txt&#45;&#45;small">SLIDE 2</div>-->
                        <!--</div>-->

                        <!--<div class="file-upload gallery__item item image-upload-div" v-for="i in 4" :key="i">-->
                        <!--<div class="file-upload__holder" data-index="2">-->
                        <!--<div class="file-upload__spacer"></div>-->
                        <!--<div class="file-upload__image">-->
                        <!--<img class="img-placeholder" src=""-->
                        <!--id="orgImg2Uploaded"-->
                        <!--name="orgImg2Uploaded">-->
                        <!--<div id="ImageTemplate2"><a-->
                        <!--class="file-upload__upload-btn imageUploadBtn upload-image-button show">-->
                        <!--<i class="ico ico-upload"></i>-->
                        <!--<div class="file-upload__upload-btn-text">UPLOAD IMAGE</div>-->
                        <!--</a></div>-->
                        <!--<a class="button button&#45;&#45;small button&#45;&#45;icon file-upload__cancel remove-image-button hide">-->
                        <!--<i class="ico material-icons button&#45;&#45;icon__icon">close</i></a>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="file-upload__lbl bold font-black body-txt body-txt&#45;&#45;small">SLIDE{{ 2+i }}-->
                        <!--</div>-->
                        <!--</div>-->


                        <!--</div>-->

                        <MediaGallery @setImageSrc="serImageSrcData" @clearImageSrc="clearImageSrcData" ref="media-gallery"
                                      v-model="user_media"/>

                    </div>
                    <!--ENDImages-->
                    <button @click="AddMedia()" v-if="user_media.images.length <= ImageLimit"
                            class="button-ctn button--with-icon button--no-bg button--large button--no-left-pad">
                        <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                            class="ico ico-add  button--with-icon__icon"></i> ADD IMAGE
                        </div>
                    </button>
                    <!--Description-->
                    <div>
                        <div class="company-profile__description">
                            <form id="about-program-form" novalidate="novalidate">

                                <AccordionCard containerClasses="accordion-card--borderless">
                                    <template slot="header-title">
                                        <h3 class="h3">About Us</h3>
                                    </template>
                                    <template slot="body-content">
                                        <div class="edit-description">
                                            <TextareaLimit ref="about-textarea-limit" max="1500"
                                                           v-model="userProfile.about"
                                                           rows="11"/>
                                            <div class="control-group">
                                                <label style="display: block;" class="help-block error-msg">{{
                                                    validated().about
                                                    }}</label>
                                            </div>

                                        </div>
                                    </template>
                                </AccordionCard>

                                <AccordionCard containerClasses="accordion-card--borderless mb-16">
                                    <template slot="header-title">
                                        <h3 class="h3">Our Programmes</h3>
                                    </template>
                                    <template slot="body-content">
                                        <div class="edit-description">
                                            <TextareaLimit ref="program-textarea-limit" max="1500"
                                                           v-model="userProfile.our_programmes"
                                                           rows="11"/>
                                            <div class="control-group">
                                                <label style="display: block;" class="help-block error-msg">{{
                                                    validated().our_programmes
                                                    }}</label>
                                            </div>

                                        </div>
                                    </template>
                                </AccordionCard>

                            </form>
                        </div>
                    </div>
                    <!--Description-->
                </div>
                <!--@ENDLEFTSIDE-->
                <!--Right Side-->
                <div class="company-profile__causes-contact mt-0">
                    <!--VISION-->

                    <AccordionCard containerClasses="mb-16">
                        <template slot="header-title">
                            <h6 class="h6">VISION &amp; MISSION</h6>
                        </template>
                        <template slot="body-content">
                            <form novalidate="novalidate">
                                <TextareaLimit ref="vision_mission-textarea-limit" max="150"
                                               height="110"
                                               placeholder="Describe your organisation/group's vision/mission in 150 characters.

e.g: Our organisation is committed to the welfare of youth-at-risk"
                                               v-model="userProfile.vision_mission"
                                               rows="5"/>
                                <label class="error-msg"
                                       style="display: block;">{{
                                    validated().vision_mission
                                    }}</label>
                                <!--<div class="box-footer clearfix">-->
                                <!--<p class="">You can type <span-->
                                <!--class="char-count">150</span> characters more</p></div>-->
                            </form>
                        </template>
                    </AccordionCard>

                    <!--VISION-->
                    <!--SUPPORT CAUSES-->
                    <AccordionCard>
                        <template slot="header-title">
                            <h6 class="h6">SUPPORTED
                                CAUSES</h6>
                        </template>
                        <template slot="body-content">
                            <div v-if="validated().user_causes" style="display:block;" class="error-msg">You have not
                                select
                                anything
                            </div>
                            <div id="causes-wrapper"><p class="body-txt" id="causes-title">Please select up to 4 causes
                                <span id="causes-error"></span></p>
                                <Causes ref="user-causes" :max="4" v-model="userProfile.user_causes"
                                        :items="userProfile.causes"/>
                            </div>
                        </template>
                    </AccordionCard>
                    <!--@SUPPORt CAUSES-->
                    <!--FormContact-->
                    <form id="donation-userDetails" novalidate="novalidate">

                        <AccordionCard containerClasses="mb-16">
                            <template slot="header-title">
                                <h6 class="h6">CONTACT US</h6>
                            </template>
                            <template slot="body-content">
                                <!--@START IMAGE PROFILE-->
                                <div>
                                    <div class="border-round link-box">
                                        <a @click="toggleClearImage()"
                                           :class="[{'hide': clearImage, 'show': !clearImage}]"
                                           class="button-ctn notBlue float_right button--small button--icon replace-image-button ">
                                            <i class="ico material-icons button--icon__icon ">close</i>
                                        </a>
                                        <div class="lfr-change-logo">
                                            <img v-show="clearImage && userProfile.profile_image_base64===''"
                                                 :src="`${baseUrl}/assets/images/preview.png`"
                                                 id="orgLogoUploadedPreview">
                                            <img v-show="clearImage && userProfile.profile_image_base64!==''"
                                                 :src="userProfile.profile_image_base64"
                                                 id="orgLogoUploaded">
                                            <img v-show="!clearImage" class="img-placeholder"
                                                 id="orgLogoUploaded"
                                                 :src="`${baseUrl}${authUserInfo.image}`">
                                        </div>
                                        <a
                                            @click="chooseProfileImage"
                                            :class="[{'hide': !clearImage}]"
                                            class="file-upload__upload-btn upload-image-button mt-8"> <i
                                            class="ico ico-upload"></i>
                                            <div class="file-upload__upload-btn-text">UPLOAD LOGO</div>
                                        </a> <span class="image-upload-toggle logo-browse-btn ">

                                         <AdminInput ref="profile-image" v-show="false"
                                                     @inputImageBase64="(d)=>userProfile.profile_image_base64=d"
                                                     @inputFile="(d)=> userProfile.profile_image=d"
                                                     :inputType="'file'"/>

                                        </span>
                                    </div>
                                    <label style="display: block"
                                           class="error-msg">{{validated().profile_image}}</label>
                                </div>
                                <!--@END IMAGE PROFILE-->

                                <div class="control-group text-left input-ctrl mt-16">
                                    <label class="lbl"
                                           for="pub-enquiry-person">Name</label>
                                    <input name="pubEnquiryPerson"
                                           v-model="userProfile.contact_person"
                                           id="pub-enquiry-person" placeholder="Enter contact person" type="text"
                                           class="input-ctn" maxlength="50">
                                    <label style="display: block" for="pub-enquiry-person"
                                           class="error-msg">{{validated().contact_person}}</label>
                                </div>

                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="pub-enquiry-contact">Contact Number</label>
                                    <input name="pubEnquiryContact"
                                           v-model="userProfile.phone_number"
                                           id="pub-enquiry-contact" placeholder="Enter contact number" type="text"
                                           maxlength="20" class="input-ctn hasCounter">
                                    <label style="display: block" for="pub-enquiry-contact"
                                           class="error-msg">{{validated().phone_number}}</label>
                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="pub-enquiry-email">Contact Email</label>
                                    <input name="pubEnquiryEmail"
                                           v-model="userProfile.public_email"
                                           id="pub-enquiry-email" type="email" placeholder="Enter contact email"
                                           maxlength="100" class="input-ctn hasCounter">
                                    <label style="display: block" for="pub-enquiry-email"
                                           class="error-msg">{{validated().public_email}}</label>
                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="lao-giving-url">URL in LaoGiving.la</label>
                                    <input id="lao-giving-url" name="givingUrl"
                                           readonly
                                           v-model="userProfile.website_in_our_site"
                                           maxlength="1024" type="text"
                                           class="input-ctn hasCounter" placeholder="">
                                    <label for="lao-giving-url" class="help-block error-msg">{{validated().website_in_our_site}}</label>
                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="web-url">Website</label>
                                    <input type="text" name="webURL" id="web-url"
                                           v-model="userProfile.website"
                                           value="" class="input-ctn " data-error-msg="Error message"
                                           placeholder="Enter website url" maxlength="1024">
                                    <label for="web-url" class="help-block error-msg">{{validated().website}}</label>
                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="facebook-link">Facebook page link</label>
                                    <input id="facebook-link" name="facebookLink"
                                           v-model="userProfile.facebook"
                                           type="text" placeholder="e.g. NVPCsg" maxlength="200"
                                           class="input-ctn ">
                                    <label for="facebook-link" style="display:block;" class="help-block error-msg">{{validated().facebook}}</label>
                                </div>

                            </template>
                        </AccordionCard>

                        <div class="text-center ctn-1200 mb-24 buttonGroup hide">
                            <!-- 			        <div class="grid-12 grid-tablet-landscape-up-4-last">  -->
                            <button
                                class="button-ctn button--ghost button--min-width mr-16 cancelEditProfile">CANCEL
                            </button>
                            <button class="button-ctn button--min-width saveEditProfile">SAVE</button>
                            <!-- 			        </div> -->
                        </div>
                    </form>
                    <!--FormContact-->
                </div>
                <!--Right Side-->
            </section>

            <!--@ENDFORM-->

            <div class="ctn-1200 flex-ctn flex-ctn--just-end mt-24">
                <button @click="resetProfileData()" class="button-ctn button--ghost button--min-width mr-16">
                    CANCEL
                </button>
                <button v-if="!isLoading" @click="saveProfileSettings()"
                        class="button-ctn button--min-width saveEditProfile">SAVE
                </button>
                <button v-else class="button-ctn button--min-width saveEditProfile">SAVING...
                </button>
            </div>

        </div>
    </div>
</template>

<script>
    import Causes from '@com/Utils/Causes.vue'
    import MediaGallery from '@com/Utils/MediaGallery.vue'
    import AccordionCard from '@com/Utils/AccordionCard.vue'
    import TextareaLimit from '@com/Utils/TextAreaLimiter.vue'

    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'

    export default {
        name: "EditOrganizeProfile",
        components: {
            Causes,
            AccordionCard,
            TextareaLimit,
            MediaGallery
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            isLoading: false,
            ImageLimit: 4,
            clearImage: false,
            user_media: {
                video: {validated: '', url: ''},
                images: [
                    {
                        image_base64: '',
                        image: null,
                        validated: '',
                        removable: false,
                    }
                ],
            },
        }),
        computed: {
            ...mapState(['authUserInfo', 'userProfile']),
        },
        methods: {
            ...mapMutations(['setClearValidate', 'setUserProfile', 'setUserProfileKey']),
            ...mapActions(['showErrorToast', 'showInfoToast', 'postManageUserProfile', 'postChangeCredentialsUser', 'fetchAuthUserInfo', 'fetchOptionProfileData']),
            resetProfileData() {
                this.setClearValidate(this.userProfile);
                this.getUserProfile(true);
                this.$emit('cancelEditProfile')
            },
            chooseProfileImage() {
                this.$refs['profile-image'].triggerInputClick();
            },
            saveProfileSettings() {
                let dt = 3500;
                this.isLoading = true;
                this.setUserProfileKey({key: 'user_media', value: this.user_media});
                this.postManageUserProfile(this.userProfile)
                    .then(res => {
                        if (res.success) {
                            this.showInfoToast({msg: 'Your profile was updated!', dt});
                            this.getUserProfile();
                            this.$utils.scrollToY('html,body', 292);
                            this.clearImage = false;
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        console.log(err);
                        this.showErrorToast({msg: 'Failed to update your profile!', dt});
                        this.isLoading = false;
                    })
            },
            getUserProfile(isReset = false) {

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
                            this.setUserProfileKey({key: 'user_causes', value: d.user_causes});
                            this.setUserProfileKey({key: 'user_causes_display', value: d.user_causes_display});
                            this.setUserProfileKey({key: 'causes', value: d.causes});
                            this.setUserProfileKey({
                                key: 'user_media',
                                value: {video: d.user_media.video, images: d.user_media.images}
                            });
                            this.user_media = this.userProfile.user_media;

                            if (!isReset) {
                                this.$refs['media-gallery'].set(d.user_media.video, d.user_media.images);
                                this.$refs['about-textarea-limit'].set(this.userProfile.about);
                                this.$refs['program-textarea-limit'].set(this.userProfile.our_programmes);
                                this.$refs['vision_mission-textarea-limit'].set(this.userProfile.vision_mission);
                                this.$refs['user-causes'].setValue(d.user_causes);
                            }

                            this.fetchAuthUserInfo();
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        this.showErrorToast({msg: 'Failed to load your profile!', dt: 3500});
                        this.isLoading = false;
                        console.log(err);
                    })
            },
            toggleClearImage() {
                this.clearImage = true;
                this.$refs['profile-image'].clearInput();
            },
            serImageSrcData({index, image}) {
                if (image.clear) {
                    image.clear = null;
                    image.change = true;
                }
            },
            clearImageSrcData({index, image}) {
                image.clear = true;
            },
            AddMedia() {
                if (this.user_media.images.length > this.ImageLimit) {
                    return;
                }
                for (let i = 0; i < 2; i++) {
                    if (this.user_media.images.length > this.ImageLimit) {
                        return;
                    }
                    this.$refs['media-gallery'].addImage({
                        image_base64: '',
                        image: null,
                        validated: '',
                        removable: true
                    });
                }
            },
            initData() {
                this.user_media = this.userProfile.user_media;
                this.getUserProfile();
            }
        },
        created() {
            this.initData();
        }
    }
</script>

<style scoped>
    #orgLogoUploadedPreview, #orgLogoUploaded {
        max-width: 100%;
        height: auto;
        vertical-align: middle;
        border: 0;
        -ms-interpolation-mode: bicubic;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }

    #orgLogoUploaded {
        width: auto;
    }
</style>
