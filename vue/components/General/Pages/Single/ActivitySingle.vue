<template>
    <div>
        <main class="activity  pad clearfix objectfit">
            <div class="cWidth-1200">
                <section class="volunteer-event__body volunteer-event__body--flex">

                    <section class="volunteer-event__head-main swiper-container-horizontal">

                        <Carousel :hasVideos="true" ref="volunteering-profile">
                            <template slot="slide-item">
                                <div class="swiper-slide"
                                     v-if="singlePostsData.activities.data.video_media && singlePostsData.activities.data.video_media.url !==''">
                                    <div class="video-container none-active"
                                         :data-embed="covertYoutubeUrlToEmBed(singlePostsData.activities.data.video_media.url)">
                                    </div>
                                </div>
                                <div class="swiper-slide"
                                     v-for="(item, idx) in singlePostsData.activities.data.images_media"
                                     v-if="item.image_base64!==''" :key="idx">
                                    <img :alt="item.url" class="img-placeolder"
                                         :src="item.image_base64">
                                </div>
                            </template>
                        </Carousel>

                        <div class="swiper-pagination swiper-pagination-bullets"><span
                            class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>


                    </section>

                    <section class="volunteer-event__body-main order-2">

                        <AccordionCard containerClasses="accordion-card--borderless">
                            <template slot="header-title">
                                <h3 class="h3">About the Activity</h3>
                            </template>
                            <template slot="body-content">
                                <div class="body-txt break-word pre-wrap"
                                     v-html="singlePostsData.activities.data.description"></div>
                            </template>
                        </AccordionCard>

                        <AccordionCard containerClasses="accordion-card--borderless">
                            <template slot="header-title">
                                <h3 class="h3">Volunteer Positions</h3>
                            </template>
                            <template slot="body-content">
                                <div v-for="(item, idx) in singlePostsData.activities.data.positions" :key="idx"
                                     class="rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16">
                                    <div class="rounded-card__head rounded-card__head--white"><h3 class="h3">
                                        {{item.position_title}}</h3></div>
                                    <div class="rounded-card__body font-dark-grey light-blue"><span
                                        class="volunteer-event__pt-desc"> <span class="bold">Skills required:</span> {{getTagsText(item.position_skills, 'all_skills')}} </span>
                                        <span class="volunteer-event__pt-desc"> <span class="bold">Suitable for:</span> {{getTagsText(item.position_suitables, 'all_suitables')}} </span>
                                        <span class="volunteer-event__pt-desc"
                                              v-if="item.minimum_age > 0 && !$utils.isEmptyVar(item.minimum_age)"> <span
                                            class="bold">Min. age:</span> {{item.minimum_age}} </span>
                                        <div class=" mt-16 body-txt break-word pre-wrap" v-html="item.key_responsibilities"></div>
                                        <div class="mt-32"
                                        ><a :disabled="!canSeeSignUp(item.id)"
                                            @click="signUpVolunteering(item.id, singlePostsData.activities.data)"
                                            class="button-ctn cWhite button--small">VOLUNTEER FOR THIS</a>
                                            <span class="bold ml-8 ml-8">{{item.vacancies}} openings</span></div>
                                    </div>
                                </div>
                            </template>

                        </AccordionCard>


                        <!--<section class="accordion-card accordion-card&#45;&#45;borderless">-->
                        <!--<div class="accordion-card__head">-->
                        <!--<h3 class="h3">Volunteer Positions</h3>-->
                        <!--<i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>-->
                        <!--<div class="accordion-card__hitarea"></div>-->
                        <!--</div>-->
                        <!--<div class="accordion-card__body">-->
                        <!--<div-->
                        <!--class="rounded-card rounded-card&#45;&#45;plain rounded-card&#45;&#45;reset-margin rounded-card&#45;&#45;mt-16">-->
                        <!--<div class="rounded-card__head rounded-card__head&#45;&#45;white"><h3 class="h3">Front of-->
                        <!--House</h3></div>-->
                        <!--<div class="rounded-card__body font-dark-grey light-blue"><span-->
                        <!--class="volunteer-event__pt-desc"> <span class="bold">Skills required:</span> No Specific Skills Required </span>-->
                        <!--<span class="volunteer-event__pt-desc"> <span class="bold">Suitable for:</span> Open to All </span>-->
                        <!--<span class="volunteer-event__pt-desc"> <span class="bold">Min. age:</span> 18 </span>-->
                        <!--<div class=" mt-16 body-txt"> We are looking for volunteers to help-->
                        <!--out with FOH duties such as sale of programmes, answering enquires, and-->
                        <!--ushering. Volunteers will also assist in carrying out other duties such as-->
                        <!--headphones distributions, drinks services and managing sale of accessories.-->
                        <!--</div>-->
                        <!--<div class="mt-32"-->
                        <!--&gt;<a @click="show()"-->
                        <!--class="button-ctn cWhite button&#45;&#45;small">VOLUNTEER FOR THIS</a>-->
                        <!--<span class="bold ml-8 ml-8">7 openings</span></div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</section>-->

                        <AccordionCard containerClasses="accordion-card--borderless"
                                       v-if="singlePostsData.activities.data.points_to_note">
                            <template slot="header-title">
                                <h3 class="h3">Point to note</h3>
                            </template>
                            <template slot="body-content">
                                <div class="pre-wrap break-word" v-html="singlePostsData.activities.data.points_to_note"></div>
                            </template>
                        </AccordionCard>

                    </section>

                    <aside class="volunteer-event__head-aside order-1">
                        <div class="volunteer-event__detail flex flex-column">
                            <h2 class="h2 volunteer-event__title">{{singlePostsData.activities.data.name }}</h2>
                            <div class="volunteer-event__by font-mid-grey">
                                <img v-if="shouldShowSingle(type)"
                                     :src="`${baseUrl}${singlePostsData.activities.data.organize_image}`"
                                     class="profile-pic profile-pic--small mr-16">
                                <h4 class="h4 breakword">by <a
                                    v-if="singlePostsData.activities.data.visibility === 'visible'" class="cursor"
                                    @click="Route({name: 'organize-profile', params: {id: singlePostsData.activities.data.user_id  }})"
                                    style="color:#6bc1cc !important;">{{singlePostsData.activities.data.organize_name}}</a>
                                    <a v-else
                                       style="color:#6bc1cc !important;">{{singlePostsData.activities.data.organize_name}}</a>
                                </h4>
                            </div>
                            <!--Share-->
                            <div class="social-list social-list--just-left mt-16">
                                <a class="button-ctn button--icon button--ghost "
                                   target="_blank"
                                   :href="sharer('fb', type, singlePostsData.activities.data, link)"
                                   title="Facebook"> <i class="material-icons button--icon__icon">share</i>
                                    <span class="button--icon__name">SHARE</span>
                                </a>
                                <label class="btn-checkbox-btn btn-checkbox-btn--save ">
                                    <input v-if="LoggedIn()" v-model="bookmarkVolunteering" type="checkbox"
                                           name="saving-bookmark"
                                           @change="saveMyBookmark(singlePostsData.activities.data)">
                                    <input v-else disabled type="checkbox">
                                    <span @click="checkingSaveBookmark()" class="button-ctn button--icon button--ghost">
                                      <i class="material-icons ico-save button--icon__icon">bookmark_border</i>
                                      <span class="button--icon__name">SAVE</span>
                                    </span>
                                </label>
                                <a class="button-ctn button--icon button--ghost"
                                   @click="copyToClipboard({text: link})"
                                   title="Link copy to clipboard"> <i class="material-icons button--icon__icon">link</i>
                                    <span class="button--icon__name">LINK</span>
                                </a>
                            </div>
                            <!--Share-->
                            <!--Detail Items-->
                            <div class="volunteer-event__venue">
                                <div class="flag-obj volunteer-event__venue-item">
                                    <div class="flag-obj__item"><i class="material-icons">event</i></div>
                                    <div v-if="shouldShowSingle(type)"
                                         class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                        {{ singlePostsData.activities.data.start_date_formatted }} to
                                        {{ singlePostsData.activities.data.end_date_formatted }}
                                    </div>
                                </div>
                                <div class="flag-obj volunteer-event__venue-item">
                                    <div class="flag-obj__item"><i class="material-icons">query_builder</i></div>
                                    <div v-if="shouldShowSingle(type)"
                                         class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                        <span class="volunteer-preview-frequency volunteer-preview-start-time">{{ getFrequency()[singlePostsData.activities.data.frequency]}} on {{ getDaysOfWeek(singlePostsData.activities.data.days_of_week)}}</span>
                                        <br><span
                                        class="font-mid-grey body-txt--small frequency_duration_view">{{ singlePostsData.activities.data.duration }} hours per session</span>
                                    </div>
                                    <!--<div-->
                                    <!--class="flag-obj__item flag-obj__item&#45;&#45;top flag-obj__item&#45;&#45;narrow flag-obj__item&#45;&#45;text">-->
                                    <!--6:00 PM TO 10:30 PM-->
                                    <!--<div class="font-mid-grey body-txt&#45;&#45;small">4.5 hours</div>-->
                                    <!--</div>-->
                                </div>
                                <div class="flag-obj volunteer-event__venue-item">
                                    <div class="flag-obj__item"><i class="material-icons">place</i></div>
                                    <div
                                        class="flag-obj__item flag-obj__item--top flag-obj__item--narrow flag-obj__item--text">
                                        {{ singlePostsData.activities.data.town }}
                                        <div class="font-mid-grey body-txt--small">
                                            {{ singlePostsData.activities.data.block_street }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flag-obj volunteer-event__venue-item mb-32">
                                    <div class="flag-obj__item"><i class="material-icons">group</i></div>
                                    <div v-if="shouldShowSingle(type)"
                                         class="flag-obj__item flag-obj__item--mid flag-obj__item--narrow flag-obj__item--text">
                                        Suitable for: {{ getSuitablesText(singlePostsData.activities.data.positions) }}
                                    </div>
                                </div>
                                <p class="body-txt--small font-mid-grey bold text-center">Sign up before {{
                                    singlePostsData.activities.data.deadline_sign_ups_date_formatted }}</p>
                                <button :disabled="!canSeeSignUp('all')"
                                        @click="signUpVolunteering('all', singlePostsData.activities.data)"
                                        class="button-ctn button--large button--full">VOLUNTEER NOW
                                </button>
                            </div>
                            <!--Detail Items-->
                        </div>
                    </aside>

                    <section class="volunteer-event__causes-contact order-3">

                        <AccordionCard>
                            <template slot="header-title">
                                <h6 class="h6">SUPPORTED CAUSES</h6>
                            </template>
                            <template slot="body-content">
                                <ul class="list list--spacing" style="margin-left: 0;">
                                    <li v-for="(item, idx) in singlePostsData.activities.data.activity_causes_display"
                                        :key="idx"><i
                                        :style="`background-image: url('${baseUrl}/assets/images/icon/causes/${item.small_icon}');`"
                                        class="ico ico--medium ico-community mr-8"></i>{{item.name}}
                                    </li>
                                </ul>
                            </template>
                        </AccordionCard>


                        <!--<div class="accordion-card">-->
                        <!--<div class="accordion-card__head">-->
                        <!--<h6 class="h6">SUPPORTED CAUSES</h6>-->
                        <!--<i class="material-icons accordion-card__chevron"-->
                        <!--&gt;keyboard_arrow_up</i>-->
                        <!--<div class="accordion-card__hitarea"></div>-->
                        <!--</div>-->
                        <!--<div class="accordion-card__body">-->
                        <!--<div class="mb-16">-->
                        <!--<i class="ico ico&#45;&#45;medium ico-arts mr-8"></i>Arts &amp; Heritage-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <AccordionCard containerClasses="mt-16">
                            <template slot="header-title">
                                <h6 class="h6">CONTACT US</h6>
                            </template>
                            <template slot="body-content">
                                <div>
                                    <h4 class="h4">{{ singlePostsData.activities.data.contact_name }}</h4>
                                    <p>{{singlePostsData.activities.data.organize_name}}</p>
                                </div>
                                <div class="mb-16 lh20-fs-16"><i class="ico material-icons gray mr-6">call</i>
                                    <a :href="`tel:${singlePostsData.activities.data.contact_phone_number}`"
                                       class="text-link text-link--dark-grey lh20-fs-16">{{
                                        singlePostsData.activities.data.contact_phone_number }}</a>
                                </div>
                                <div class="mb-16 lh20-fs-16"><i class="ico material-icons gray mr-6">email</i>
                                    <a class="text-link text-link--dark-grey"
                                       :href="`mailto:${singlePostsData.activities.data.contact_email}`">{{
                                        singlePostsData.activities.data.contact_email }}</a>
                                </div>
                            </template>
                        </AccordionCard>

                        <!--<div class="accordion-card">-->
                        <!--<div class="accordion-card__head">-->
                        <!--<h6 class="h6">CONTACT US</h6>-->
                        <!--<i class="material-icons accordion-card__chevron"-->
                        <!--&gt;keyboard_arrow_up</i>-->
                        <!--<div class="accordion-card__hitarea"></div>-->
                        <!--</div>-->
                        <!--<div class="accordion-card__body">-->
                        <!--<div>-->
                        <!--<h4 class="h4">Mervyn Quek</h4>-->
                        <!--<p>TheatreWorks (Singapore) Limited</p>-->
                        <!--</div>-->
                        <!--<div class="mb-16 lh20-fs-16"><i class="ico material-icons gray mr-6">call</i>-->
                        <!--<a href="tel:96801951"-->
                        <!--class="text-link text-link&#45;&#45;dark-grey lh20-fs-16">96801951</a>-->
                        <!--</div>-->
                        <!--<div class="mb-16 lh20-fs-16"><i class="ico material-icons gray mr-6">email</i>-->
                        <!--<a class="text-link text-link&#45;&#45;dark-grey" href="mailto:mervyn@theatreworks.org.sg">mervyn@theatreworks.org.sg</a>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->

                        <!--<div class="text-center mb-16">-->
                        <!--<a id="report-abuse-button" class="text-link"><i class="ico  material-icons ico-flag mr-8">outlined_flag</i>Report-->
                        <!--abuse</a>-->
                        <!--</div>-->
                        <ReportAbuse :data="{ activity_id: singleId , type: 'volunteering'}"
                                     :email="(authUserInfo.profile && authUserInfo.profile.public_email) || authUserInfo.email || ''"/>
                    </section>
                    <section class="volunteer-event__footer order-4 mb-40">

                        <AccordionCard containerClasses="accordion-card--borderless mt--1">
                            <template slot="header-title">
                                <h3 class="h3">Volunteers</h3>
                            </template>
                            <template slot="body-content">
                                <div class="dbl-stats mt-16">
                                    <div class="dbl-stats__item">
                                        <div class="dbl-stats__stats">{{getVolunteersStatus().confirm}}
                                        </div>
                                        <div class="dbl-stats__desc">confirmed</div>
                                    </div>
                                    <div class="dbl-stats__item">
                                        <div class="dbl-stats__stats">{{getVolunteersStatus().pending}}</div>
                                        <div class="dbl-stats__desc">pending</div>
                                    </div>
                                </div>
                                <div class="profile-list mt-16" data-role="js-show-more-element">
                                    <img :key="idx" v-for="(item, idx) in getVolunteersStatus().confirm_users"
                                         :src="`${baseUrl}${item.full_image_path}`" :alt="item.user_name"
                                         class="profile-pic">
                                    <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                                    <!--class="profile-pic">-->

                                    <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                                    <!--class="profile-pic">-->

                                    <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                                    <!--class="profile-pic">-->

                                </div>
                            </template>
                        </AccordionCard>

                        <!--<section class="accordion-card accordion-card&#45;&#45;borderless mt&#45;&#45;1">-->
                        <!--<div class="accordion-card__head">-->
                        <!--<h3 class="h3">Volunteers</h3>-->
                        <!--<i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>-->
                        <!--<div class="accordion-card__hitarea"></div>-->
                        <!--</div>-->
                        <!--<div class="accordion-card__body">-->
                        <!--<div class="dbl-stats mt-16">-->
                        <!--<div class="dbl-stats__item">-->
                        <!--<div class="dbl-stats__stats">4-->
                        <!--</div>-->
                        <!--<div class="dbl-stats__desc">confirmed</div>-->
                        <!--</div>-->
                        <!--<div class="dbl-stats__item">-->
                        <!--<div class="dbl-stats__stats">0</div>-->
                        <!--<div class="dbl-stats__desc">pending</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="profile-list mt-16" data-role="js-show-more-element">-->

                        <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                        <!--class="profile-pic">-->

                        <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                        <!--class="profile-pic">-->

                        <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                        <!--class="profile-pic">-->

                        <!--<img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""-->
                        <!--class="profile-pic">-->

                        <!--</div>-->
                        <!--</div>-->
                        <!--</section>-->

                        <h3 class="h3">More Opportunities</h3>

                        <div class="swiper-pad">
                            <div class="swiper-arrow-wrap"
                                 style="transition-duration: 0ms;transform: translate3d(0px, 0px, 0px);">
                                <Carousel ref="opportunities-volunteering"
                                          type="card"
                                          :options="opportunities"
                                          containerClasses="js-cards-swiper-2"
                                          v-show="shouldShowSingle(type)">
                                    <template slot="slide-item">
                                        <div class="swiper-slide"
                                             v-for="(item, idx) in singlePostsData.activities.others" :key="idx">
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

                        <!--<div class="swiper-pad">-->
                        <!--<div class="swiper-arrow-wrap"-->
                        <!--style="transition-duration: 0ms;transform: translate3d(0px, 0px, 0px);">-->
                        <!--<div class="swiper-container js-cards-swiper-2" id="swiper-container-opportunities">-->
                        <!--<div class="swiper-wrapper ">-->
                        <!--<div class="swiper-slide" v-for="i in 3" :key="i">-->
                        <!--&lt;!&ndash;CardItem&ndash;&gt;-->
                        <!--<div class="card card&#45;&#45;flex">-->
                        <!--<div class="card__head">-->
                        <!--<div class="gradient-over-image">-->
                        <!--<div-->
                        <!--:style="`background-image: url(https://www.giving.sg/image/logo?img_id=9040323);`"-->
                        <!--class="gradient-over-image__image&#45;&#45;bg gradient-over-image__image">-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="stats card__head-overlay font-white font-white"><span-->
                        <!--class="stats__num">30</span> <span-->
                        <!--class="stats__des">openings</span>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--&lt;!&ndash;Card Body&ndash;&gt;-->
                        <!--<div class="card__body">-->
                        <!--<h2 class="card__title break-word truncate">-->
                        <!--FOH Volunteers for TheatreWorks' Production {{ i }}-->
                        <!--</h2>-->
                        <!--<div class="media-by">-->
                        <!--<p-->
                        <!--class="body-txt body-txt&#45;&#45;smaller body-txt&#45;&#45;no-letter-space font-mid-grey break-word">-->
                        <!--by <span-->
                        <!--class="bold break-word">TheatreWorks (Singapore) Limited</span>-->
                        <!--</p>-->
                        <!--</div>-->
                        <!--<div class="media-obj mt-16">-->
                        <!--<div class="media-obj__asset"><i-->
                        <!--class="material-icons ico&#45;&#45;small">event</i></div>-->
                        <!--<div-->
                        <!--class="media-obj__main media-obj__main&#45;&#45;small-spacing body-txt body-txt&#45;&#45;small">-->
                        <!--Thu, 02 May 2019-->
                        <!--&lt;!&ndash;<span&ndash;&gt;-->
                        <!--&lt;!&ndash;class="other-date-label">+3 other dates</span>&ndash;&gt;-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="media-obj mt-16">-->
                        <!--<div class="media-obj__asset"><i-->
                        <!--class="material-icons ico&#45;&#45;small">query_builder</i></div>-->
                        <!--<div-->
                        <!--class="media-obj__main media-obj__main&#45;&#45;small-spacing body-txt body-txt&#45;&#45;small">-->
                        <!--6:00 PM to 10:00 PM-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="media-obj mt-16">-->
                        <!--<div class="media-obj__asset"><i-->
                        <!--class="material-icons ico&#45;&#45;small">place</i></div>-->
                        <!--<div-->
                        <!--class="media-obj__main media-obj__main&#45;&#45;small-spacing body-txt body-txt&#45;&#45;small">-->
                        <!--River Valley-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="media-obj mt-16">-->
                        <!--<div class="media-obj__asset"><i-->
                        <!--class="material-icons ico&#45;&#45;small">group</i></div>-->
                        <!--<div-->
                        <!--class="media-obj__main media-obj__main&#45;&#45;small-spacing body-txt body-txt&#45;&#45;small">-->
                        <!--Suitable for: Open to All-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="card__cta">-->
                        <!--<button class="btn button&#45;&#45;no-bg button&#45;&#45;full">LEARN MORE-->
                        <!--</button>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--&lt;!&ndash;Card Body&ndash;&gt;-->
                        <!--&lt;!&ndash;Card Link&ndash;&gt;-->
                        <!--<div>-->
                        <!--<a class="card__link" href="/posts/volunteer-activity/1"-->
                        <!--target="_blank"></a>-->
                        <!--</div>-->
                        <!--&lt;!&ndash;Card Link&ndash;&gt;-->
                        <!--</div>-->
                        <!--&lt;!&ndash;CardItem&ndash;&gt;-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--<div class="swiper-button-prev rotage op"></div>-->
                        <!--<div class="swiper-button-next op"></div>-->
                        <!--</div>-->
                        <!--</div>-->

                    </section>
                </section>
            </div>
        </main>
    </div>

</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'
    import AccordionCard from '@com/Utils/AccordionCard.vue'
    import Carousel from '@com/Utils/Carousel.vue'
    import ReportAbuse from '@com/Utils/ReportAbuse.vue'
    import {mapActions} from 'vuex'

    export default Base.extend({
        name: 'ActivitySingle',
        components: {
            AccordionCard,
            ReportAbuse,
            Carousel
        },
        data: () => ({
            type: 'activities',
            link: '',
            bookmarkVolunteering: false,
            opportunities: {
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
            }
        }),
        watch: {
            'validate_errors.loading_single_posts': function (n) {
                //please clone the queries for editable queries working
                if (n) {
                    this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                } else {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                }
            },
            '$route.params': function (n, o) {
                this.$utils.scrollToY('html,body', 10);
                this.singleId = n.id;
                this.link = this.baseUrl + this.$route.fullPath;
                this.fetchSinglePostsData({type: this.type, id: this.singleId});
            }
        },
        methods: {
            ...mapActions(['copyToClipboard']),
            saveMyBookmark(data) {
                if (this.LoggedIn()) {
                    this.postSaveBookMark({
                        post_id: data.id,
                        type: 'activity',
                        checked: this.bookmarkVolunteering
                    }).then((res) => {
                        if (!res.success) {
                            this.bookmarkVolunteering = false;
                        }
                    }).catch(() => {
                        this.bookmarkVolunteering = false;
                    });
                } else {
                    this.toaster('You do not have permission to favourite')
                }
            },
            setItem(data) {
                this.bookmarkVolunteering = !(!(data.data.saved_bookmark));
                this.setPageTitle(data.data.name + ' - Activity Volunteering');
                this.$nextTick(() => {
                    this.initCarousel();
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
            openVolunteeringTab(id) {
                window.open(`/posts/volunteer-activity/${id}`);
            },
            getSuitablesText(positions) {
                let suitablesTexts = [];
                positions.map(i => {
                    i.position_suitables.map(suitable => {
                        let mSuitable = this.homeData.all_suitables.filter((filter) => {
                            return filter.id === suitable;
                        }).map(i => i.name).join('');
                        if (suitablesTexts.indexOf(mSuitable) === -1) {
                            suitablesTexts.push(mSuitable);
                        }
                    });
                });
                return suitablesTexts.join(', ');
            },
            getTagsText(tags, type) {
                let tagsText = [];
                tags.map(tag => {
                    let mTag = this.homeData[type].filter((filter) => {
                        return filter.id === tag;
                    }).map(i => i.name).join('');
                    if (tagsText.indexOf(mTag) === -1) {
                        tagsText.push(mTag);
                    }
                });
                return tagsText.join(', ');
            },
            initCarousel() {
                let carousel = this.$refs['volunteering-profile'];
                if (carousel) {
                    carousel.initCarousel();
                }
                let moreCarousel = this.$refs['opportunities-volunteering'];
                if (moreCarousel) {
                    moreCarousel.initCarousel();
                }
            },
            canSeeSignUp(position) {
                let positions = this.getVolunteersStatus();
                let total_vacancies_left = positions.total_vacancies - positions.confirm;
                let defaultCond = this.singlePostsData.activities.data.already_sign_up
                    || this.singlePostsData.activities.data.view_by_owner
                    || this.singlePostsData.activities.data.view_by_admin;
                //need to check if position vacancies if full or not
                if (position !== 'all') {
                    let selected_position = positions.positions.filter(item => {
                        return item.id === position;
                    }).shift() || {};
                    //general user
                    if (defaultCond) {
                        return true;
                    }
                    if (this.singlePostsData.activities.data.can_sign_up) {
                        return selected_position.total_vacancies_left > 0;
                    }
                    return false;
                }
                //general user
                if (defaultCond) {
                    return true;
                }
                if (this.singlePostsData.activities.data.can_sign_up) {
                    return total_vacancies_left > 0;
                }
                return false;
            },
            signUpVolunteering(position, activity) {
                if (!this.canSeeSignUp(position)) {
                    return;
                }
                if (this.LoggedIn()) {
                    this.$modal.show('volunteer-signup', {
                        position,
                        activity,
                        loading: false,
                        datePicker: null,
                        model: {
                            volunteer_contact_phone_number: (this.authUserInfo.profile ? this.authUserInfo.profile.phone_number : ''),
                            volunteer_position: ''
                        }
                    });
                } else {
                    this.$modal.show('signin', {action: 'sign-up-volunteering', position, activity})
                }
            },
            checkingSaveBookmark() {
                if (!this.LoggedIn()) {
                    this.toaster('You do not have permission to favourite')
                }
            },
            onSignUpSuccess() {
                this.fetchSinglePostsData({type: this.type, id: this.singleId});
            },
            getVolunteersStatus() {
                let data = this.singlePostsData.activities.data;
                let confirm = 0;
                let pending = 0;
                let confirm_users = [];
                let total_vacancies = 0;
                let positionsData = data && data.positions || [];
                positionsData.map(pos => {
                    total_vacancies += pos.vacancies;
                    confirm += pos.active_opportunity || 0;
                    pending += pos.total_pending || 0;
                    confirm_users = [...confirm_users, ...pos.confirm_users];
                });
                return {
                    confirm: confirm,
                    pending: pending,
                    confirm_users: confirm_users,
                    total_vacancies: total_vacancies,
                    positions: positionsData,
                };
            }
        },
        mounted() {

        },
        created() {
            this.setPageTitle('Activity Volunteering ');
            this.link = this.baseUrl + this.$route.fullPath;
            this.registerWatches();
            this.singleId = this.$route.params.id;
            this.fetchSinglePostsData({type: this.type, id: this.singleId});
            this.saveMyBookmark = this.debounce(this.saveMyBookmark, 250);
            //on register success
            this.Event.listen('on_sign_up_success', (d) => {
                this.onSignUpSuccess(d)
            })
        }
    });
</script>

<style scoped>
    /**https://www.giving.sg/volunteer-event?event_activity_id=9123691 */
</style>
