<template>
    <div>
        <main class="activity  pad clearfix">
            <div class="cWidth-1200">
                <section class="volunteer-event__body volunteer-event__body--flex">

                    <section class="volunteer-event__head-main">
                        <div class="swiper-container--images swiper-container">
                            <div class="swiper-wrapper objectfit">
                                <div class="swiper-slide">
                                    <img alt="" class="img-placeolder"
                                         src="https://www.giving.sg/image/logo?img_id=9040323">
                                </div>
                            </div>
                            <div class="swiper-button-prev rotage"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </section>

                    <section class="volunteer-event__body-main order-2">
                        <section class="accordion-card--borderless accordion-card">
                            <div class="accordion-card__head">
                                <h3 class="h3">About the Activity</h3>
                                <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div class="body-txt"> Be involved in TheatreWorks' latest performance
                                    featuring singer-songwriter Inch Chua's first full-length script based on her recent
                                    expedition to Antarctica! This is a multi-sensory performance featuring original
                                    compositions and presented with binaural technology.<br><br>Check this link for info
                                    of the work - http://theatreworks.org.sg/singapore/til_the_end/index.html
                                </div>
                            </div>
                        </section>

                        <section class="accordion-card accordion-card--borderless">
                            <div class="accordion-card__head">
                                <h3 class="h3">Volunteer Positions</h3>
                                <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div
                                    class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                    <div class="rounded-card__head rounded-card__head--white"><h3 class="h3">Front of
                                        House</h3></div>
                                    <div class="rounded-card__body font-dark-grey light-blue"><span
                                        class="volunteer-event__pt-desc"> <span class="bold">Skills required:</span> No Specific Skills Required </span>
                                        <span class="volunteer-event__pt-desc"> <span class="bold">Suitable for:</span> Open to All </span>
                                        <span class="volunteer-event__pt-desc"> <span class="bold">Min. age:</span> 18 </span>
                                        <div class=" mt-16 body-txt"> We are looking for volunteers to help
                                            out with FOH duties such as sale of programmes, answering enquires, and
                                            ushering. Volunteers will also assist in carrying out other duties such as
                                            headphones distributions, drinks services and managing sale of accessories.
                                        </div>
                                        <div class="mt-32"
                                        ><a @click="show()"
                                            class="button-ctn cWhite button--small">VOLUNTEER FOR THIS</a>
                                            <span class="bold ml-8 ml-8">7 openings</span></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </section>

                    <aside class="volunteer-event__head-aside order-1">
                        <div class="volunteer-event__detail flex flex-column">
                            <h2 class="h2 volunteer-event__title">FOH Volunteers for TheatreWorks' Production</h2>
                            <div class="volunteer-event__by font-mid-grey">
                                <img
                                    src="https://www.giving.sg/image/logo?img_id=3083368&amp;width=382"
                                    class="profile-pic profile-pic--small mr-16">
                                <h4 class="h4 breakword">by <a class="cursor"
                                                               @click="Route({name: 'organize-profile', params: {id: 11911}})"
                                                               style="color:#6bc1cc !important;">TheatreWorks
                                    (Singapore) Limited</a></h4>
                            </div>
                            <!--Share-->
                            <div class="social-list social-list--just-left mt-16">
                                <a class="button-ctn button--icon button--ghost "
                                   title="Facebook"> <i class="material-icons button--icon__icon">share</i>
                                    <span class="button--icon__name">SHARE</span>
                                </a>
                                <label class="btn-checkbox-btn btn-checkbox-btn--save ">
                                    <input type="checkbox" name="saving-bookmark">
                                    <span class="button-ctn button--icon button--ghost">
                                      <i class="material-icons ico-save button--icon__icon">bookmark_border</i>
                                      <span class="button--icon__name">SAVE</span>
                                    </span>
                                </label>
                                <a class="button-ctn button--icon button--ghost "
                                   title="Link copy to clipboard"> <i class="material-icons button--icon__icon">link</i>
                                    <span class="button--icon__name">LINK</span>
                                </a>
                            </div>
                            <!--Share-->
                            <!--Detail Items-->
                            <div class="volunteer-event__venue">
                                <div class="flag-obj volunteer-event__venue-item">
                                    <div class="flag-obj__item"><i class="material-icons">event</i></div>
                                    <div
                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                        Sat, 04 May
                                        2019
                                    </div>
                                </div>
                                <div class="flag-obj volunteer-event__venue-item">
                                    <div class="flag-obj__item"><i class="material-icons">query_builder</i></div>
                                    <div
                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                        6:00 PM TO 10:30 PM
                                        <div class="font-mid-grey body-txt--small">4.5 hours</div>
                                    </div>
                                </div>
                                <div class="flag-obj volunteer-event__venue-item">
                                    <div class="flag-obj__item"><i class="material-icons">place</i></div>
                                    <div
                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                        River Valley
                                        <div class="font-mid-grey body-txt--small">
                                            72-13 MOHAMED SULTAN ROAD <br>
                                            Singapore 239007
                                        </div>
                                    </div>
                                </div>
                                <div class="flag-obj volunteer-event__venue-item mb-32">
                                    <div class="flag-obj__item"><i class="material-icons">group</i></div>
                                    <div
                                        class="flag-obj__item flag-obj__item--mid flag-obj__item--narrow flag-obj__item--text">
                                        Suitable for: Open to All
                                    </div>
                                </div>
                                <p class="body-txt--small font-mid-grey bold text-center">Sign up before 3 May 2019,
                                    06:00 PM</p>
                                <button @click="show()" class="button-ctn button--large button--full">VOLUNTEER NOW
                                </button>
                            </div>
                            <!--Detail Items-->
                        </div>
                    </aside>

                    <section class="volunteer-event__causes-contact order-3">
                        <div class="accordion-card">
                            <div class="accordion-card__head">
                                <h6 class="h6">SUPPORTED CAUSES</h6>
                                <i class="material-icons accordion-card__chevron"
                                >keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div class="mb-16">
                                    <i class="ico ico--medium ico-arts mr-8"></i>Arts &amp; Heritage
                                </div>
                            </div>
                        </div>
                        <div class="accordion-card">
                            <div class="accordion-card__head">
                                <h6 class="h6">CONTACT US</h6>
                                <i class="material-icons accordion-card__chevron"
                                >keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div>
                                    <h4 class="h4">Mervyn Quek</h4>
                                    <p>TheatreWorks (Singapore) Limited</p>
                                </div>
                                <div class="mb-16 lh20-fs-16"><i class="ico material-icons gray mr-6">call</i>
                                    <a href="tel:96801951"
                                       class="text-link text-link--dark-grey lh20-fs-16">96801951</a>
                                </div>
                                <div class="mb-16 lh20-fs-16"><i class="ico material-icons gray mr-6">email</i>
                                    <a class="text-link text-link--dark-grey" href="mailto:mervyn@theatreworks.org.sg">mervyn@theatreworks.org.sg</a>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-16">
                            <a id="report-abuse-button" class="text-link"><i class="ico  material-icons ico-flag mr-8">outlined_flag</i>Report
                                abuse</a>
                        </div>
                    </section>
                    <section class="volunteer-event__footer order-4 mb-40">
                        <section class="accordion-card accordion-card--borderless mt--1">
                            <div class="accordion-card__head">
                                <h3 class="h3">Volunteers</h3>
                                <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div class="dbl-stats mt-16">
                                    <div class="dbl-stats__item">
                                        <div class="dbl-stats__stats">4
                                        </div>
                                        <div class="dbl-stats__desc">confirmed</div>
                                    </div>
                                    <div class="dbl-stats__item">
                                        <div class="dbl-stats__stats">0</div>
                                        <div class="dbl-stats__desc">pending</div>
                                    </div>
                                </div>
                                <div class="profile-list mt-16" data-role="js-show-more-element">

                                    <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""
                                         class="profile-pic">

                                    <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""
                                         class="profile-pic">

                                    <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""
                                         class="profile-pic">

                                    <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""
                                         class="profile-pic">

                                </div>
                            </div>
                        </section>

                        <h3 class="h3">More Opportunities</h3>
                        <div class="swiper-pad">
                            <div class="swiper-arrow-wrap" style="transition-duration: 0ms;transform: translate3d(0px, 0px, 0px);">
                                <div class="swiper-container" id="swiper-container-opportunities">
                                    <div class="swiper-wrapper ">
                                        <div class="swiper-slide" v-for="i in 3" :key="i">
                                            <!--CardItem-->
                                            <div class="card card--flex">
                                                <div class="card__head">
                                                    <div class="gradient-over-image">
                                                        <div
                                                            :style="`background-image: url(https://www.giving.sg/image/logo?img_id=9040323);`"
                                                            class="gradient-over-image__image--bg gradient-over-image__image">
                                                        </div>
                                                    </div>
                                                    <div class="stats card__head-overlay font-white font-white"><span
                                                        class="stats__num">30</span> <span
                                                        class="stats__des">openings</span>
                                                    </div>
                                                </div>
                                                <!--Card Body-->
                                                <div class="card__body">
                                                    <h2 class="card__title break-word truncate">
                                                        FOH Volunteers for TheatreWorks' Production {{ i }}
                                                    </h2>
                                                    <div class="media-by">
                                                        <p
                                                            class="body-txt body-txt--smaller body-txt--no-letter-space font-mid-grey break-word">
                                                            by <span
                                                            class="bold break-word">TheatreWorks (Singapore) Limited</span>
                                                        </p>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">event</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            Thu, 02 May 2019
                                                            <!--<span-->
                                                            <!--class="other-date-label">+3 other dates</span>-->
                                                        </div>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">query_builder</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            6:00 PM to 10:00 PM
                                                        </div>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">place</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            River Valley
                                                        </div>
                                                    </div>
                                                    <div class="media-obj mt-16">
                                                        <div class="media-obj__asset"><i
                                                            class="material-icons ico--small">group</i></div>
                                                        <div
                                                            class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small">
                                                            Suitable for: Open to All
                                                        </div>
                                                    </div>
                                                    <div class="card__cta">
                                                        <button class="btn button--no-bg button--full">LEARN MORE</button>
                                                    </div>
                                                </div>
                                                <!--Card Body-->
                                                <!--Card Link-->
                                                <div>
                                                    <a class="card__link" href="/posts/volunteer-activity/1"
                                                       target="_blank"></a>
                                                </div>
                                                <!--Card Link-->
                                            </div>
                                            <!--CardItem-->
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-button-prev rotage op"></div>
                                <div class="swiper-button-next op"></div>
                            </div>
                        </div>

                    </section>
                </section>
            </div>
        </main>
    </div>

</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        name: 'ActivitySingle',
        data: () => ({
            type: 'ActivitySingle',
        }),
        methods: {
            initCarousel() {
                new Swiper('.swiper-container--images', {
                    loop: true,
                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    spaceBetween: 10,
                });
                new Swiper('#swiper-container-opportunities', {
                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next.op',
                        prevEl: '.swiper-button-prev.op',
                    },
                    spaceBetween: 0,
                    slidesPerView: 3,
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
                })
            },
            show() {
                this.$modal.show('volunteer-signup');
            },
        },
        mounted() {
            this.initCarousel();
        },
        created() {
            this.setPageTitle('Activity - ');
        }
    });
</script>

<style scoped>
    /**https://www.giving.sg/volunteer-event?event_activity_id=9123691 */
</style>
