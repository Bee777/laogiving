<template>
    <div class="ctn">
        <div class="cWidth-1200 flex-ctn flex-ctn--just-end mt-24  clearfix">
            <div class="grid-12 grid-tablet-landscape-up-4-last text-center">
                <button @click="$emit('cancelEditProfile')"
                        class="button-ctn button--ghost button--min-width mr-16">CANCEL
                </button>
                <button class="button-ctn button--min-width">SAVE</button>
            </div>
        </div>
        <div class="cWidth-1200 clearfix">
            <section class="company-profile__body ctn clearfix">
                <div class="company-profile__main company-profile__options">
                    <!--Images-->
                    <div class="ctn company-profile__edit-carousel clearfix">
                        <div class="ctn gallery gallery-tablet-portrait-up-6">


                            <div class="file-upload gallery__item">
                                <div class="file-upload__holder">
                                    <div class="file-upload__spacer"></div>
                                    <div class="file-upload__video">
                                        <div class="file-upload__video-icon">
                                            <div class="video_icon_container">
                                                <i class="video_icon material-icons">videocam</i>
                                            </div>
                                        </div>
                                        <div class="error-msg video-upload" style="display:none;">Please upload a valid
                                            youtube link
                                        </div>
                                        <div class="input-ctrl input-ctrl--full"><label class="lbl"><p
                                            class="body-txt body-txt--small mb-0">Add YouTube video (optional)</p>
                                        </label>
                                            <input type="text" class="input-ctn" name="orgVideo" value=""
                                                   placeholder="Enter YouTube link e.g. https://www.youtube.com/watch?v=gXLkWYR_JI">
                                        </div>
                                    </div>
                                </div>
                                <div class="file-upload__lbl bold font-black body-txt body-txt--small">SLIDE 1</div>
                            </div>


                            <div class="file-upload gallery__item item image-upload-div">
                                <div class="file-upload__holder" data-index="1">
                                    <div class="file-upload__spacer"></div>
                                    <div class="file-upload__image">
                                        <img class="img-placeholder"
                                             src="https://www.giving.sg/image/logo?img_id=9128828">
                                        <div><a
                                            class="file-upload__upload-btn imageUploadBtn upload-image-button hide">
                                            <i class="ico ico-upload"></i>
                                            <div class="file-upload__upload-btn-text">UPLOAD IMAGE</div>
                                        </a></div>
                                        <a class="button-ctn button--small button--icon file-upload__cancel remove-image-button show">
                                            <i style="color: #ffffff;" class="ico material-icons button--icon__icon">close</i></a>
                                        <div class="error-msg img-upload" style="display:none;">
                                            You need to upload at least one image
                                        </div>
                                    </div>
                                </div>
                                <div class="file-upload__lbl bold font-black body-txt body-txt--small">SLIDE 2</div>
                            </div>

                            <div class="file-upload gallery__item item image-upload-div" v-for="i in 4" :key="i">
                                <div class="file-upload__holder" data-index="2">
                                    <div class="file-upload__spacer"></div>
                                    <div class="file-upload__image">
                                        <img class="img-placeholder" src=""
                                             id="orgImg2Uploaded"
                                             name="orgImg2Uploaded">
                                        <div id="ImageTemplate2"><a
                                            class="file-upload__upload-btn imageUploadBtn upload-image-button show">
                                            <i class="ico ico-upload"></i>
                                            <div class="file-upload__upload-btn-text">UPLOAD IMAGE</div>
                                        </a></div>
                                        <a class="button button--small button--icon file-upload__cancel remove-image-button hide">
                                            <i class="ico material-icons button--icon__icon">close</i></a>
                                    </div>
                                </div>
                                <div class="file-upload__lbl bold font-black body-txt body-txt--small">SLIDE{{ 2+i }}
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--ENDImages-->
                    <button
                        class="button-ctn button--with-icon button--no-bg button--large button--no-left-pad">
                        <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                            class="ico ico-add  button--with-icon__icon"></i> ADD IMAGE
                        </div>
                    </button>
                    <!--Description-->
                    <div>
                        <div class="company-profile__description">
                            <form id="about-program-form" novalidate="novalidate">
                                <div class="accordion-card accordion-card--borderless">
                                    <div class="accordion-card__head">
                                        <h3 class="h3">About
                                            Us</h3>
                                        <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                        <div class="accordion-card__hitarea"></div>
                                    </div>
                                    <div class="accordion-card__body">
                                        <div class="edit-description">
                                            <textarea id="dtn-about-us-desc"
                                                      name="about"
                                                      class="textarea-ctn" maxlength="1500"
                                                      rows="11">National Neuroscience Institute (NNI) is the national specialist centre and regional centre for clinical referrals for the management and treatment of the neurosciences, as well as for education and research conducted in the field.

