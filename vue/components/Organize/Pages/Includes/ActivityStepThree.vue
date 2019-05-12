<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form class="form" id="volunteer-step-3">
            <div class="bulk-booking mb-24">
                <h3 class="h3 font-dark-grey">Enable Organisation or Groups to sign up for
                    this activity?</h3> <label
                class="ios-switch mt-16">
                <input type="checkbox"
                       id="bulk_booking"
                       name="bulk_booking"
                       class="ios-switch__checkbox"> <span
                class="ios-switch__off">No</span>
                <div class="ios-switch__base"></div>
                <span class="ios-switch__on">Yes</span> </label>
                <hr class="hr">
            </div>
            <h3 class="h3 font-dark-grey">Volunteer positions</h3>
            <span class="body-txt body-txt--small">You can only create one volunteer position</span>

            <div class="mt-24 position-fields-wrapper">
                <div
                    class="activity-position volunteer-role-accordion-card accordion-card accordion-card--fill-head accordion-card--always-collapsible create-volunteer-act__accordian mb-16">
                    <div class="accordion-card__head">
                        <h5 class="h5 font-dark-grey">VOLUNTEER POSITION</h5>
                        <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                        <div class="accordion-card__hitarea"></div>
                    </div>

                    <!--POSITION BODY-->
                    <div class="accordion-card__body mt-16">
                        <div class="input-ctrl success">
                            <label class="lbl">Position title</label>
                            <input
                                id="position_name"
                                name="position_name" type="text"
                                class="input-ctn position-name" placeholder="e.g. Befriender">
                            <label for="position_name" class="error-msg"
                                   style="display: block;"></label>
                        </div>
                        <div class="ctn clearfix">
                            <div class="input-ctrl grid-12 grid-tablet-portrait-up-6 mt-16 success" id="vacancies">
                                <label class="lbl" for="vacancies">Vacancies</label>
                                <input
                                    id="position_vacancies"
                                    name="position_vacancies"
                                    type="text" class="input-ctn position-vacancy "
                                    placeholder="Enter number">
                                <label for="position_vacancies"
                                       class="error-msg" style="display: block;"></label>
                            </div>
                            <div class="input-ctrl grid-12 grid-tablet-portrait-up-6-last mt-16 success"
                                 data-id="min-age">
                                <label class="lbl">Minimum age (Optional)</label>
                                <input id="position_minimumAge"
                                       name="position_minimumAge"
                                       type="number" class="input-ctn position-minimum-age " placeholder="Enter number">
                                <label for="position_minimumAge"
                                       class="error-msg" style="display: block;"></label>
                            </div>
                        </div>
                        <div class="input-ctrl mt-16">
                            <label class="lbl">Skills</label>
                            <div class="ctn gallery gallery-tablet-portrait-up-6 clearfix">
                                <ul class="gallery__item checkbox-list">
                                    <li>
                                        <label class="checkbox-list__checkbox">
                                            <input type="checkbox" class="skill-checkbox position-skill"
                                                   name="position_skills"
                                                   value="33399">
                                            <div class="checkbox-list__lbl-spn">
                                                Accounting &amp; Finance
                                            </div>
                                        </label>
                                    </li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33400">
                                        <div class="checkbox-list__lbl-spn">Arts &amp;
                                            Music
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33401">
                                        <div class="checkbox-list__lbl-spn">Business
                                            Development
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33402">
                                        <div class="checkbox-list__lbl-spn">
                                            Coaching &amp; Training
                                        </div>
                                    </label></li>
                                    <li>
                                        <label
                                            class="checkbox-list__checkbox">
                                            <input type="checkbox" class="skill-checkbox position-skill"
                                                   name="position_skills"
                                                   value="33403">
                                            <div class="checkbox-list__lbl-spn">Counselling &amp; Mentoring
                                            </div>
                                        </label></li>
                                    <li><label
                                        class="checkbox-list__checkbox">
                                        <input type="checkbox" class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33404">
                                        <div class="checkbox-list__lbl-spn">Fundraising
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33405">
                                        <div class="checkbox-list__lbl-spn">Human
                                            Resource
                                        </div>
                                    </label></li>
                                </ul>
                                <ul class="gallery__item checkbox-list">
                                    <li><label
                                        class="checkbox-list__checkbox">
                                        <input type="checkbox" class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33406">
                                        <div class="checkbox-list__lbl-spn">Information Technology
                                        </div>
                                    </label></li>
                                    <li><label
                                        class="checkbox-list__checkbox">
                                        <input type="checkbox" class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33407">
                                        <div class="checkbox-list__lbl-spn">Leadership Development
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33408">
                                        <div class="checkbox-list__lbl-spn">Legal</div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33409">
                                        <div class="checkbox-list__lbl-spn">Marketing &amp;
                                            Communications
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33410">
                                        <div class="checkbox-list__lbl-spn">Medical
                                            &amp; Health
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="33411">
                                        <div class="checkbox-list__lbl-spn">
                                            Volunteer Management
                                        </div>
                                    </label></li>
                                    <li><label
                                        class="checkbox-list__checkbox">
                                        <input type="checkbox" class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="1678046">
                                        <div class="checkbox-list__lbl-spn">Other Skills
                                        </div>
                                    </label></li>
                                    <li><label class="checkbox-list__checkbox">
                                        <input type="checkbox"
                                               class="skill-checkbox position-skill"
                                               name="position_skills"
                                               value="1678047">
                                        <div class="checkbox-list__lbl-spn">
                                            No Specific Skills Required
                                        </div>
                                    </label></li>
                                </ul>
                            </div>
                            <div class="controls"><label class="error-msg" id="skill-error" style="display: none">Please
                                select at least
                                one skill</label></div>
                        </div>
                        <div class="input-ctrl mt-16 clearfix">
                            <label class="lbl">Suitable for</label>
                            <ul class="checkbox-list mt-16">
                                <li><label class="checkbox-list__checkbox">
                                    <input class="position-suitability"
                                           data-info="First Timers"
                                           name="position_suitabilities"
                                           id="position_suitabilities_1638419"
                                           type="checkbox" value="1638419">
                                    <div class="checkbox-list__lbl-spn">First Timers</div>
                                </label></li>
                                <li id="yui_patched_v3_11_0_1_1557583322558_1863">
                                    <label class="checkbox-list__checkbox">
                                        <input class="position-suitability"
                                               name="position_suitabilities"
                                               type="checkbox" value="1638420">
                                        <div class="checkbox-list__lbl-spn">
                                            Seniors
                                        </div>
                                    </label></li>
                                <li>
                                    <label class="checkbox-list__checkbox">
                                        <input class="position-suitability" data-info="Open to All"
                                               name="position_suitabilities"
                                               type="checkbox" value="1638421">
                                        <div class="checkbox-list__lbl-spn">
                                            Open to All
                                        </div>
                                    </label></li>
                                <li><label class="checkbox-list__checkbox">
                                    <input class="position-suitability"
                                           name="position_suitabilities"
                                           type="checkbox" value="1638422">
                                    <div class="checkbox-list__lbl-spn">
                                        Family Friendly
                                    </div>
                                </label></li>
                                <li><label class="checkbox-list__checkbox">
                                    <input class="position-suitability"
                                           name="position_suitabilities"
                                           type="checkbox" value="1638423">
                                    <div class="checkbox-list__lbl-spn">Organisation or Groups</div>
                                </label></li>
                            </ul>
                            <label class="error-msg" id="suitabilities-error" style="display: none">Please select at
                                least one
                                category</label></div>
                        <div class="input-ctrl mt-16 success"><label class="lbl">Key
                            responsibilities and impact</label>
                            <textarea maxlength="500"
                                      placeholder="Let your volunteers-to-be know what they will be doing and the impact they are making. Some tips and advice specific to the position will be useful"
                                      name="responsibilitiesAndImpact"
                                      id="responsibilitiesAndImpact"
                                      class="textarea-ctn position-responsibility"
                                      rows="10"></textarea> <label
                                for="responsibilitiesAndImpact"
                                class="error-msg" style="display: block;"></label></div>
                    </div>
                    <!--POSITION BODY-->

                </div>
            </div>

            <hr class="hr">
            <div class="input-ctrl mt-16 success">
                <label class="lbl">
                    <h3 class="h3 font-dark-grey">Additional points to note (optional)</h3>
                </label>
                <textarea
                    id="volunteer_pointersNote"
                    placeholder="General information for all positions" class="textarea-ctn valid"
                    name="volunteer_pointersNote" rows="5"></textarea>
                <label
                    for="volunteer_pointersNote" class="error-msg"
                    style="display: block;"></label>
            </div>

            <hr class="hr">

            <h3 class="h3 font-dark-grey">Required information from volunteers (Optional)</h3>
            <div class="body-txt body-txt--small">Select all that you require</div>

            <ul class="checkbox-list mt-16">
                <li><label class="checkbox-list__checkbox"
                           for="activity-age">
                    <input name="volunteer_requireContactNumber"
                           type="checkbox" value="true" id="activity-age">
                    <div class="checkbox-list__lbl-spn">Contact Number
                    </div>
                </label></li>
                <li><label class="checkbox-list__checkbox"
                           for="activity-gender">
                    <input name="volunteer_requireGender" type="checkbox"
                           value="true" id="activity-gender">
                    <div class="checkbox-list__lbl-spn">Gender</div>
                </label></li>
            </ul>

            <hr class="hr">

            <h3 class="h3 font-dark-grey">
                <label class="lbl"><h3
                    class="h3 font-dark-grey">Other response required from volunteer (Optional)</h3></label>
                <input
                    type="text" class="input-ctn valid"
                    id="volunteer_volunteerQuestion"
                    name="volunteer_volunteerQuestion"
                    placeholder="E.g. Do you have a Class 3 driving license?" value=""> <label
                for="volunteer_volunteerQuestion" class="error-msg"
                style="display: none;">Exceed maximum character</label>
                <hr class="hr">
            </h3>

            <h3 class="h3 font-dark-grey">Do signups require your confirmation?</h3>

            <label class="ios-switch mt-16">
                <input type="checkbox"
                       name="volunteer_requireConfirmation"
                       class="ios-switch__checkbox confirmation_checkbox">
                <span class="ios-switch__off">No</span>
                <div class="ios-switch__base"></div>
                <span class="ios-switch__on">Yes</span>
            </label>

            <div class="mt-12"><em class="font-mid-grey ios-switch__off-content is-visible">All
                signups are automatically confirmed</em> <!-- update sentences for ticket 543 --> <em
                class="font-mid-grey js-ios-switch__on-content ios-switch__on-content">All signups need to be
                confirmed.</em></div>

        </form>
    </div>
</template>

<script>
    export default {
        name: "ActivityStepThree"
    }
</script>

<style scoped>

</style>
