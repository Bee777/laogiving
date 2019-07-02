<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form novalidate class="form" id="volunteer-step-1" @submit.prevent>
            <div class="input-ctrl" :class="[{'error': validated().title}]">
                <label class="lbl"
                       for="volunteer_title">
                    <h3 class="h3 font-dark-grey">Activity name</h3></label>
                <input
                    v-model="title"
                    id="volunteer_title"
                    name="volunteer_title" type="text"
                    class="input-ctn form-control field-required" placeholder="Type the activity name here" value="">
                <label style="display: block" for="volunteer_title"
                       class="error-msg">{{ validated().title }}</label>
            </div>
            <hr class="hr">
            <div class="input-ctrl" :class="[{'error': validated().description}]">
                <label class="lbl">
                    <h3 class="h3 font-dark-grey">Activity description</h3>
                    <p class="body-txt body-txt--small mb-16">What is it about? Who are the beneficiaries? What purpose
                        does it serve?</p>
                </label>

                <TextareaLimit
                    placeholder="Type the activity details here"
                    ref="activity-desc-limit" max="500"
                    v-model="description"
                    rows="10"/>

                <label style="display: block;" class="help-block error-msg">{{
                    validated().description
                    }}</label>

            </div>
            <hr class="hr">
            <div class="input-ctrl clearfix">
                <h3 class="h3 font-dark-grey">Media gallery (for slider)</h3>
                <p class="body-txt body-txt--small mb-16">Add at least 1 image or video to make it more compelling to
                    volunteer</p>


                <MediaGallery @setImageSrc="serImageSrcData" @clearImageSrc="clearImageSrcData" ref="media-gallery"
                              v-model="media"/>


            </div>
            <button
                @click="AddMedia()" v-if="media.images.length <= ImageLimit"
                class="button-ctn button--with-icon button--no-bg button--large button--no-left-pad js-add-fileupload">
                <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                    class="ico ico-add button--with-icon__icon"></i> ADD IMAGE
                </div>
            </button>

            <hr class="hr">
            <div class="input-ctrl clearfix">
                <h3 class="h3 font-dark-grey">Causes supported by this activity</h3>
                <div v-if="validated().causes" style="display: block;" class="error-msg">You have not select anything
                </div>
                <label class="lbl">Choose up to 4 causes</label>
                <Causes ref="activity-causes" :max="4" v-model="selectedCauses"
                        :items="causes"/>
            </div>

        </form>
    </div>
</template>

<script>
    import Causes from '@com/Utils/Causes.vue'
    import MediaGallery from '@com/Utils/MediaGallery.vue'
    import TextareaLimit from '@com/Utils/TextAreaLimiter.vue'

    import {mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        name: "ActivityStepOne",
        props: {
            edit: {
                default: false,
            },
            causes: {
                default: function () {
                    return [];
                }
            }
        },
        components: {
            Causes,
            MediaGallery,
            TextareaLimit
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            title: '',
            description: '',
            selectedCauses: [],
            ImageLimit: 4,
            media: {
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
        methods: {
            ...mapActions([]),
            ...mapMutations(['setValidated']),
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
                if (this.media.images.length > this.ImageLimit) {
                    return;
                }
                for (let i = 0; i < 2; i++) {
                    if (this.media.images.length > this.ImageLimit) {
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
            setTile(title) {
                this.title = title;
            },
            setDescription(description) {
                this.description = description;
                this.$refs['activity-desc-limit'].set(this.description);
            },
            setMedia(video, images) {
                this.$refs['media-gallery'].set(video, images);
            },
            setCauses(activity_causes) {
                this.$refs['activity-causes'].setValue(activity_causes);
            },
            getData() {
                return new Promise((res, rej) => {
                    //images
                    let images = this.media.images;
                    let firstImage = images[0];
                    //validate data
                    let formData = new FormData();
                    let data = {
                        title: this.title,
                        description: this.description,
                        causes: this.selectedCauses,
                        media: this.media,
                    };
                    this.$utils.Validate(data, {
                        'title': ['required', {max: 191}],
                        'description': ['required', {max: 500}],
                    }, false, (e) => {
                        this.setValidated({errors: e.errors});
                    });
                    //add first data
                    formData.append('title', this.title);
                    formData.append('description', this.description);
                    let video = this.media.video;
                    if (!this.$utils.isEmptyVar(video.url)) {
                        formData.append('media_video_url', video.url);
                    }
                    //end end first data
                    //validate first image
                    if (!this.edit) {
                        this.$utils.Validate(firstImage, {
                            'image': ['required', {mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                        }, false, (e) => {
                            firstImage.validated = e.errors.image;
                        });
                    } else {
                        this.$utils.Validate(firstImage, {
                            'image': ['required', {max: 3000}],
                        }, false, (e) => {
                            firstImage.validated = e.errors.image;
                        });
                    }
                    //add images data
                    images.map((i, idx) => {
                        this.$utils.Validate(i, {
                            'image': [{mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                        }).then(() => {
                            if (i.clear && i.id) {
                                formData.append('user_media_images_cleared[]', i.id);
                            } else if (i.id && i.url && !i.change) {
                                formData.append('media_images[]', new File([""], i.url));
                            } else if (i.image && i.image.file) {
                                formData.append('media_images[]', i.image.file);
                            }
                            if (idx === images.length - 1) {
                                //validate cause
                                this.$utils.Validate(data, {
                                    'causes': ['required'],
                                }, false, (e) => {
                                    this.setValidated({errors: e.errors});
                                });
                                this.selectedCauses.map((i) => {
                                    formData.append('causes[]', i);
                                });
                                //everything is ok
                                res({formData, data});
                            }
                        }).catch(e => {
                        });
                    });
                    //add images data
                });
            }
        },
    }
</script>

<style scoped>

</style>
