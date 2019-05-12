<template>
    <main class="laogiving activity pad clearfix">

        <section class="page-top pt-40">
            <div class="cWidth-1200">

                <button @click="Route({name: 'home', query: {active_page: 'our-volunteering' } })"
                        class="button-ctn font-bold button--with-icon button--no-bg button--large button--no-left-pad back-button">
                    <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                        class="ico material-icons button--with-icon__icon">keyboard_backspace</i> BACK
                    </div>
                </button>

                <h2 class="h3-tablet-landscape-up-h2 mt-24"><span class="mr-8">FOH Volunteers for TheatreWorks' Production 1</span>
                </h2>


                <div class="flex-ctn flex-ctn--dir-col-custom-768-up-row flex-ctn--just-spc-btw mt-8">
                    <div>
                        <div class="media-obj">
                            <div class="media-obj__asset"><i class="ico ico--small material-icons">place</i></div>
                            <div class="media-obj__main media-obj__main--small-spacing">88 GEYLANG BAHRU</div>
                        </div>
                        <div class="media-obj mt-8">
                            <div class="media-obj__asset"><i class="ico ico--small material-icons">event</i></div>
                            <div class="media-obj__main media-obj__main--small-spacing">21 May 2019 - 30 May 2019, 12:00
                                AM to 12:00 AM
                            </div>
                        </div>
                    </div>
                    <div class="mt-16-custom-768-up-0">
                        <button
                            class="hide-tablet-landscape-up button-ctn button--icon button--ghost mr-16 edit-volunteer-button">
                            <i style="font-size: 20px; padding-top: 2px;" class="ico material-icons">edit</i> <span
                            class="button--icon__name">EDIT</span></button>
                        <button
                            class="hide-tablet-landscape-up button-ctn button--icon button--ghost mr-16 duplicate-volunteer-button">
                            <i style="font-size: 20px; padding-top: 2px;" class="ico material-icons">filter_none</i>
                            <span class="button--icon__name">DUPLICATE</span></button>
                        <button
                            class="button-ctn button--min-width hide-tablet-landscape-down mr-16 edit-volunteer-button">
                            EDIT
                        </button>
                        <button
                            class="button-ctn button--ghost button--min-width hide-tablet-landscape-down mr-16 duplicate-volunteer-button">
                            DUPLICATE
                        </button>
                        <select name="volunteer-status" id="volunteer-status-select"
                                class="select-ctn select2-status" data-selected="LIVE"
                                tabindex="-1" aria-hidden="true">
                            <option selected="" value="LIVE">Live</option>
                            <option value="CLOSED">Closed</option>
                            <option value="CANCELLED">Cancelled</option>
                        </select>
                    </div>
                </div>

            </div>

            <!--NAV-->
            <div class="cWidth-1200 company-profile__nav">
                <nav class="hori-scroll-nav">
                    <ul class="hori-scroll-nav__list tabs list">
                        <li><a @click="setRouteTab('signups')"
                               class="text-link text-link--no-underline text-link--black tabs__a"
                               :class="[{' is-active': tab===0}]"
                               id="goToSignUp">Sign ups</a></li>
                        <li><a @click="setRouteTab('attendance')"
                               class="text-link text-link--no-underline text-link--black tabs__a"
                               :class="[{' is-active': tab===1}]"
                               id="goToAttendance">Attendance</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--NAV-->
        </section>

        <!--SignUps-->

        <div v-show="tab===0">
            <div class="ctn">
                <div class="cWidth-1200 pt-40">
                    <div
                        class="flex-ctn flex-ctn--just-spc-btw flex-ctn--tablet-portrait-up-align-center flex-ctn--dir-col-tablet-portrait-up-row">
                        <div class="dbl-stats">
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8"><span class="confirmed-count">1</span></div>
                                <div class="dbl-stats__desc"> are<br>confirmed</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8"><span class="pending-count">0</span>
                                </div>
                                <div class="dbl-stats__desc"> pending<br>confirmation</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8"><span class="opening-count">10</span></div>
                                <div class="dbl-stats__desc"> total<br>openings</div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">

                    <div
                        class="flex-ctn flex-ctn--just-spc-btw flex-ctn--dir-col-rev-tablet-portrait-up-row">
                        <div class="flex-ctn flex-ctn--align-center mt-16-tablet-portrait-up-0 pl-10">
                            <label
                                class="checkbox-list__checkbox hide-tablet-portrait-up mr-16">
                                <input type="checkbox"
                                       value=""
                                       class="signup-record-checkbox">
                                <div
                                    class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey checkbox-list__lbl-spn--small">
                                    Select all
                                </div>

                            </label>
                            <select class="select-ctn select select--small bulk-signup-status-select"
                                    data-role="check-any-to-show-target" data-id="bulk-edit" style="display: none;">
                                <option value="">ACTIONS</option>

                                <option value="CONFIRMED">Confirmed</option>

                                <option value="REJECTED">Rejected</option>

                                <option value="CONFIRM_AND_MAKE_LEADER">Make Leader</option>

                            </select>
                        </div>
                        <div class="flex-ctn flex-ctn--align-center">
                            <div class="select-btn mr-16 flex-grow-1 flex-shrink-1">
                                <label class="mb-0 select-btn__lbl">
                                    <span class="select-btn__lbl-lbl mr-4 font-mid-grey body-txt">Filter By</span>
                                </label>
                                <select name="filterBy" class="select-ctn select-btn__select">
                                    <option value="all">All signups</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="withdrawn">Withdrawn</option>
                                    <option value="leaders-only">Leaders Only</option>
                                </select>
                            </div>
                            <div class="select-btn flex-grow-1 flex-shrink-1">
                                <label class="mb-0 select-btn__lbl">
                                    <span class="select-btn__lbl-lbl mr-4 font-mid-grey body-txt">Sort By</span>
                                </label>
                                <select name="sortBy" class="select-ctn select-btn__select">
                                    <!-- Change Recent Sign Ups to Default  -->
                                    <option
                                        value="recent">Default
                                    </option>
                                    <option
                                        value="name">Name
                                    </option>
                                    <option
                                        value="position">Position
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table class="table-ctn res-tbl mt-16 volunteer-signup-list">
                        <thead>
                        <tr>
                            <th>
                                <label class="checkbox-list__checkbox">
                                    <input type="checkbox" value=""
                                           class="signup-record-checkbox">
                                    <div class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey font-bold">Name
                                        and Role
                                    </div>
                                </label>
                            </th>
                            <th class="nowrap dark-grey">Signed up on</th>
                            <th class="dark-grey">Email</th>
                            <th class="dark-grey">Slots</th>
                            <th class="dark-grey">Other details</th>
                            <th class="dark-grey">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="volunteer-signup-list-item" v-for="i in 3" :key="i"
                            style="display: table-row;">
                            <th class="line-height-20">
                                <div class="media-obj">
                                    <div class="media-obj__asset">
                                        <label class="checkbox-list__checkbox">
                                            <input type="checkbox" value=""
                                                   class="signup-record-checkbox a-signup-record-checkbox">
                                            <div
                                                class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey font-bold"></div>
                                        </label>
                                    </div>
                                    <div class="media-obj__main media-obj__main--no-spacing">
                                        <div class="media-obj">
                                            <div class="media-obj__asset">
                                                <img :src="`${baseUrl}${baseRes}/assets/images/ph-pink.jpg`" alt=""
                                                     class="profile-pic profile-pic--small show-tablet-portrait-up">
                                            </div>
                                            <div
                                                class="media-obj__main media-obj__main--space-tablet-portrait-up line-height-20">
                                                <div class="body-txt volunteer-username dark">Bee Organization</div>
                                                <div class="ribbon ribbon--role leader-indicator">ACTIVITY LEADER</div>
                                                <div class="mt-8 font-normal volunteer-position">Front of House</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <td class="line-height-20"><span class="hide-tablet-portrait-up">Signed up on</span> <span
                                class="">08/05/2019</span>
                                <span class="hide volunteer-signup-date date">1557296695000</span>
                            </td>
                            <td class="line-height-20">beeostin@gmail.com</td>
                            <td class="line-height-20">
                                <div>
                                    <span class="slotValues">1</span>
                                </div>
                            </td>
                            <td class="line-height-20">
                                <div>0309 8483 2</div>
                                <div>
                                    Male
                                </div>
                                <div class="media-obj__asset">
                                    <img src="" alt="" class="profile-pic profile-pic--tiny mr-4">
                                </div>
                            </td>
                            <td class="line-height-20">
                                <select
                                    class="select-ctn select--full select--small confirmed leader">
                                    <option value="REJECTED">
                                        Rejected
                                    </option>
                                    <option selected="" value="CONFIRM_AND_MAKE_LEADER">
                                        Confirmed
                                    </option>
                                </select>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="hide">
                        <p class="font-black bold caps search-result__result">No results found</p>
                    </div>
                    <nav class="flex-ctn mt-40">
                        <ul class="pagi">
                            <li class="pagi__item is-hidden"><a href="#"><span
                                class="ico ico-page-prev"></span></a></li>
                            <li class="pagi__item is-active is-hidden"><a href="#">1</a></li>
                            <li class="pagi__item is-hidden"><a href="#"><span
                                class="ico ico-page-next"></span></a></li>
                        </ul>
                    </nav>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <!--@ENDSignUps-->
        <!--Attendance-->
        <div v-show="tab===1">
            <div class="ctn">
                <div class="cWidth-1200 pt-40">
                    <div
                        class="flex-ctn flex-ctn--just-spc-btw flex-ctn--tablet-portrait-up-align-center flex-ctn--dir-col-tablet-portrait-up-row">
                        <div class="dbl-stats">
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats">
                                    <span class="attendance-count">1</span>/<span
                                    class="totalConfirm-count">1</span></div>
                                <div class="dbl-stats__desc">are here</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats"><span class="leader-attendance-count">1</span>/1</div>
                                <div class="dbl-stats__desc">leaders here</div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">
                    <div class="flex-ctn flex-ctn--just-end flex-ctn--dir-col-rev-tablet-portrait-up-row">
                        <div class="flex-ctn flex-ctn--align-center">
                            <div
                                class="select-btn select-btn--w-auto mr-0-tablet-portrait-up-16 mt-16-tablet-portrait-up-0">
                                <label class="mb-0 select-btn__lbl lbl-with-right-side">
                                    <span class="select-btn__lbl-lbl mr-8 font-mid-grey body-txt">Filter By</span>
                                </label>
                                <select name="filterBy" class="select-ctn select--small select-btn__select">
                                    <option value="all">All</option>
                                    <option value="check-in">Check-in</option>
                                    <option value="not-check-in">Not Check-in</option>
                                </select></div>
                            <div class="text-right flex-grow-1">
                                <label
                                    class="checkbox-list__checkbox hide-tablet-portrait-up mt-16"> <input
                                    class="attendance-record-checkbox" type="checkbox" value="" data-role="check-all"
                                    data-target="check-in">
                                    <div class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey">Check-in all
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="input-ctrl mb-0 w-211 ">
                            <input type="text" class="input-ctn input--h-36 input--icon"
                                   placeholder="Search volunteer name"
                                   name="volunteer-name-filter" data-control-action="filter">
                            <i class="ico material-icons input-ctrl__icon">search</i></div>
                    </div>

                    <table class="table-ctn res-tbl res-tbl--3col mt-16 volunteer-attendance-list">
                        <thead>
                        <tr>
                            <th class="dark-grey">Name and role</th>
                            <th class="dark-grey">Hours per volunteer</th>
                            <th class="dark-grey">Number of attendees</th>
                            <th class="dark-grey"><label class="checkbox-list__checkbox"> <input type="checkbox"
                                                                                                 value="check-in">
                                <div class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey font-bold">Check-in
                                    all
                                </div>
                            </label>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="volunteer-attendance-list-item" style="display: table-row;">
                            <th class="line-height-20">
                                <div class="media-obj">
                                    <div class="media-obj__asset">
                                        <img src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg" alt=""
                                             class="profile-pic profile-pic--small show-tablet-portrait-up">
                                    </div>
                                    <div class="media-obj__main media-obj__main--space-tablet-portrait-up">
                                        <div class="body-txt volunteer-name">Bee Organization</div>
                                        <div class="ribbon ribbon--role">ACTIVIY LEADER</div>
                                        <div class="mt-8 font-normal">11 May 2019, 12:10 PM</div>

                                    </div>
                                </div>
                            </th>
                            <td class="line-height-20">
                                <div class="input-ctrl">
                                    <label for="hours" class="hide-tablet-portrait-up">Hours per volunteer</label>
                                    <div class="num-spnr volunteer-attendance ">
                                            <span class="num-spnr__btn">
                                              <a data-dir="dwn"><span class="ico ico-minus"></span></a>
                                            </span>
                                        <input type="number" data-role="disabled-no-change-target"
                                               class="input-ctn num-spnr__input volunteer-hour" id="hours"
                                               data-previous-hour="24"
                                               value="24" maxlength="10" pattern="[0-9.,]+">
                                        <span class="num-spnr__btn">
                                              <a data-dir="up"><span class="ico ico-plus"></span></a>
                                            </span>
                                    </div>
                                    <label class="error-msg volunteer-hour-error" style="display:none;">Please indicate
                                        the number of hours</label>
                                </div>
                            </td>
                            <td class="line-height-20">
                                <div class="input-ctrl">
                                    <label for="hours" class="hide-tablet-portrait-up">Number of attendees</label>

                                    <div class="num-spnr js-num-spnr volunteer-input-noaction">
                                            <span class="num-spnr__btn">
                                              <a data-dir="dwn"><span class="ico ico-minus"></span></a>
                                            </span>
                                        <input type="number" data-role="disabled-no-change-target"
                                               class="input-ctn num-spnr__input volunteer-slots" id="slots"
                                               data-previous-slots="1" data-max-slots="1" value="1" maxlength="10"
                                               pattern="[0-9]+" disabled="">
                                        <span class="num-spnr__btn">
                                              <a data-dir="up"><span class="ico ico-plus"></span></a>
                                            </span>
                                    </div>
                                    <label class="error-msg volunteer-slots-error" style="display:none;">Please indicate
                                        the number of attendees</label>
                                </div>
                            </td>
                            <td class="line-height-20">
                                <div class="input-ctrl">
                                    <label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="attended volunteer-attend attendance-record-checkbox check-in"
                                               data-role="disabled-no-change-target check-all-target"
                                               checked="">
                                        <span class="checkbox-list__lbl-spn checkbox-list__lbl-spn">Check-in</span>
                                    </label>
                                    <label class="error-msg volunteer-attend-error" style="display:none;">Please
                                        check-in to save the attended hours</label>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="">
                        <p class="font-black bold caps search-result__result">No results found</p>
                    </div>
                    <nav
                        class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative">
                        <ul class="pagi mt-16-tablet-portrait-up-0">
                            <li class="pagi__item is-hidden"><a href="#"><span
                                class="ico ico-page-prev"></span></a></li>
                            <li class="pagi__item is-active is-hidden"><a href="#">1</a></li>
                            <li class="pagi__item is-hidden"><a href="#"><span
                                class="ico ico-page-next"></span></a></li>
                        </ul>
                        <button disabled=""
                                class="save-attendance button-ctn button--min-width position-abs-tablet-portrait-up right0 top5neg">
                            SAVE
                        </button>
                    </nav>
                </div>
            </div>
        </div>
        <!--@Attendance-->

    </main>
</template>

<script>
    import Base from "@com/Bases/OrganizeBase.js";

    export default Base.extend({
        name: "ManageSignUpVolunteers",
        data: () => ({
            tab: 0,
            tabs: {signups: 0, attendance: 1},
        }),
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            }
        },
        methods: {
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                }
            },
            setRouteTab(n) {
                this.Route({name: 'manage-sign-up-volunteers', query: {active_page: n}});
            },
            initSelect2Status() {
                this.jq('#volunteer-status-select').select2(
                    {
                        minimumResultsForSearch: Infinity,
                        templateResult: function formatOptnStatus(b) {
                            return $('<span><span class="mr-8 colored-dot colored-dot--' + b.text.toLowerCase() + '"/>' + b.text + "</span>")
                        },
                        templateSelection: function (b) {
                            return $('<span><span class="mr-8 colored-dot colored-dot--' + b.text.toLowerCase() + '"/>' + b.text + "</span>")
                        }
                    }
                );
            }
        },
        mounted() {
            this.initSelect2Status();
        },
        created() {
            this.setPageTitle(`Manage Sign Up Volunteers`);
            this.setTab();
        }
    })
</script>

<style scoped>

</style>
