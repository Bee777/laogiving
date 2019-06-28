<template>
    <div class="ctn">
        <div class="cWidth-1200 clearfix">
            <div class="grid-12 grid-tablet-landscape-up-4-last text-center">
                <button class="button-ctn button--ghost mt-24" @click="$emit('editProfileClicked')"
                        id="editProfileLink">EDIT PROFILE
                </button>
            </div>
        </div>
        <div class="cWidth-1200 clearfix">
            <section class="company-profile__body ctn clearfix">
                <div class="company-profile__main objectfit ">
                    <div class="swiper-arrow-wrap swiper-container-horizontal">

                        <Carousel :hasVideos="true" ref="organize-profile">
                            <template slot="slide-item">
                                <div class="swiper-slide" v-if="user_media.video.url !==''">
                                    <div class="video-container none-active"
                                         :data-embed="covertYoutubeUrlToEmBed(user_media.video.url)">
                                    </div>
                                </div>
                                <div class="swiper-slide" v-for="(item, idx) in user_media.images"
                                     v-if="item.image_base64!==''" :key="idx">
                                    <img :alt="item.url" class="img-placeolder"
                                         :src="item.image_base64">
                                </div>
                            </template>
                        </Carousel>

                        <div class="swiper-pagination swiper-pagination-bullets"><span
                            class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>

                    </div>

                    <!--<div class="swiper-arrow-wrap swiper-container-horizontal">-->
                    <!--<div class="swiper-container&#45;&#45;images swiper-container">-->
                    <!--<div class="swiper-wrapper">-->
                    <!--<div class="swiper-slide">-->
                    <!--<img alt="" class="img-placeolder"-->
                    <!--src="https://www.giving.sg/image/logo?img_id=6080036">-->
                    <!--</div>-->
                    <!--<div class="swiper-slide">-->
                    <!--<img alt="" class="img-placeolder"-->
                    <!--src="https://www.giving.sg/image/logo?img_id=9040323">-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<div class="swiper-button-prev rotage"></div>-->
                    <!--<div class="swiper-button-next"></div>-->
                    <!--</div>-->
                    <!--<div class="swiper-pagination swiper-pagination-bullets"><span-->
                    <!--class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>-->
                    <!--</div>-->

                </div>
                <div class="company-profile__donate">
                    <AccordionCard>
                        <template slot="header-title">
                            <h6 class="h6">VISION &amp;
                                MISSION</h6>
                        </template>
                        <template slot="body-content">
                            <p v-text="userProfile.vision_mission"></p>
                        </template>
                    </AccordionCard>
                    <!--<div class="accordion-card">-->
                    <!--<div class="accordion-card__head">-->
                    <!--<h6 class="h6">VISION &amp;-->
                    <!--MISSION</h6>-->
                    <!--<i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>-->
                    <!--<div class="accordion-card__hitarea"></div>-->
                    <!--</div>-->
                    <!--<div class="accordion-card__body"><p>NNI is the national-->
                    <!--specialist centre and regional centre for clinical referrals for the management and-->
                    <!--treatment of the neurosciences.</p></div>-->
                    <!--</div>-->
                </div>
                <div class="company-profile__options">
                    <div class="company-profile__description">

                        <AccordionCard containerClasses="accordion-card--borderless">
                            <template slot="header-title">
                                <h3 class="h3">About Us</h3>
                            </template>
                            <template slot="body-content">
                                <div class="body-txt break-word">{{userProfile.about}}</div>
                            </template>
                        </AccordionCard>

                        <AccordionCard containerClasses="accordion-card--borderless">
                            <template slot="header-title">
                                <h3 class="h3">Our Programmes</h3>
                            </template>
                            <template slot="body-content">
                                <div class="body-txt break-word">{{userProfile.our_programmes}}</div>
                            </template>
                        </AccordionCard>

                        <!--<div class="accordion-card accordion-card&#45;&#45;borderless">-->
                        <!--<div class="accordion-card__head"><h3 class="h3">Our-->
                        <!--Programmes</h3> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>-->
                        <!--<div class="accordion-card__hitarea"></div>-->
                        <!--</div>-->
                        <!--<div class="accordion-card__body">-->
                        <!--<div class="body-txt break-word"> Our-->
                        <!--programmes are centered around our 3 pillars - Education, Research and-->
                        <!--Clinical Services. We believe strongly in patients at the heart of all we-->
                        <!--do. Find out more at www.nni.com.sg today!-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->

                    </div>
                </div>

                <div class="company-profile__causes-contact">

                    <AccordionCard>
                        <template slot="header-title">
                            <h6 class="h6">SUPPORTED
                                CAUSES</h6>
                        </template>
                        <template slot="body-content">
                            <ul class="list list--spacing">
                                <li v-for="(item, idx) in userProfile.user_causes_display" :key="idx"><i
                                    :style="`background-image: url('${baseUrl}/assets/images/icon/causes/${item.small_icon}');`"
                                    class="ico ico--medium ico-community mr-8"></i>{{item.name}}
                                </li>
                            </ul>
                        </template>
                    </AccordionCard>

                    <AccordionCard containerClasses="mt-16">
                        <template slot="header-title">
                            <h6 class="h6">CONTACT
                                US</h6>
                        </template>
                        <template slot="body-content">
                            <div><h4 style="margin-bottom:10px">{{userProfile.contact_person}}</h4>
                                <p class="body-txt">{{userProfile.display_name}}</p></div>
                            <div class="mb-16"><i class="ico material-icons gray mr-6">call</i>
                                <a :href="`tel:${userProfile.phone_number}`"
                                   class="text-link text-link--dark-grey">{{userProfile.phone_number}}</a>
                            </div>
                            <div class="mb-16">
                                <i class="ico material-icons gray mr-6">email</i>
                                <a
                                    class="text-link text-link--dark-grey" :href="`mailto:${userProfile.public_email}`">{{userProfile.public_email}}</a>
                            </div>
                            <div class="mb-16">
                                <i class="ico material-icons gray mr-6">public</i>
                                <a
                                    :href="$utils.httpOrHttps(userProfile.website, true)"
                                    class="text-link text-link--dark-grey"
                                    target="_blank">{{userProfile.website}}</a></div>
                        </template>
                    </AccordionCard>

                    <ReportAbuse :data="{user_id: $store.state.authUserInfo.id, type: 'profile'}"
                                 :email="$store.state.userProfile.public_email || $store.state.authUserInfo.email"/>

                </div>
            </section>
        </div>
    </div>