Offering a comprehensive range of Neurology, Neurosurgery and Neuroradiology services using the latest technology and experience of our healthcare professionals, NNI is at the forefront of neuroscience care in Singapore and across the region.

NNI operates directly from two campuses; Tan Tock Seng Hospital and Singapore General Hospital (SGH), as well as provides specialty services to most other hospitals in Singapore.

We are a member of the SingHealth (Singapore Health Services) Group, an integrated healthcare delivery network which offers a complete range of multi-disciplinary and integrated medical care. The Group comprises hospitals, national specialty centres and a network of polyclinics.</textarea>
                                        </div>
                                        <div class="control-group">
                                            <label id="about-us-count"></label>
                                            <label class="error-msg" id="id-show-desc-help-block"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card accordion-card--borderless mb-16">
                                    <div class="accordion-card__head">
                                        <h3 class="h3">Our
                                            Programmes</h3>
                                        <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                        <div class="accordion-card__hitarea"></div>
                                    </div>
                                    <div class="accordion-card__body">
                                        <div class="edit-description">
                                            <textarea id="dtn-about-us-programmes"
                                                      name="program"
                                                      class="textarea-ctn"
                                                      maxlength="1500"
                                                      rows="11"></textarea>
                                        </div>
                                        <div class="control-group">
                                            <label id="programmes-count"></label> <label
                                            class="error-msg"></label></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--Description-->
                </div>
                <!--@ENDLEFTSIDE-->
                <!--Right Side-->
                <div class="company-profile__causes-contact mt-0">
                    <!--VISION-->
                    <div class="accordion-card mb-16">
                        <div class="accordion-card__head">
                            <h6 class="h6">VISION &amp;
                                MISSION</h6>
                            <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                            <div class="accordion-card__hitarea"></div>
                        </div>
                        <div class="accordion-card__body">
                            <form id="organizationVision" novalidate="novalidate">
                                <textarea class="textarea-ctn"
                                          maxlength="150" rows="5"
                                          name="vision"
                                          id="organizationVisionTextArea"
                                          placeholder="Describe your organisation/group's vision/mission in 150 characters.

