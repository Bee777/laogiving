<template>
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
                    <div class="error-msg video-upload" :style="`display:${video.validated ? 'block': 'none'};`">Please
                        upload a valid
                        youtube link
                    </div>
                    <div class="input-ctrl input-ctrl--full"><label class="lbl"><p
                        class="body-txt body-txt--small mb-0">Add YouTube video (optional)</p>
                    </label>
                        <input v-model="video.url" type="text" class="input-ctn" name="orgVideo" value=""
                               placeholder="Enter YouTube link e.g. https://www.youtube.com/watch?v=gXLkWYR_JI">
                    </div>
                </div>
            </div>
            <div class="file-upload__lbl bold font-black body-txt body-txt--small">SLIDE 1</div>
        </div>

        <div :class="[{'error': item.validated }]" class="file-upload gallery__item item image-upload-div"
             v-for="(item, idx) in images" :key="idx">

            <a @click="removeImage(idx)" v-if="item.removable"
               class="button-ctn cursor button--small button--icon file-upload__remove remove-image-button">
                <i style="color: #ffffff;" class="ico material-icons button--icon__icon">remove</i></a>

            <div class="file-upload__holder" data-index="2">
                <div class="file-upload__spacer"></div>
                <div class="file-upload__image">
                    <img v-if="item.image_base64 !== ''" class="img-placeholder" :src="item.image_base64"
                         id="orgImg2Uploaded"
                         name="orgImg2Uploaded">
                    <div v-else id="ImageTemplate2"><a
                        @click="chooseProfileImage(idx)"
                        class="file-upload__upload-btn imageUploadBtn upload-image-button show">
                        <i class="ico ico-upload"></i>
                        <div class="file-upload__upload-btn-text">UPLOAD IMAGE</div>
                    </a></div>
                    <a @click="clearImage(idx)"
                       class="button-ctn cursor button--small button--icon file-upload__cancel remove-image-button"
                       :class="[{'hide': item.image_base64 === ''}]">
                        <i style="color: #ffffff;" class="ico material-icons button--icon__icon">close</i></a>
                    <div class="error-msg img-upload" style="display:block;">
                        {{ item.validated }}
                    </div>
                    <AdminInput :ref="`image-${idx}`" v-show="false"
                                @inputImageBase64="(d) => item.image_base64=d"
                                @inputFile="(d) => item.image=d"
                                :inputType="'file'"/>
                </div>
            </div>
            <div class="file-upload__lbl bold font-black body-txt body-txt--small">SLIDE {{ 2 + idx }}
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        name: "MediaGallery",
        data: () => ({
            video: {validated: '', url: ''},
            images: [],
        }),
        props: {
            value: {
                default: function () {
                    return {
                        video: {validated: '', url: ''},
                        images: [],
                    }
                }
            }
        },
        watch: {
            video: {
                deep: true,
                handler() {
                    this.emit();
                }
            },
            images: {
                deep: true,
                handler() {
                    this.emit();
                }
            }
        },
        methods: {
            emit() {
                this.$emit('input', {video: this.video, images: this.images});
                this.$emit('send', {video: this.video, images: this.images});
            },
            set(video, images) {
                for (let i in this.images) {
                    this.$refs[`image-${i}`][0].clearInput();
                }
                this.video = video;
                this.images = images;
            },
            clearImage(idx) {
                this.images[idx].image_base64 = '';
                this.images[idx].image = null;
                this.images[idx].validated = '';
                this.$refs[`image-${idx}`][0].clearInput();
                this.$emit('clearImage', {index: idx, image: this.images[idx]});
            },
            setVideo(video) {
                this.video = video;
            },
            setImages(images) {
                for (let i in this.images) {
                    this.$refs[`image-${i}`][0].clearInput();
                }
                this.images = images;
            },
            addImage(data) {
                this.images.push(this.schema(data));
            },
            removeImage(idx) {
                this.images.splice(idx, 1);
            },
            schema(data) {
                return {
                    image_base64: data.image_base64 || '',
                    image: data.file || null,
                    validated: data.validated || '',
                    removable: data.removable
                }
            },
            chooseProfileImage(idx) {
                this.$refs[`image-${idx}`][0].triggerInputClick();
            },
        },
        mounted() {

        },
        created() {
            this.video = this.value.video;
            this.images = this.value.images;
        }
    }
</script>

<style scoped>

</style>
