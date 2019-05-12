<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form novalidate class="form" id="volunteer-step-1">
            <div class="input-ctrl">
                <label class="lbl"
                       for="volunteer_title">
                    <h3 class="h3 font-dark-grey">Activity name</h3></label>
                <input
                    id="volunteer_title"
                    name="volunteer_title" type="text"
                    class="input-ctn form-control field-required" placeholder="Type the activity name here" value="">
                <label for="volunteer_title" class="error-msg"></label>
            </div>
            <hr class="hr">
            <div class="input-ctrl">
                <label class="lbl">
                    <h3 class="h3 font-dark-grey">Activity description</h3>
                    <p class="body-txt body-txt--small mb-16">What is it about? Who are the beneficiaries? What purpose
                        does it serve?</p>
                </label>
                <textarea id="activityDesc" rows="10"
                          max-length="500" class="textarea-ctn" cols="10"
                          name="volunteer_description"
                          placeholder="Type the activity details here"></textarea>
                <label for="activityDesc"
                       class="error-msg"></label>
            </div>
            <hr class="hr">
            <div class="input-ctrl clearfix">
                <h3 class="h3 font-dark-grey">Media gallery (for slider)</h3>
                <p class="body-txt body-txt--small mb-16">Add at least 1 image or video to make it more compelling to
                    volunteer</p>
                <div class=" ctn gallery gallery-tablet-portrait-up-6">

                    <div class="file-upload gallery__item">
                        <div class="file-upload__holder">
                            <div class="file-upload__spacer"></div>
                            <div class="file-upload__video">

                                <div class="file-upload__video-icon">
                                    <div class="video_icon_container">
                                        <i style="padding-left: 1px;" class="video_icon material-icons">videocam</i>
                                    </div>
                                </div>
                                <div class="input-ctrl input-ctrl--full">
                                    <label class="lbl" for="youtubeLink">
                                        <p class="body-txt body-txt--small mb-0">Add YouTube video (optional)</p>
                                    </label>
                                    <a class="button button--small button--icon file-upload__cancel remove-video-button"
                                       style="display:none;"><i class="ico ico-remove button--icon__icon"></i></a>
                                    <input id="youtubeLink" type="text" class="input-ctn"
                                           placeholder="Enter YouTube Link"
                                           name="carouselVideo">
                                </div>

                            </div>
                        </div>
                        <div class="file-upload__lbl bold font-black body-txt body-txt--small">SLIDE 1</div>
                    </div>

                    <div class="file-upload gallery__item input-ctrl">
                        <div class="file-upload__holder">
                            <div class="file-upload__spacer"></div>
                            <div class="file-upload__image">
                                <img class="img-placeholder" id="orgImg1Uploaded"> <a
                                class="file-upload__upload-btn imageUploadBtn upload-image-button"> <i
                                class="ico ico-upload"></i>
                                <div class="file-upload__upload-btn-text">UPLOAD IMAGE</div>
                            </a> <a
                                class="button-ctn button--small button--icon file-upload__cancel remove-image-button"
                                style="display: none;"><i
                                class="ico ico-remove button--icon__icon"></i></a>
                                <div id="uploadimage-error" class="error-msg" style="display: none;">You need to upload
                                    at least one image
                                </div>
                            </div>
                            <a href="" class="button-ctn button--small button--icon file-upload__cancel"
                               style="display: none;"><i
                                class="ico ico-upload button--icon__icon"></i></a>
                            <div class="file-upload__lbl bold font-black body-txt body-txt--small"> SLIDE 2</div>
                        </div>
                    </div>

                </div>
            </div>
            <button
                class="button-ctn button--with-icon button--no-bg button--large button--no-left-pad js-add-fileupload">
                <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                    class="ico ico-add button--with-icon__icon"></i> ADD IMAGE
                </div>
            </button>

            <hr class="hr">
            <div class="input-ctrl clearfix">
                <h3 class="h3 font-dark-grey">Causes supported by this activity</h3>
                <div class="error-msg">You have not select anything</div>
                <label class="lbl">Choose up to 4 causes</label>
                <div class="ctn gallery gallery-tablet-portrait-up-6 mt-24 clearfix"
                     id="orgCausesSelection">
                    <ul class="gallery__item checkbox-list">

                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26746">
                            <div class="checkbox-list__lbl-spn">Animal
                                Welfare
                            </div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26747">
                            <div class="checkbox-list__lbl-spn">Arts
                                &amp; Heritage
                            </div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26748">
                            <div class="checkbox-list__lbl-spn">
                                Children &amp; Youth
                            </div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26749">
                            <div class="checkbox-list__lbl-spn">Community</div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   checked
                                   value="26750">
                            <div class="checkbox-list__lbl-spn">Disability
                            </div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26751"
                                   checked>
                            <div class="checkbox-list__lbl-spn">Education</div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26752">
                            <div class="checkbox-list__lbl-spn">Elderly</div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26753">
                            <div class="checkbox-list__lbl-spn" data-content="Environment">Environment
                            </div>
                        </label></li>
                    </ul>
                    <ul class="gallery__item checkbox-list">
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26754">
                            <div class="checkbox-list__lbl-spn" data-content="Families">Families</div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26755">
                            <div class="checkbox-list__lbl-spn" data-content="Health">Health</div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="1637026">
                            <div class="checkbox-list__lbl-spn" data-content="Humanitarian">
                                Humanitarian
                            </div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26756">
                            <div class="checkbox-list__lbl-spn" data-content="Social Service">Social
                                Service
                            </div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26745"
                                   checked>
                            <div class="checkbox-list__lbl-spn" data-content="Sports">Sports</div>
                        </label></li>
                        <li><label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26757">
                            <div class="checkbox-list__lbl-spn" data-content="Women &amp; Girls">Women
                                &amp; Girls
                            </div>
                        </label></li>
                    </ul>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        name: "ActivityStepOne"
    }
</script>

<style scoped>

</style>
