<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form class="form" id="volunteer-step-3" @submit.prevent>
            <!--<div class="bulk-booking mb-24">-->
            <!--<h3 class="h3 font-dark-grey">Enable Organisation or Groups to sign up for-->
            <!--this activity?</h3> <label-->
            <!--class="ios-switch mt-16">-->
            <!--<input type="checkbox"-->
            <!--id="bulk_booking"-->
            <!--name="bulk_booking"-->
            <!--class="ios-switch__checkbox"> <span-->
            <!--class="ios-switch__off">No</span>-->
            <!--<div class="ios-switch__base"></div>-->
            <!--<span class="ios-switch__on">Yes</span> </label>-->
            <!--<hr class="hr">-->
            <!--</div>-->
            <h3 class="h3 font-dark-grey">Volunteer positions</h3>
            <span class="body-txt body-txt--small">You can only create 3 volunteer positions</span>

            <div class="mt-24 position-fields-wrapper">
                <div v-for="(item, idx) in positions" :key="idx"
                     class="activity-position volunteer-role-accordion-card accordion-card accordion-card--fill-head accordion-card--always-collapsible create-volunteer-act__accordian mb-16">
                    <div class="accordion-card__head" @click="item.collapsed = !item.collapsed">
                        <h5 class="h5 font-dark-grey">VOLUNTEER POSITION {{idx + 1}}</h5>
                        <i class="material-icons accordion-card__chevron">{{ !item.collapsed ? 'keyboard_arrow_up':
                            'keyboard_arrow_down'}}</i>
                        <div class="accordion-card__hitarea"></div>
                    </div>

                    <!--POSITION BODY-->
                    <div class="accordion-card__body mt-16" v-show="!item.collapsed">

                        <div class="text-right" v-if="idx !== 0">
                            <button type="button"
                                    @click="removePosition(idx)"
                                    class="button-ctn button--with-icon button--no-bg button--font-dark-grey button--dark button--large font-dark-grey button--no-right-pad js-create-volunteer-act__role-remove create-volunteer-act__role-remove">
                                <div class="button--with-icon__wrapper font-dark-grey"><i
                                    class="ico ico-remove-gray button--with-icon__icon"></i> REMOVE POSITION
                                </div>
                            </button>
                        </div>

                        <div class="input-ctrl success" :class="[{'error':  item.validated.position_title}]">
                            <label class="lbl">Position title</label>
                            <input
                                v-model="item.position_title"
                                id="position_name"
                                name="position_name" type="text"
                                class="input-ctn position-name" placeholder="e.g. Befriender">
                            <label for="position_name" class="error-msg"
                                   style="display: block;">{{ item.validated.position_title }}</label>
                        </div>


                        <div class="ctn clearfix">
                            <div class="input-ctrl grid-12 grid-tablet-portrait-up-6 mt-16 success"
                                 :id="`vacancies-${idx}`"
                                 :class="[{'error':  item.validated.vacancies}]">
                                <label class="lbl" :for="`vacancies-${idx}`">Vacancies</label>
                                <input
                                    v-model="item.vacancies"
                                    id="position_vacancies"
                                    name="position_vacancies"
                                    type="number" class="input-ctn position-vacancy "
                                    placeholder="Enter number">
                                <label for="position_vacancies"
                                       class="error-msg" style="display: block;">{{ item.validated.vacancies }}</label>
                            </div>


                            <div class="input-ctrl grid-12 grid-tablet-portrait-up-6-last mt-16 success"
                                 data-id="min-age" :class="[{'error':  item.validated.minimum_age}]">
                                <label class="lbl">Minimum age (Optional)</label>
                                <input
                                    v-model="item.minimum_age"
                                    id="position_minimumAge"
                                    name="position_minimumAge"
                                    type="number" class="input-ctn position-minimum-age " placeholder="Enter number">
                                <label for="position_minimumAge"
                                       class="error-msg" style="display: block;">{{ item.validated.minimum_age
                                    }}</label>
                            </div>
                        </div>
                        <div class="input-ctrl mt-16">
                            <label class="lbl">Skills</label>
                            <div style="margin-bottom: 0;" class="ctn gallery gallery-tablet-portrait-up-6 clearfix">
                                <Tags style="margin-bottom: 0;" :ref="`activity-skills-${idx}`" :max="10"
                                      v-model="item.position_skills"
                                      :items="skills"/>
                            </div>
                            <div class="controls" style="margin-bottom: 2rem;">
                                <label v-if="item.validated.position_skills" class="error-msg" id="skill-error"
                                       style="display: block;">Please
                                    select at least
                                    one skill</label></div>
                        </div>
                        <div class="input-ctrl mt-16 clearfix">
                            <label class="lbl">Suitable for</label>

                            <Tags style="margin-bottom: 0;" :ref="`activity-suitables-${idx}`" :max="10"
                                  v-model="item.position_suitables"
                                  :items="suitables"/>

                            <label v-if="item.validated.position_suitables" class="error-msg" id="suitabilities-error"
                                   style="display: block;margin-bottom: 1rem;">Please select at
                                least one
                                category</label></div>

                        <div class="input-ctrl mt-16 success"
                             :class="[{'error':  item.validated.key_responsibilities}]"><label class="lbl">Key
                            responsibilities and impact</label>

                            <TextareaLimit
                                v-model="item.key_responsibilities"
                                placeholder="Let your volunteers-to-be know what they will be doing and the impact they are making. Some tips and advice specific to the position will be useful"
                                :ref="`activity-impact-position-${idx}-limit`" max="500"
                                rows="10"/>

                            <label style="display: block;" class="help-block error-msg">{{
                                item.validated.key_responsibilities}}</label>

                        </div>
                    </div>
                    <!--POSITION BODY-->

                </div>
            </div>

            <button @click="AddPosition()" v-if="positions.length < maxPositions"
                    class="button-ctn button--with-icon button--no-bg button--large button--no-left-pad"
                    style="display: inline-block;">
                <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                    class="ico ico-add button--with-icon__icon"></i> ADD ANOTHER POSITION
                </div>
            </button>

            <!--End Position-->

            <hr class="hr">
            <div class="input-ctrl mt-16 success">
                <label class="lbl">
                    <h3 class="h3 font-dark-grey">Additional points to note (optional)</h3>
                </label>
                <TextareaLimit
                    placeholder="General information for all positions"
                    ref="activity-desc-limit" max="500"
                    v-model="points_to_note"
                    rows="5"/>

                <label style="display: block;" class="help-block error-msg">{{validated().points_to_note}}</label>
            </div>

            <hr class="hr">

            <h3 class="h3 font-dark-grey">Required information from volunteers (Optional)</h3>
            <div class="body-txt body-txt--small">Select all that you require</div>

            <ul class="checkbox-list mt-16">
                <li><label class="checkbox-list__checkbox"
                           for="activity-age">
                    <input name="volunteer_requireContactNumber"
                           v-model="volunteer_contact_phone_number"
                           type="checkbox" value="false" id="activity-age">
                    <div class="checkbox-list__lbl-spn">Contact Number
                    </div>
                </label></li>
                <li><label class="checkbox-list__checkbox"
                           for="activity-gender">
                    <input name="volunteer_requireGender" type="checkbox"
                           v-model="volunteer_gender"
                           value="false" id="activity-gender">
                    <div class="checkbox-list__lbl-spn">Gender</div>
                </label></li>
            </ul>

            <hr class="hr">

            <h3 class="h3 font-dark-grey">
                <label class="lbl"><h3
                    class="h3 font-dark-grey">Other response required from volunteer (Optional)</h3></label>
                <input
                    v-model="other_response_required"
                    type="text" class="input-ctn valid"
                    id="volunteer_volunteerQuestion"
                    name="volunteer_volunteerQuestion"
                    placeholder="E.g. Do you have a Class 3 driving license?" value="">
                <label
                    for="volunteer_volunteerQuestion" class="error-msg"
                    style="display: block;">{{ validated().other_response_required }}</label>

                <hr class="hr">
            </h3>

            <h3 class="h3 font-dark-grey">Do signups require your confirmation?</h3>

            <label class="ios-switch mt-16">
                <input type="checkbox"
                       v-model="volunteer_signups_confirm"
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
    import {mapGetters, mapMutations, mapActions} from 'vuex'
    import TextareaLimit from '@com/Utils/TextAreaLimiter.vue'
    import Tags from '@com/Utils/Tags.vue'

    export default {
        name: "ActivityStepThree",
        props: {
            skills: {
                default: function () {
                    return [];
                }
            },
            suitables: {
                default: function () {
                    return [];
                }
            }
        },
        components: {
            TextareaLimit,
            Tags
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            points_to_note: '',
            volunteer_gender: false,
            volunteer_contact_phone_number: false,
            other_response_required: '',
            volunteer_signups_confirm: false,
            maxPositions: 3,
            positions: [{
                collapsed: false,
                position_title: '',
                vacancies: '',
                minimum_age: '',
                position_skills: [],
                position_suitables: [],
                key_responsibilities: '',
                validated: {},
            }],
        }),
        methods: {
            ...mapActions([]),
            ...mapMutations(['setValidated']),
            AddPosition() {
                if (this.positions.length < this.maxPositions) {
                    this.positions.push({
                        collapsed: false,
                        position_title: '',
                        vacancies: '',
                        minimum_age: '',
                        position_skills: [],
                        position_suitables: [],
                        key_responsibilities: '',
                        validated: {},
                    })
                }
            },
            removePosition(idx) {
                this.positions.splice(idx, 1);
            },
            setData(data) {
                this.points_to_note = data.points_to_note;
                this.volunteer_gender = data.volunteer_gender;
                this.volunteer_contact_phone_number = data.volunteer_contact_phone_number;
                this.other_response_required = data.other_response_required;
                this.volunteer_signups_confirm = data.volunteer_signups_confirm;
                this.positions = this.$utils.deepCopy(data.positions);
                this.$nextTick(() => {
                    this.$refs['activity-desc-limit'].set(this.points_to_note);
                    data.positions.map((i, idx) => {
                        this.$refs[`activity-skills-${idx}`][0].setValue(i.position_skills);
                        this.$refs[`activity-suitables-${idx}`][0].setValue(i.position_suitables);
                        this.$refs[`activity-impact-position-${idx}-limit`][0].set(i.key_responsibilities);
                    })
                });
            },
            getData() {
                return new Promise((res, rej) => {
                    //validate data
                    let formData = new FormData();
                    let data = {
                        points_to_note: this.points_to_note,
                        volunteer_gender: this.volunteer_gender,
                        volunteer_contact_phone_number: this.volunteer_contact_phone_number,
                        other_response_required: this.other_response_required,
                        volunteer_signups_confirm: this.volunteer_signups_confirm,
                        positions: this.positions,
                    };

                    //first validates
                    this.positions.map((i, idx) => {
                        //reset validated
                        i.validated = {};
                        this.$utils.Validate(i, {
                            position_title: ['required', {max: 191}],
                            vacancies: ['required', 'number', {min: 1, type: 'number'}, {max: 200000, type: 'number'}],
                            minimum_age: ['number', {min: 13, type: 'number'}, {max: 200, type: 'number'}],
                            position_skills: ['required'],
                            position_suitables: ['required'],
                            key_responsibilities: ['required', {max: 500}],
                        }).then(v => {
                            formData.append('positions[]', JSON.stringify(i));
                            //second validate
                            if (this.positions.length - 1 === idx) {
                                this.$utils.Validate(data, {
                                    'points_to_note': [{max: 500}],
                                    'other_response_required': [{max: 191}],
                                }).then(v => {

                                    formData.append('points_to_note', this.points_to_note);
                                    formData.append('volunteer_gender', this.volunteer_gender);
                                    formData.append('volunteer_contact_phone_number', this.volunteer_contact_phone_number);
                                    formData.append('other_response_required', this.other_response_required);
                                    formData.append('volunteer_signups_confirm', this.volunteer_signups_confirm);

                                    res({formData, data})

                                }).catch(e => {
                                    this.setValidated({errors: e.errors});
                                    rej(e.errors);
                                });
                            }
                        }).catch(e => {
                            i.validated = e.errors;
                            rej(e.errors);
                        });

                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>
