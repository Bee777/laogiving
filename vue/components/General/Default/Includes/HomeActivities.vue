<template>
    <div class="swiper-pad">
        <div class="swiper-arrow-wrap"
             style="transition-duration: 0ms;transform: translate3d(0px, 0px, 0px);">
            <Carousel ref="opportunities-volunteering"
                      type="card"
                      :options="opportunities"
                      containerClasses="js-cards-swiper-2">
                <template slot="slide-item">
                    <div class="swiper-slide"
                         v-for="(item, idx) in $store.state.homeData.activities.posts.data" :key="idx">
                        <!--CardItem-->
                        <div class="card card--flex">
                            <div class="card__head">
                                <div class="gradient-over-image">
                                    <div
                                        :style="`background-image: url(${item.images_media[0].image_base64});`"
                                        class="gradient-over-image__image--bg gradient-over-image__image">

                                    </div>
                                </div>
                                <div class="stats card__head-overlay font-white font-white"><span
                                    class="stats__num">{{getTotalVacancies(item)}}</span> <span
                                    class="stats__des">openings</span>
                                </div>
                            </div>
                            <!--Card Body-->
                            <div class="card__body">
                                <h2 class="card__title break-word truncate">
                                    {{item.name}}
                                </h2>
                                <div class="media-by">
                                    <p
                                        class="body-txt body-txt--smaller body-txt--no-letter-space font-mid-grey break-word">
                                        by <span
                                        class="bold break-word">{{item.organize}}</span>
                                    </p>
                                </div>

                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">event</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                        {{ getMonthsTextRange(item) }}
                                    </div>
                                </div>
                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">query_builder</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space">
                                                            <span
                                                                class="volunteer-preview-frequency volunteer-preview-start-time">{{ getFrequency()[item.frequency]}} on {{ getDaysOfWeek(item.days_of_week)}}</span>
                                        <br><span
                                        class="font-mid-grey body-txt--small frequency_duration_view">{{ item.duration}} hours per session</span>
                                    </div>
                                </div>
                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">place</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                        {{ item.town }}
                                    </div>
                                </div>
                                <div class="media-obj mt-16">
                                    <div class="media-obj__asset"><i
                                        class="material-icons ico--small">group</i></div>
                                    <div
                                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                        Suitable for: {{item.suitablesTexts}}
                                    </div>
                                </div>
                                <div class="card__cta">
                                    <button @click="openVolunteeringTab(item.id)"
                                            class="btn button--no-bg button--full">
                                        LEARN MORE
                                    </button>
                                </div>
                            </div>
                            <!--Card Body-->
                            <!--Card Link-->
                            <div>
                                <a class="card__link" :href="`/posts/volunteer-activity/${item.id}`"
                                   target="_blank"></a>
                            </div>
                            <!--Card Link-->
                        </div>
                        <!--CardItem-->
                    </div>
                </template>
                <template slot="swiper-control">
                    <content></content>
                </template>
            </Carousel>
            <div class="swiper-button-prev rotage op"></div>
            <div class="swiper-button-next op"></div>
        </div>
    </div>
</template>

<script>
    import Carousel from '@com/Utils/Carousel.vue'
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        name: "HomeActivities",
        components: {
            Carousel
        },
        data: () => ({
            opportunities: {
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next.op',
                    prevEl: '.swiper-button-prev.op',
                },
                spaceBetween: 0,
                slidesPerView: 4,
                breakpoints: {
                    // when window width is <= 480px
                    899: {
                        slidesPerView: 1,
                        spaceBetween: 0
                    },
                    // when window width is <= 640px
                    1200: {
                        slidesPerView: 2,
                        spaceBetween: 0
                    }
                },
                freeMode: false
            }
        }),
        watch: {
            '$store.state.homeData.activities.posts': function (d) {
                this.$nextTick(() => {
                    this.initCarousel();
                })
            }
        },
        methods: {
            openVolunteeringTab(id) {
                window.open(`/posts/volunteer-activity/${id}`);
            },
            initCarousel() {
                let opCarousel = this.$refs['opportunities-volunteering'];
                if (opCarousel) {
                    opCarousel.initCarousel();
                }
            },
            destroyCarousel() {
                let carousel = this.$refs['opportunities-volunteering'];
                if (carousel) {
                    carousel.removeCarousel();
                }
            }
        },
        mounted() {
            if ((this.$store.state.homeData.activities.posts.data || []).length > 0) {
                this.$nextTick(() => {
                    this.destroyCarousel();
                    this.initCarousel();
                })
            }
        }
    });
</script>

<style scoped>

</style>
