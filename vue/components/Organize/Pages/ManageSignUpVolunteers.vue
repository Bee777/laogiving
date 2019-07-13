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

                <h2 class="h3-tablet-landscape-up-h2 mt-24"><span class="mr-8">{{volunteering.name}}</span>
                </h2>


                <div class="flex-ctn flex-ctn--dir-col-custom-768-up-row flex-ctn--just-spc-btw mt-8">
                    <div>
                        <div class="media-obj">
                            <div class="media-obj__asset"><i class="ico ico--small material-icons">place</i></div>
                            <div class="media-obj__main media-obj__main--small-spacing">{{volunteering.town}}
                                {{volunteering.block_street}}
                            </div>
                        </div>
                        <div class="media-obj mt-8">
                            <div class="media-obj__asset"><i class="ico ico--small material-icons">event</i></div>
                            <div class="media-obj__main media-obj__main--small-spacing">
                                {{volunteering.start_date_formatted_number}} -
                                {{volunteering.end_date_formatted_number}}, {{ getFrequency()[volunteering.frequency]}}
                                on {{ getDaysOfWeek(volunteering.days_of_week || [])}}
                            </div>
                        </div>
                    </div>
                    <div class="mt-16-custom-768-up-0">
                        <button
                            @click="Route({name: 'create-activity',  query: {active_page: 'general-info-&-permissions', volunteering_id: volunteering.id}})"
                            class="hide-tablet-landscape-up button-ctn button--icon button--ghost mr-16 edit-volunteer-button">
                            <i style="font-size: 20px; padding-top: 2px;" class="ico material-icons">edit</i> <span
                            class="button--icon__name">EDIT</span></button>
                        <button
                            @click="duplicateData(volunteering)"
                            class="hide-tablet-landscape-up button-ctn button--icon button--ghost mr-16 duplicate-volunteer-button">
                            <i style="font-size: 20px; padding-top: 2px;" class="ico material-icons">filter_none</i>
                            <span class="button--icon__name">DUPLICATE</span></button>
                        <button
                            @click="Route({name: 'create-activity',  query: {active_page: 'general-info-&-permissions', volunteering_id: volunteering.id}})"
                            class="button-ctn button--min-width hide-tablet-landscape-down mr-16 edit-volunteer-button">
                            EDIT
                        </button>
                        <button
                            @click="duplicateData(volunteering)"
                            class="button-ctn button--ghost button--min-width hide-tablet-landscape-down mr-16 duplicate-volunteer-button">
                            DUPLICATE
                        </button>
                        <select name="volunteer-status" id="volunteer-status-select"
                                class="select-ctn select2-status" data-selected="LIVE"
                                tabindex="-1" aria-hidden="true"
                                :disabled="volunteering.status!=='live'">
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
                                <div class="dbl-stats__stats mb-8"><span class="confirmed-count">{{getVolunteersStatus(volunteering).confirm}}</span>
                                </div>
                                <div class="dbl-stats__desc"> are<br>confirmed</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8"><span class="pending-count">{{getVolunteersStatus(volunteering).pending}}</span>
                                </div>
                                <div class="dbl-stats__desc"> pending<br>confirmation</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats mb-8"><span class="opening-count">{{getTotalVacancies(volunteering)}}</span>
                                </div>
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
                                <input v-model="selectAll" type="checkbox"
                                       class="signup-record-checkbox">
                                <div
                                    class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey checkbox-list__lbl-spn--small">
                                    Select all
                                </div>

                            </label>
                            <select v-show="selectAll" class="select-ctn select select--small bulk-signup-status-select"
                                    data-role="check-any-to-show-target" data-id="bulk-edit">
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
                                <select v-model="filterBy" name="filterBy" class="select-ctn select-btn__select">
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
                                <select v-model="sortBy" name="sortBy" class="select-ctn select-btn__select">
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
                    <!--Volunteer-signup-list-->
                    <table class="table-ctn res-tbl mt-16 volunteer-signup-list">
                        <thead>
                        <tr>
                            <th>
                                <label class="checkbox-list__checkbox">
                                    <input @change="selectAllRows()" v-model="selectAll" type="checkbox"
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

                        <tr class="volunteer-signup-list-item" v-for="(item, idx) in sign_ups" :key="idx"
                            style="display: table-row;">
                            <th class="line-height-20">
                                <div class="media-obj">
                                    <div class="media-obj__asset">
                                        <label class="checkbox-list__checkbox">
                                            <input v-model="item.checked" type="checkbox" value=""
                                                   class="signup-record-checkbox a-signup-record-checkbox">
                                            <div
                                                class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey font-bold"></div>
                                        </label>
                                    </div>
                                    <div class="media-obj__main media-obj__main--no-spacing">
                                        <div class="media-obj">
                                            <div class="media-obj__asset">
                                                <img
                                                    :src="`${baseUrl}/assets/images/user_profiles/96x96-${item.user.image}`"
                                                    alt=""
                                                    class="profile-pic profile-pic--small show-tablet-portrait-up">
                                            </div>
                                            <div
                                                class="media-obj__main media-obj__main--space-tablet-portrait-up line-height-20">
                                                <div class="body-txt volunteer-username dark">{{item.user.name}}</div>
                                                <div v-if="item.leader==='yes'"
                                                     class="ribbon ribbon--role leader-indicator">ACTIVITY LEADER
                                                </div>
                                                <div class="mt-8 font-normal volunteer-position">
                                                    {{getVolunteeringSelectedPosition(item.volunteering_activity_position_id,
                                                    volunteering).position_title}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <td class="line-height-20"><span class="hide-tablet-portrait-up">Signed up on</span> <span
                                class="">{{getSignUpDate(item)}}</span>
                                <span class="hide volunteer-signup-date date">{{item.sign_up_date}}</span>
                            </td>
                            <td class="line-height-20">{{item.user.email}}</td>
                            <td class="line-height-20">
                                <div>
                                    <span class="slotValues">{{item.slot}}</span>
                                </div>
                            </td>
                            <td class="line-height-20">
                                <div v-if="!$utils.isEmptyVar(item.volunteer_contact_phone_number)">
                                    {{item.volunteer_contact_phone_number}}
                                </div>
                                <div v-if="!$utils.isEmptyVar(volunteering.volunteer_gender)">
                                    {{$utils.firstUpper(item.user.gender || '')}}
                                </div>
                                <div class="media-obj__asset">
                                    <img src="" alt="" class="profile-pic profile-pic--tiny mr-4">
                                </div>
                            </td>
                            <td class="line-height-20">
                                <select
                                    v-model="item.status"
                                    class="select-ctn select--full select--small confirmed leader">
                                    <option value="confirm">
                                        Confirmed
                                    </option>
                                    <option value="rejected">
                                        Rejected
                                    </option>
                                    <option value="CONFIRM_AND_MAKE_LEADER">
                                        Make Leader
                                    </option>
                                </select>

                                <div v-if="!$utils.isEmptyVar(item.other_response_required)" class="mt-8">
                                    <div v-show="item.show_other_response"
                                         class="body-txt font-dark-grey is-visible pre-wrap break-word">
                                        {{item.other_response_required}}
                                    </div>
                                    <a v-show="item.show_other_response" @click="item.show_other_response=false"
                                       class="text-link font-bold show-hide-txt__hide">Hide response</a>
                                    <a v-show="!item.show_other_response" @click="item.show_other_response=true"
                                       class="text-link font-bold show-hide-txt__show is-hidden">Show response</a>
                                </div>

                            </td>
                        </tr>

                        <!--<tr class="volunteer-signup-list-item" v-for="i in 1" :key="`${i}-temp`"-->
                        <!--style="display: table-row;">-->
                        <!--<th class="line-height-20">-->
                        <!--<div class="media-obj">-->
                        <!--<div class="media-obj__asset">-->
                        <!--<label class="checkbox-list__checkbox">-->
                        <!--<input type="checkbox" value=""-->
                        <!--class="signup-record-checkbox a-signup-record-checkbox">-->
                        <!--<div-->
                        <!--class="checkbox-list__lbl-spn checkbox-list__lbl-spn&#45;&#45;dark-grey font-bold"></div>-->
                        <!--</label>-->
                        <!--</div>-->
                        <!--<div class="media-obj__main media-obj__main&#45;&#45;no-spacing">-->
                        <!--<div class="media-obj">-->
                        <!--<div class="media-obj__asset">-->
                        <!--<img :src="`${baseUrl}${baseRes}/assets/images/ph-pink.jpg`" alt=""-->
                        <!--class="profile-pic profile-pic&#45;&#45;small show-tablet-portrait-up">-->
                        <!--</div>-->
                        <!--<div-->
                        <!--class="media-obj__main media-obj__main&#45;&#45;space-tablet-portrait-up line-height-20">-->
                        <!--<div class="body-txt volunteer-username dark">Bee Organization</div>-->
                        <!--<div class="ribbon ribbon&#45;&#45;role leader-indicator">ACTIVITY LEADER</div>-->
                        <!--<div class="mt-8 font-normal volunteer-position">Front of House</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <!--</th>-->
                        <!--<td class="line-height-20"><span class="hide-tablet-portrait-up">Signed up on</span> <span-->
                        <!--class="">08/05/2019</span>-->
                        <!--<span class="hide volunteer-signup-date date">1557296695000</span>-->
                        <!--</td>-->
                        <!--<td class="line-height-20">beeostin@gmail.com</td>-->
                        <!--<td class="line-height-20">-->
                        <!--<div>-->
                        <!--<span class="slotValues">1</span>-->
                        <!--</div>-->
                        <!--</td>-->
                        <!--<td class="line-height-20">-->
                        <!--<div>0309 8483 2</div>-->
                        <!--<div>-->
                        <!--Male-->
                        <!--</div>-->
                        <!--<div class="media-obj__asset">-->
                        <!--<img src="" alt="" class="profile-pic profile-pic&#45;&#45;tiny mr-4">-->
                        <!--</div>-->
                        <!--</td>-->
                        <!--<td class="line-height-20">-->
                        <!--<select-->
                        <!--class="select-ctn select&#45;&#45;full select&#45;&#45;small confirmed leader">-->
                        <!--<option value="REJECTED">-->
                        <!--Rejected-->
                        <!--</option>-->
                        <!--<option selected="" value="CONFIRM_AND_MAKE_LEADER">-->
                        <!--Confirmed-->
                        <!--</option>-->
                        <!--</select>-->

                        <!--</td>-->
                        <!--</tr>-->
                        </tbody>
                    </table>
                    <!--Volunteer-signup-list-->
                    <div v-show="!validated().loading_volunteering_searches && sign_ups.length <= 0">
                        <p class="font-black bold caps search-result__result">No results found</p>
                    </div>
                    <nav v-show="!validated().loading_volunteering_searches && sign_ups.length > 0"
                         class="flex-ctn mt-40">
                        <ul class="pagi">
                            <li class="pagi__item"><a class="cursor"
                                                      :disabled="paginate.current_page===1"
                                                      @click="prevPage(paginate.current_page - 1)"
                            ><span
                                class="ico ico-page-prev"></span></a></li>
                            <li :key="idx" v-for="(p, idx) in paginate.last_page"
                                :class="[{'is-active': p===paginate.current_page}]"
                                class="pagi__item "><a
                                href="" @click.prevent="paginateNavigator({pageNo: p})">{{p}}</a></li>
                            <li class="pagi__item "><a class="cursor"
                                                       :disabled="paginate.current_page===paginate.last_page"
                                                       @click="nextPage(paginate.current_page + 1)"><span
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
                                    <span
                                        class="attendance-count">{{getVolunteersStatus(volunteering).confirm_checkin}}</span>/<span
                                    class="totalConfirm-count">{{getVolunteersStatus(volunteering).confirm}}</span>
                                </div>
                                <div class="dbl-stats__desc">are here</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats"><span class="leader-attendance-count">{{getVolunteersStatus(volunteering).leader_checkin}}</span>/{{getVolunteersStatus(volunteering).leader}}
                                </div>
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
                                <select v-model="filterBy" name="filterBy"
                                        class="select-ctn select--small select-btn__select">
                                    <option value="all">All</option>
                                    <option value="check-in">Check-in</option>
                                    <option value="not-check-in">Not Check-in</option>
                                </select></div>
                            <div class="text-right flex-grow-1">
                                <label
                                    class="checkbox-list__checkbox hide-tablet-portrait-up mt-16">
                                    <input @change="selectAllRows()" v-model="checkInAll"
                                           class="attendance-record-checkbox" type="checkbox" data-role="check-all"
                                           data-target="check-in">
                                    <div class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey">Check-in all
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="input-ctrl mb-0 w-211 ">
                            <input v-model="searchName" type="text" class="input-ctn input--h-36 input--icon"
                                   placeholder="Search volunteer name"
                                   name="volunteer-name-filter" data-control-action="filter">
                            <i class="ico material-icons input-ctrl__icon">search</i></div>
                    </div>
                    <!-- Volunteer-attendance-list -->
                    <table class="table-ctn res-tbl res-tbl--3col mt-16 volunteer-attendance-list">
                        <thead>
                        <tr>
                            <th class="dark-grey">Name and role</th>
                            <th class="dark-grey">Hours per volunteer</th>
                            <th class="dark-grey">Number of attendees</th>
                            <th class="dark-grey"><label class="checkbox-list__checkbox">
                                <input
                                    @change="selectAllRows()" v-model="checkInAll"
                                    type="checkbox"
                                    value="check-in">
                                <div class="checkbox-list__lbl-spn checkbox-list__lbl-spn--dark-grey font-bold">Check-in
                                    all
                                </div>
                            </label>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, idx) in attendance" :key="idx" class="volunteer-attendance-list-item"
                            style="display: table-row;">
                            <th class="line-height-20">
                                <div class="media-obj">
                                    <div class="media-obj__asset">
                                        <img :src="`${baseUrl}/assets/images/user_profiles/96x96-${item.user.image}`"
                                             alt=""
                                             class="profile-pic profile-pic--small show-tablet-portrait-up">
                                    </div>
                                    <div class="media-obj__main media-obj__main--space-tablet-portrait-up">
                                        <div class="body-txt volunteer-name">{{item.user.name}}</div>
                                        <div v-if="item.leader==='yes'" class="ribbon ribbon--role">ACTIVITY LEADER
                                        </div>
                                        <div v-if="!$utils.isEmptyVar(item.checkin_date)" class="mt-8 font-normal">
                                            {{getCheckinDate(item)}}
                                        </div>

                                    </div>
                                </div>
                            </th>
                            <td class="line-height-20">
                                <div class="input-ctrl">
                                    <label for="hours" class="hide-tablet-portrait-up">Hours per volunteer</label>
                                    <div class="num-spnr volunteer-attendance ">
                                            <span class="num-spnr__btn">
                                              <a @click="reduceNumber(item)" data-dir="dwn"><span
                                                  class="ico ico-minus"></span></a>
                                            </span>
                                        <input v-model="item.hour_per_volunteer" type="number"
                                               @input="setNumber(item, item.hour_per_volunteer)"
                                               data-role="disabled-no-change-target"
                                               class="input-ctn num-spnr__input volunteer-hour" id="hours"
                                               data-previous-hour="24"
                                               value="24" maxlength="10" pattern="[0-9.,]+">
                                        <span class="num-spnr__btn">
                                              <a @click="addNumber(item)" data-dir="up"><span
                                                  class="ico ico-plus"></span></a>
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
                                              <a style="cursor: not-allowed" data-dir="dwn"><span
                                                  class="ico ico-minus"></span></a>
                                            </span>
                                        <input style="background-color: #eee;" type="number"
                                               data-role="disabled-no-change-target"
                                               class="input-ctn num-spnr__input volunteer-slots" id="slots"
                                               data-previous-slots="1" data-max-slots="1" value="1" maxlength="10"
                                               pattern="[0-9]+" disabled="">
                                        <span class="num-spnr__btn">
                                              <a style="cursor: not-allowed" data-dir="up"><span
                                                  class="ico ico-plus"></span></a>
                                            </span>
                                    </div>
                                    <label class="error-msg volunteer-slots-error" style="display:none;">Please indicate
                                        the number of attendees</label>
                                </div>
                            </td>
                            <td class="line-height-20">
                                <div class="input-ctrl">
                                    <label class="checkbox-list__checkbox">
                                        <input
                                            v-model="item.checked"
                                            type="checkbox"
                                            class="attended volunteer-attend attendance-record-checkbox check-in"
                                            data-role="disabled-no-change-target check-all-target">
                                        <span class="checkbox-list__lbl-spn checkbox-list__lbl-spn">Check-in</span>
                                    </label>
                                    <label class="error-msg volunteer-attend-error" style="display:none;">Please
                                        check-in to save the attended hours</label>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <!-- Volunteer-attendance-list -->
                    <div v-show="!validated().loading_volunteering_searches && attendance.length <= 0">
                        <p class="font-black bold caps search-result__result">No results found</p>
                    </div>
                    <nav
                        v-show="!validated().loading_volunteering_searches && attendance.length > 0"
                        class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative">
                        <ul class="pagi mt-16-tablet-portrait-up-0">
                            <li class="pagi__item"><a class="cursor" :disabled="paginate.current_page===1"
                                                      @click="prevPage(paginate.current_page - 1)"><span
                                class="ico ico-page-prev"></span></a></li>
                            <li :key="idx" v-for="(p, idx) in paginate.last_page"
                                :class="[{'is-active': p===paginate.current_page}]"
                                class="pagi__item"><a href="" @click.prevent="paginateNavigator({pageNo: p})">{{p}}</a>
                            </li>
                            <li class="pagi__item"><a class="cursor"
                                                      :disabled="paginate.current_page===paginate.last_page"
                                                      @click="nextPage(paginate.current_page + 1)"><span
                                class="ico ico-page-next"></span></a></li>
                        </ul>
                        <button :disabled="!isHoursVolunteeringChanged"
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
    import {mapActions, mapState, mapMutations} from 'vuex'

    export default Base.extend({
        name: "ManageSignUpVolunteers",
        data: () => ({
            tab: 0,
            tabs: {signups: 0, attendance: 1},
            volunteering: {},
            isOwnerSelectChanged: true,
            volunteering_status: null,
            selectStatus: null,
            selectAll: false,
            checkInAll: false,
            searchName: '',
            filterBy: 'all',
            sortBy: 'recent',
            changedHours: [],
        }),
        watch: {
            '$route.query': function (n, o) {
                this.setTab();
            }
        },
        computed: {
            isHoursVolunteeringChanged: function () {
                let changed;
                changed = this.changedHours.filter(f => {
                    return f.old_value !== f.value;
                });
                let checked = this.attendance.filter(f => {
                    return f.checked
                });
                return (changed.length > 0 && this.changedHours.length > 0) || checked.length > 0;
            },
            sign_ups: function () {
                let data = this.paginate.data || [];
                //sort
                let sort = this.sortBy;
                if (sort === 'name') {
                    data.sort((a, b) => {
                        return a.user.name.localeCompare(b.user.name);
                    });
                } else if (sort === 'position') {
                    data.sort((a, b) => {
                        return b.leader.localeCompare(a.leader);
                    });

                } else {
                    data.sort((a, b) => {
                        return b.id - a.id;
                    });
                }
                //sort
                //filters
                let filters = {
                    all: '',
                    pending: 'pending',
                    confirmed: 'confirm',
                    rejected: 'rejected',
                    withdrawn: 'withdrawn',
                    'leaders-only': 'leaders',
                };
                data = data.filter(filter => {
                    if (filters[this.filterBy] === '') {
                        return filter;
                    }
                    if (filters[this.filterBy] !== 'leaders') {
                        return filter.status === filters[this.filterBy];
                    }
                    return filter.leader === 'yes';
                });

                //filters
                return data;
            },
            attendance: function () {
                let data = this.paginate.data || [];
                let filters = {
                    all: '',
                    'check-in': 'checkin',
                    'not-check-in': 'confirm'
                };
                data = data.filter(filter => {
                    if (filters[this.filterBy] === '') {
                        return filter;
                    }
                    return filter.status === filters[this.filterBy];
                });

                data = data.filter(filter => {
                    if (this.searchName !== '') {
                        return filter.user.name.indexOf(this.searchName) !== -1;
                    }
                    return filter;
                });

                return data;
            }
        },
        methods: {
            ...mapActions(['manageVolunteeringActivityData', 'manageVolunteeringActivityStatusData']),
            ...mapMutations(['setVolunteeringDuplicateData']),
            setTab() {
                let tab = this.$route.query.active_page;
                if (tab && typeof this.tabs[tab] !== "undefined") {
                    this.tab = this.tabs[tab];
                }
                this.getManageVolunteering();
            },
            setRouteTab(n) {
                this.Route({
                    name: 'manage-sign-up-volunteers',
                    query: {active_page: n, volunteering_id: this.singleId}
                });
            },
            initSelect2Status(val = '') {
                let self = this;
                this.selectStatus = this.jq('#volunteer-status-select');
                if (this.selectStatus.data('select2')) {
                    this.selectStatus.data('select2').destroy();
                }
                this.selectStatus.select2(
                    {
                        minimumResultsForSearch: Infinity,
                        templateResult: function formatOptnStatus(b) {
                            return $('<span><span class="mr-8 colored-dot colored-dot--' + b.text.toLowerCase() + '"/>' + b.text + "</span>")
                        },
                        templateSelection: function (b) {
                            return $('<span><span class="mr-8 colored-dot colored-dot--' + b.text.toLowerCase() + '"/>' + b.text + "</span>")
                        }
                    }
                ).on('change', function () {
                    if (!self.isOwnerSelectChanged) {
                        let ans = confirm('Are you sure you want to change the volunteering status?');
                        if (ans) {
                            self.volunteering_status = $(this).val();
                            self.changeVolunteeringStatus();
                        } else {
                            self.isOwnerSelectChanged = true;
                            $(this).val('LIVE').trigger('change');
                            return;
                        }
                    }
                    self.isOwnerSelectChanged = false;
                });
                this.selectStatus.val(val).trigger('change');
            },
            changeVolunteeringStatus() {
                this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                let statuses = {
                    'LIVE': 'live',
                    'CLOSED': 'close',
                    'CANCELLED': 'cancel',
                };
                this.manageVolunteeringActivityStatusData({
                    id: this.singleId,
                    data: {status: statuses[this.volunteering_status]}
                }).then(res => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                    if (res.success) {
                        this.volunteering.status = this.volunteering_status;
                    } else {
                        this.$nextTick(() => {
                            if (this.selectStatus) {
                                this.isOwnerSelectChanged = true;
                                this.selectStatus.val('LIVE').trigger('change');
                            }
                        });
                    }
                }).catch(err => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                });
            },
            getManageVolunteering() {
                this.filterBy = 'all';
                this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                this.manageVolunteeringActivityData({
                    id: this.singleId, tab: this.tab,
                    filters: this.filters,
                    q: this.searchName,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                }).then(res => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                    if (!res.success) {
                        this.Route({name: 'home', query: {'active_page': 'our-volunteering'}});
                    } else {
                        let data = res.data;
                        this.volunteering = data.volunteering;
                        this.setPaginateData(data);
                        this.volunteering_status = data.volunteering.status.toUpperCase();
                        this.$nextTick(() => {
                            if (!this.selectStatus) {
                                this.initSelect2Status(this.volunteering_status);
                            }
                        });
                        this.selectAllRows();
                    }
                }).catch(err => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                });
            },
            duplicateData(data) {
                let duplicateData = JSON.parse(JSON.stringify(data));
                //reset data
                duplicateData.frequency = '';
                duplicateData.duration = '';
                duplicateData.days_of_week = [];
                duplicateData.start_date = '';
                duplicateData.end_date = '';
                duplicateData.deadline_sign_ups_date = '';
                //reset data
                this.setVolunteeringDuplicateData(duplicateData);
                this.Route({
                        name: 'create-activity',
                        query: {
                            active_page: 'general-info-&-permissions',
                            volunteering_id: duplicateData.id,
                            duplicate_id: duplicateData.id
                        }
                    }, 300
                );
            },
            getSignUpDate(item) {
                //08/05/2019
                let date = this.$utils.getDateTime(item.sign_up_date);
                return `${date.days}/${date.months_number}/${date.years}`;
            },
            getCheckinDate(item) {
                //11 May 2019, 12:10 PM
                let date = this.$utils.getDateTime(item.checkin_date);
                return `${date.days} ${date.months} ${date.years}, ${date.ampm}`;

            },
            selectAllRows() {
                if (this.tab === 0) {
                    (this.sign_ups || []).map((user) => {
                        user.checked = this.selectAll;
                    })
                } else {
                    (this.attendance || []).map((user) => {
                        user.checked = this.checkInAll;
                    })
                }
            },
            setChangedHours(item) {
                let exists = this.changedHours.filter((f) => {
                    return f.id === item.id;
                }).shift() || {};
                if (this.$utils.isEmptyObject(exists)) {
                    this.changedHours.push({id: item.id, value: item.hour_per_volunteer, old_value: item.hours});
                } else {
                    this.changedHours.map((f) => {
                        if (f.id === item.id) {
                            f.value = item.hour_per_volunteer;
                        }
                        return f;
                    })
                }
            },
            setNumber(item) {
                item.hour_per_volunteer = parseInt(item.hour_per_volunteer);
                this.setChangedHours(item);
            },
            reduceNumber(item) {
                if (item.hour_per_volunteer > 1000000) {
                    item.hour_per_volunteer = 1000000;
                }
                if (item.hour_per_volunteer > 0) {
                    item.hour_per_volunteer -= 0.5;
                } else {
                    item.hour_per_volunteer = 0;
                }
                this.setChangedHours(item);
            },
            addNumber(item) {
                if (item.hour_per_volunteer < 0) {
                    item.hour_per_volunteer = 0;
                }
                if (item.hour_per_volunteer < 1000000)
                    item.hour_per_volunteer += 0.5;

                this.setChangedHours(item);
            },
            setPaginateData(data) {
                if (this.tab === 0) {
                    this.paginate = data.volunteering_sign_ups;
                } else {
                    this.paginate = data.volunteering_attendance;
                }
            },
            getVolunteering(t = '') {
                if (!this.isTyped && t === 'click') {//check if user never type in search box but got click search button
                    return;
                }
                if (!this.isNavigator) {
                    this.paginate.current_page = 1;
                }
                this.isSearch = false;//set user searching to false
                //reset scroll bar position
                this.$utils.animateScrollToY('html,body', 10);
                this.Event.fire('preload', this.Event.loadingState().NotActiveLoading);
                this.manageVolunteeringActivityData({
                    id: this.singleId, tab: this.tab,
                    filters: this.filters,
                    q: this.searchName,
                    limit: this.paginate.per_page, page: this.paginate.current_page
                }).then(res => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                    if (!res.success) {
                        this.Route({name: 'home', query: {'active_page': 'our-volunteering'}});
                    } else {
                        let data = res.data;
                        this.volunteering = data.volunteering;
                        this.setPaginateData(data);
                        this.volunteering_status = data.volunteering.status.toUpperCase();
                    }
                }).catch(err => {
                    this.Event.fire('preload', this.Event.loadingState().ActiveNotLoading);
                });
            },
            paginateNavigator(p) {
                this.isNavigator = true; //set to true to tell the request this is navigator action
                this.paginate.current_page = p.pageNo; //set current page next or prev page for pagination
                this.getVolunteering();
            },
            prevPage(pageNo) {
                if (this.paginate.current_page === 1) return;
                if (pageNo < 1) pageNo = 1;
                if (this.paginate.current_page === pageNo) return;
                this.paginateNavigator({pageNo, dr: 'prev'});
            },
            nextPage(pageNo) {
                if (this.paginate.current_page === this.paginate.last_page) return;
                if (pageNo > this.paginate.lastPage) pageNo = this.paginate.lastPage;
                if (this.paginate.current_page === pageNo) return;
                this.paginateNavigator({pageNo, dr: 'next'});
            },
        },
        mounted() {
        },
        created() {
            this.setPageTitle(`Manage Sign Up Volunteers`);
            this.singleId = this.$route.query.volunteering_id;
            this.setTab();
            this.getManageVolunteering = this.debounce(this.getManageVolunteering, 150);
            this.getVolunteering = this.debounce(this.getVolunteering, 150);
        }
    })
</script>

<style scoped>

</style>