</template>

<script>
    import AccordionCard from '@com/Utils/AccordionCard.vue'
    import Carousel from '@com/Utils/Carousel.vue'
    import ReportAbuse from '@com/Utils/ReportAbuse.vue'

    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'

    export default {
        name: "OrganizeProfile",
        props: {
            visible: {
                default: false
            }
        },
        data: () => ({
            ...mapGetters([]),
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
        components: {
            AccordionCard,
            ReportAbuse,
            Carousel
        },
        watch: {
            visible: function (n) {
                if (n) {
                    this.getUserProfile();
                } else {
                    this.destroyCarousel();
                }
            }
        },
        computed: {
            ...mapState(['authUserInfo', 'userProfile'])
        },
        methods: {
            ...mapMutations(['setUserProfile', 'setUserProfileKey']),
            ...mapActions(['showErrorToast', 'fetchOptionProfileData']),
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
                            this.setUserProfileKey({key: 'user_causes', value: d.user_causes});
                            this.setUserProfileKey({key: 'user_causes_display', value: d.user_causes_display});
                            this.setUserProfileKey({key: 'causes', value: d.causes});
                            this.setUserProfileKey({
                                key: 'user_media',
                                value: {video: d.user_media.video, images: d.user_media.images}
                            });
                            this.user_media = this.userProfile.user_media;
                            this.$nextTick(() => {
                                this.initCarousel();
                            })
                        }
                    })
                    .catch(err => {
                        console.log(err);
                        this.showErrorToast({msg: 'Failed to load your profile!', dt: 3500});
                    })
            },
            covertYoutubeUrlToEmBed(url) {
                let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                let match = url.match(regExp);

                if (match && match[2].length === 11) {
                    return `${match[2]}`;
                } else {
                    return '';
                }
            },

            initCarousel() {
                let carousel = this.$refs['organize-profile'];
                if (carousel) {
                    carousel.initCarousel();
                }
            },
            destroyCarousel() {
                let carousel = this.$refs['organize-profile'];
                if (carousel) {
                    carousel.removeCarousel();
                }
            },
            initData() {
                if (this.visible) {
                    this.user_media = this.userProfile.user_media;
                    this.getUserProfile();
                }
            }
        },
        created() {
            this.initData();
        }
    }
</script>

<style scoped>

</style>
