<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form class="form" id="volunteer-step-2">
            <h3 class="h3 font-dark-grey">We committed only regular volunteers</h3>
            <ul class="tabs list tabs--pills mt-16">
                <li class="is-active">
                    <a class="tabs__a">Regular</a>
                </li>
            </ul>
            <hr class="hr">
            <div class="ctn clearfix">
                <h3 class="h3 mb-16 font-dark-grey">Frequency</h3>
                <div class="input-ctrl grid-12 grid-tablet-portrait-up-8 mt-16 success"
                     :class="[{'error': validated().frequency}]">
                    <select :disabled="disabledRequiredField" id="volunteer_frequency" class="select-ctn select--full valid" name="volunteer_frequency"
                            v-model="frequency">
                        <option value="" disabled>Please select</option>

                        <option value="1_DAY_PER_WEEK">One day per week</option>

                        <option value="2_3_DAYS_PER_WEEK">2-3 days per week</option>

                        <option value="FORTNIGHTLY">Fortnightly</option>

                        <option value="MONTHLY">Monthly</option>

                        <option value="QUARTERLY">Quarterly</option>

                        <option value="FLEXIBLE">Flexible</option>

                        <option value="FULL_TIME">Full Time</option>

                    </select><label for="volunteer_frequency" class="error-msg" style="display: block;">{{validated().frequency}}</label>
                </div>
                <div class="input-ctrl grid-12 grid-tablet-portrait-up-4-last mt-16 success"
                     :class="[{'error': validated().duration}]">
                    <input :disabled="disabledRequiredField" v-model="duration" id="volunteer_duration" type="number"
                           class="input-ctn frequency_duration_input valid"
                           name="volunteer_duration" placeholder="Hours per session" value="">
                    <label for="volunteer_duration" class="error-msg"
                           style="display: block;">{{validated().duration}}</label>
                </div>
            </div>
            <div class="input-ctrl success clearfix">
                <h3 class="h3 mb-16 mt-24 font-dark-grey">Weekday or weekend</h3>
                <ul class="checkbox-list">
                    <li>
                        <label class="checkbox-list__checkbox">
                            <input :disabled="disabledRequiredField" v-model="days_of_week" type="checkbox" value="WEEKDAY" id="givingsgportlet_weekday"
                                   name="volunteer_daysOfTheWeek[]" class="valid">
                            <div class="checkbox-list__lbl-spn">Weekday</div>
                        </label>
                    </li>
                    <li>
                        <label class="checkbox-list__checkbox">
                            <input :disabled="disabledRequiredField" v-model="days_of_week" type="checkbox" value="WEEKEND" id="givingsgportlet_weekend"
                                   name="volunteer_daysOfTheWeek[]">
                            <div class="checkbox-list__lbl-spn">Weekend</div>
                        </label>
                    </li>
                </ul>
                <label v-if="validated().days_of_week" class="error-msg" style="display: block;">Please select weekday
                    and/or weekend
                </label>
            </div>
            <div class="input-ctrl clearfix">
                <h3 class="h3 mb-16 mt-40 font-dark-grey">Commitment period</h3>
                <div class="ctn">
                    <div class="input-ctrl grid-12 grid-tablet-portrait-up-6"
                         :class="[{'error': validated().commitment_from_date}]">
                        <div>
                            <label class="lbl" for="event_startDate">From</label>
                            <input :disabled="disabledRequiredField" id="event_startDate" type="text"
                                   class="input-ctn input--icon-right pickadate-datepicker regular-start-date picker__input"
                                   value="" name="event_startDate" placeholder="DD/MM/YYYY" readonly="">
                            <i class="ico material-icons input-ctrl__icon input-ctrl__icon--right input-ctrl__icon--with-error-msg">event</i>
                        </div>
                        <label style="display: block"
                               class="error-msg">{{ validated().commitment_from_date }}</label>
                    </div>
                    <div class="input-ctrl grid-12 grid-tablet-portrait-up-6-last"
                         :class="[{'error': validated().commitment_to_date}]">
                        <div>
                            <label class="lbl" for="event_endDate">To</label>
                            <input :disabled="disabledRequiredField" id="event_endDate" type="text"
                                   class="input-ctn input--icon-right pickadate-datepicker regular-end-date picker__input"
                                   value="" name="event_endDate" placeholder="DD/MM/YYYY" readonly="">
                            <i class="ico material-icons input-ctrl__icon input-ctrl__icon--right input-ctrl__icon--with-error-msg">event</i>
                        </div>
                        <label style="display: block"
                               class="error-msg">{{ validated().commitment_to_date }}</label>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr">
                    <h3 class="h3 font-dark-grey font-16-tablet-portrait-down">Deadline for sign ups</h3>

                    <div class="input-ctrl" :class="[{'error': validated().deadline_for_sign_ups_date}]">
                        <input :disabled="disabledRequiredField" id="reg-closed-date" type="text"
                               class="input-ctn input--icon-right pickadate-datepicker picker__input"
                               name="registrationClosedDate"
                               value="" placeholder="DD/MM/YYYY" readonly="">

                        <label style="display: block"
                               class="error-msg">{{ validated().deadline_for_sign_ups_date }}</label>


                    </div>
                    <hr class="hr">

                    <h3 class="h3 mb-16 font-dark-grey">Location</h3>
                    <div class="input-ctrl mt-16" :class="[{'error': validated().town}]">
                        <label class="lbl" for="volunteer_address">Town</label>
                        <input id="volunteer_town" type="text"
                               v-model="town"
                               class="input-ctn" name="volunteer_town"
                               placeholder="Enter Town" value="">
                        <label
                            style="display: block;"
                            for="volunteer_town" class="error-msg">{{ validated().town }}</label>
                    </div>

                    <div class="input-ctrl mt-16" :class="[{'error': validated().block_street}]">
                        <label class="lbl" for="volunteer_address">Block &amp; Street</label>
                        <input id="volunteer_address" type="text"
                               v-model="block_street"
                               class="input-ctn" name="volunteer_address"
                               placeholder="Enter Address" value="">
                        <label
                            style="display: block;"
                            for="volunteer_address" class="error-msg">{{ validated().block_street }}</label>
                    </div>
                    <div class="ctn clearfix">
                        <div class="input-ctrl grid-12 grid-tablet-portrait-up-9 mt-16"
                             :class="[{'error': validated().building_name}]">
                            <label class="lbl">Building
                                Name (if any)</label>
                            <input
                                v-model="building_name"
                                id="volunteer_buildingName" type="text"
                                class="input-ctn" name="buildingName"
                                placeholder="Enter building name" value="">
                            <label
                                style="display:block;"
                                for="volunteer_buildingName" class="error-msg">{{ validated().building_name }}</label>
                        </div>
                        <div class="input-ctrl grid-12 grid-tablet-portrait-up-3-last mt-16"
                             :class="[{'error': validated().unit}]">
                            <label class="lbl">Unit (if
                                any)</label>
                            <input
                                id="unitNumber"
                                type="text" class="input-ctn"
                                v-model="unit"
                                name="volunteer_unitNumber" placeholder="Unit number" value="">
                            <label for="unitNumber" style="display:block;"
                                   class="error-msg">{{ validated().unit }}</label></div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import {mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        name: "ActivityStepTwo",
        props: {
            disabledRequiredField: {
                default: false,
            },
            edit: {
                default: false,
            },
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            volunteering_type: 'regular',
            frequency: '',
            duration: '',
            days_of_week: [],
            commitment_from_date: '',
            commitment_to_date: '',
            deadline_for_sign_ups_date: '',
            town: '',
            block_street: '',
            building_name: '',
            unit: '',
            datePicker: {
                commitment_from: null,
                commitment_to: null,
                deadline_for_sign_ups: null,
            }
        }),
        methods: {
            ...mapActions([]),
            ...mapMutations(['setValidated']),
            setData(data) {
                this.frequency = data.frequency;
                this.duration = data.duration;
                this.days_of_week = data.days_of_week;
                this.commitment_from_date = data.commitment_from_date;
                this.commitment_to_date = data.commitment_to_date;
                this.deadline_for_sign_ups_date = data.deadline_for_sign_ups_date;
                this.town = data.town;
                this.block_street = data.block_street;
                this.building_name = data.building_name;
                this.unit = data.unit;
                this.$nextTick(() => {
                    this.initPickers();
                })
            },
            initPickers() {
                let that = this;

                this.jq('.pickadate-datepicker').on('mousedown', function (e) {
                    e.preventDefault();
                });

                let dateEvent_startDateEl = this.jq('#event_startDate');

                if (this.datePicker.commitment_from) {
                    let picker = dateEvent_startDateEl.pickadate('picker');
                    if (that.commitment_from_date) {
                        picker.set('select', new Date(that.commitment_from_date));
                    }
                } else {
                    this.datePicker.commitment_from = dateEvent_startDateEl.pickadate({
                        selectMonths: true,
                        selectYears: 14,
                        format: 'dd/mm/yyyy',
                        formatSubmit: 'dd/mm/yyyy',
                        onOpen: () => {
                        },
                        onSet: function () {
                            that.commitment_from_date = this.get('select', 'yyyy-mm-dd');
                        }
                    });
                }

                let dateEvent_endDateEl = this.jq('#event_endDate');

                if (this.datePicker.commitment_to) {
                    let picker = dateEvent_endDateEl.pickadate('picker');
                    if (that.commitment_to_date) {
                        picker.set('select', new Date(that.commitment_to_date));
                    }
                } else {
                    this.datePicker.commitment_to = dateEvent_endDateEl.pickadate({
                        selectMonths: true,
                        selectYears: 14,
                        format: 'dd/mm/yyyy',
                        formatSubmit: 'dd/mm/yyyy',
                        onOpen: () => {
                        },
                        onSet: function () {
                            that.commitment_to_date = this.get('select', 'yyyy-mm-dd');
                        }
                    });
                }

                let dateRegClosedDateEl = this.jq('#reg-closed-date');

                if (this.datePicker.deadline_for_sign_ups) {
                    let picker = dateRegClosedDateEl.pickadate('picker');
                    if (that.deadline_for_sign_ups_date) {
                        picker.set('select', new Date(that.deadline_for_sign_ups_date));
                    }
                } else {
                    this.datePicker.deadline_for_sign_ups = dateRegClosedDateEl.pickadate({
                        selectMonths: true,
                        selectYears: 14,
                        format: 'dd/mm/yyyy',
                        formatSubmit: 'dd/mm/yyyy',
                        onOpen: () => {
                        },
                        onSet: function () {
                            that.deadline_for_sign_ups_date = this.get('select', 'yyyy-mm-dd');
                        }
                    });
                }
            },
            getData() {
                return new Promise((res, rej) => {
                    //validate data
                    let formData = new FormData();
                    let data = {
                        frequency: this.frequency,
                        duration: this.duration,
                        days_of_week: this.days_of_week,
                        volunteering_type: this.volunteering_type,
                        commitment_from_date: this.commitment_from_date,
                        commitment_to_date: this.commitment_to_date,
                        deadline_for_sign_ups_date: this.deadline_for_sign_ups_date,
                        town: this.town,
                        block_street: this.block_street,
                        building_name: this.building_name,
                        unit: this.unit,
                    }, validateWithCurrentDate = !this.edit ? '>now': '';

                    this.$utils.Validate(data, {
                        'volunteering_type': ['required', {max: 191}],
                        'frequency': ['required', {max: 191}],
                        'duration': ['required', {min: 1, type: 'number'}, {max: 24, type: 'number'}],
                        'days_of_week': ['required', {max: 191}],
                        'commitment_from_date': ['required', {max: 191}],
                        'commitment_to_date': ['required', validateWithCurrentDate, {
                            greaterThan: 'commitment_from_date',
                            type: 'date'
                        }, {max: 191}],
                        'deadline_for_sign_ups_date': ['required', validateWithCurrentDate, {
                            greaterThan: 'commitment_from_date',
                            lessThan: 'commitment_to_date',
                            type: 'date'
                        }, {max: 191}],
                        'town': ['required', {max: 191}],
                        'block_street': ['required', {max: 191}],
                        'building_name': [{max: 191}],
                        'unit': [{max: 191}],
                    }).then(v => {
                        formData.append('frequency', this.frequency);
                        formData.append('duration', this.duration);
                        this.days_of_week.map(day => {
                            formData.append('days_of_week[]', day);
                        });
                        formData.append('volunteering_type', this.volunteering_type);
                        formData.append('commitment_from_date', this.commitment_from_date);
                        formData.append('commitment_to_date', this.commitment_to_date);
                        formData.append('deadline_for_sign_ups_date', this.deadline_for_sign_ups_date);
                        formData.append('town', this.town);
                        formData.append('block_street', this.block_street);
                        formData.append('building_name', this.building_name);
                        formData.append('unit', this.unit);

                        res({formData, data})

                    }).catch(e => {
                        this.setValidated({errors: e.errors});
                        rej(e.errors);
                    })

                });
            }
        },
        mounted() {
            this.initPickers();
        }
    }
</script>

<style scoped>

</style>