e.g: Our organisation is committed to the welfare of youth-at-risk">NNI is the national specialist centre and regional centre for clinical referrals for the management and treatment of the neurosciences.</textarea>
                                <label for="organizationVisionTextArea" class="error-msg"
                                       style="display: block;"></label>
                                <div class="box-footer clearfix">
                                    <p class="">You can type <span
                                        class="char-count">150</span> characters more</p></div>
                            </form>
                        </div>
                    </div>
                    <!--VISION-->
                    <!--SUPPORT CAUSES-->
                    <div class="accordion-card mb-16">
                        <div class="accordion-card__head">
                            <h6 class="h6">SUPPORTED
                                CAUSES</h6>
                            <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                            <div class="accordion-card__hitarea"></div>
                        </div>
                        <div class="accordion-card__body" id="our-causes">
                            <div id="causes-wrapper"><p class="body-txt" id="causes-title">Please select up to 4 causes
                                <span id="causes-error"></span></p>
                                <div id="control-group-causes">
                                    <form id="org-cause-info" novalidate="novalidate">
                                        <ul class="checkbox-list" data-role="limit-checkbox">
                                            <li class="title-ctn__child">
                                                <div class="cause-box">
                                                    <label class="checkbox-list__checkbox"> <input
                                                        type="checkbox" class="cause-box"
                                                        name="causeBox" value="26746">
                                                        <span class="checkbox-list__lbl-spn">Animal Welfare</span>
                                                    </label>
                                                </div>
                                            </li> <!-- <label -->
                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box"
                                                    name="causeBox" value="26747">
                                                    <span class="checkbox-list__lbl-spn">Arts &amp; Heritage</span>
                                                </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box"
                                                    name="causeBox" value="26748">
                                                    <span class="checkbox-list__lbl-spn">Children &amp; Youth</span>
                                                </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26749"
                                                    name="causeBox" value="26749">
                                                    <span class="checkbox-list__lbl-spn">Community</span> </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box"
                                                    name="causeBox" value="26750">
                                                    <span class="checkbox-list__lbl-spn">Disability</span> </label>
                                                </div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26751"
                                                    name="causeBox" value="26751"
                                                    checked=""> <span class="checkbox-list__lbl-spn">Education</span>
                                                </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26752"
                                                    name="causeBox" value="26752">
                                                    <span class="checkbox-list__lbl-spn">Elderly</span> </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26753"
                                                    name="causeBox" value="26753"
                                                    checked=""> <span class="checkbox-list__lbl-spn">Environment</span>
                                                </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26754"
                                                    name="causeBox" value="26754">
                                                    <span class="checkbox-list__lbl-spn">Families</span> </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26755"
                                                    name="causeBox" value="26755">
                                                    <span class="checkbox-list__lbl-spn">Health</span> </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input1637026"
                                                    name="causeBox" value="1637026">
                                                    <span class="checkbox-list__lbl-spn">Humanitarian</span> </label>
                                                </div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26756"
                                                    name="causeBox" value="26756">
                                                    <span class="checkbox-list__lbl-spn">Social Service</span> </label>
                                                </div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26745"
                                                    name="causeBox" value="26745"
                                                    checked=""> <span class="checkbox-list__lbl-spn">Sports</span>
                                                </label></div>
                                            </li> <!-- <label -->

                                            <li class="title-ctn__child">
                                                <div class="cause-box"><label class="checkbox-list__checkbox"> <input
                                                    type="checkbox" class="cause-box" id="input26757"
                                                    name="causeBox" value="26757">
                                                    <span class="checkbox-list__lbl-spn">Women &amp; Girls</span>
                                                </label></div>
                                            </li> <!-- <label -->
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--@SUPPORt CAUSES-->
                    <!--FormContact-->
                    <form id="donation-userDetails" style="" novalidate="novalidate">
                        <div class="accordion-card mb-16">
                            <div class="accordion-card__head" id="contactUs">
                                <h6 class="h6">CONTACT US</h6>
                                <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div id="dtn-add-logo box reset ">
                                    <div class="border-round link-box">
                                        <a id="org-logo-discard"
                                           class="show button-ctn notBlue float_right button--small button--icon replace-image-button ">
                                            <i class="ico material-icons button--icon__icon ">close</i>
                                        </a>
                                        <div class="lfr-change-logo">
                                            <img src="https://www.giving.sg/image/organization_logo?img_id=9128818"
                                                 id="orgLogoUploaded">
                                        </div>
                                        <a
                                            class="file-upload__upload-btn upload-image-button mt-8 hide"
                                            id="org-logo-upload"> <i class="ico ico-upload"></i>
                                            <div class="file-upload__upload-btn-text">UPLOAD LOGO</div>
                                        </a> <span class="image-upload-toggle logo-browse-btn ">
                                        </span>
                                    </div>
                                </div>
                                <div class="control-group text-left input-ctrl mt-16">
                                    <label class="lbl"
                                           for="pub-enquiry-person">Name</label>
                                    <input name="pubEnquiryPerson"
                                           id="pub-enquiry-person" placeholder="Enter contact person" type="text"
                                           class="input-ctn" value="Volunteer Co-ordinator" maxlength="50">
                                </div>

                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="pub-enquiry-contact">Contact Number</label>
                                    <input name="pubEnquiryContact"
                                           id="pub-enquiry-contact" placeholder="Enter contact number" type="text"
                                           value="63577091" maxlength="20" class="input-ctn hasCounter">

                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="pub-enquiry-email">Contact Email</label>
                                    <input name="pubEnquiryEmail"
                                           id="pub-enquiry-email" type="text" placeholder="Enter contact email"
                                           value="beeostin@gmail.com" maxlength="100" class="input-ctn hasCounter"
                                           data-error-msg="Error message">

                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="giving-url">URL in Giving.sg</label>
                                    <input id="giving-url" name="givingUrl"
                                           value="bee-organisation" maxlength="1024" type="text"
                                           class="input-ctn hasCounter" placeholder="">
                                    <label for="giving-url" id="giving-url-error" class="help-block error-msg"></label>
                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="web-url">Website</label>
                                    <input type="text" name="webURL" id="web-url"
                                           value="" class="input-ctn " data-error-msg="Error message"
                                           placeholder="Enter website url" maxlength="1024">

                                </div>
                                <div class="control-group text-left input-ctrl">
                                    <label class="lbl" for="facebook-link">Facebook page link</label>
                                    <input id="facebook-link" name="facebookLink"
                                           type="text" placeholder="e.g. NVPCsg" value="" maxlength="200"
                                           class="input-ctn ">
                                </div>
                            </div>
                        </div>

                        <div class="text-center ctn-1200 mb-24 buttonGroup hide" id="submitGroup1">
                            <!-- 			        <div class="grid-12 grid-tablet-landscape-up-4-last">  -->
                            <input type="button" class="button button--ghost button--min-width mr-16 cancelEditProfile"
                                   id="cancelButton2" value="CANCEL">
                            <input type="button" class="button button--min-width saveEditProfile" value="SAVE">
                            <!-- 			        </div> -->
                        </div>
                    </form>
                    <!--FormContact-->
                </div>
                <!--Right Side-->
            </section>

            <!--@ENDFORM-->

            <div class="ctn-1200 flex-ctn flex-ctn--just-end mt-24">
                <input @click="$emit('cancelEditProfile')" type="button" class="button-ctn button--ghost button--min-width mr-16"
                       value="CANCEL">
                <input type="button" class="button-ctn button--min-width saveEditProfile" value="SAVE">
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "EditOrganizeProfile"
    }
</script>

<style scoped>

</style>
