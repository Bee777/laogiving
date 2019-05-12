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
            <div class="input-ctrl">
                <h3 class="h3 mb-16 mt-40 font-dark-grey">Commitment period</h3>
                <div class="ctn">
                    <div class="input-ctrl grid-12 grid-tablet-portrait-up-6">
                        <div>
                            <label class="lbl" for="event_startDate">From</label>
                            <input id="event_startDate" type="text"
                                   class="input-ctn input--icon-right pickadate-datepicker regular-start-date picker__input"
                                   value="" name="event_startDate" placeholder="DD/MM/YYYY" readonly="">
                            <i class="ico material-icons input-ctrl__icon input-ctrl__icon--right input-ctrl__icon--with-error-msg">event</i>
                            <label class="error-msg" for="event_startDate" style="display: none">Please select weekday
                                or/and weekend</label>
                        </div>
                    </div>
                    <div class="input-ctrl grid-12 grid-tablet-portrait-up-6-last">
                        <div>
                            <label class="lbl" for="event_endDate">To</label>
                            <input id="event_endDate" type="text"
                                   class="input-ctn input--icon-right pickadate-datepicker regular-end-date picker__input"
                                   value="" name="event_endDate" placeholder="DD/MM/YYYY" readonly="">
                            <i class="ico material-icons input-ctrl__icon input-ctrl__icon--right input-ctrl__icon--with-error-msg">event</i>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr">
                    <h3 class="h3 font-dark-grey font-16-tablet-portrait-down">Deadline for sign ups</h3>

                    <div class="input-ctrl">
                        <input id="reg-closed-date" type="text"
                               class="input-ctn input--icon-right pickadate-datepicker picker__input"
                               name="registrationClosedDate"
                               value="" placeholder="DD/MM/YYYY" readonly="">
                    </div>
                    <hr class="hr">

                    <h3 class="h3 mb-16 font-dark-grey">Location</h3>

                    <div class="input-ctrl mt-16"><label class="lbl" for="volunteer_address">Block &amp; Street</label>
                        <input id="volunteer_address" type="text"
                               class="input-ctn" name="volunteer_address"
                               placeholder="Enter Address" value=""> <label
                            for="volunteer_address" class="error-msg">Error
                            message</label></div>
                    <div class="ctn clearfix">
                        <div class="input-ctrl grid-12 grid-tablet-portrait-up-9 mt-16">
                            <label class="lbl">Building
                                Name (if any)</label> <input
                            id="volunteer_buildingName" type="text"
                            class="input-ctn" name="buildingName"
                            placeholder="Enter building name" value=""> <label
                            for="volunteer_buildingName" class="error-msg">Error
                            message</label></div>
                        <div class="input-ctrl grid-12 grid-tablet-portrait-up-3-last mt-16">
                            <label class="lbl">Unit (if
                                any)</label>
                            <input
                                id="unitNumber"
                                type="text" class="input-ctn"
                                name="volunteer_unitNumber" placeholder="Unit number" value="">
                            <label for="unitNumber"
                                   class="error-msg">Error message</label></div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "ActivityStepTwo",
        methods: {
            initPickers() {

                this.jq('.pickadate-datepicker').on('mousedown', function (e) {
                    e.preventDefault();
                });
                this.jq('#event_startDate').pickadate({
                    selectMonths: true,
                    selectYears: 14,
                    format: 'dd/mm/yyyy',
                    formatSubmit: 'dd/mm/yyyy',
                    onOpen: () => {
                    },
                    onClose: function () {
                        console.log(this.get('select', 'yyyy-mm-dd'))
                    }
                });

                this.jq('#event_endDate').pickadate({
                    selectMonths: true,
                    selectYears: 14,
                    format: 'dd/mm/yyyy',
                    formatSubmit: 'dd/mm/yyyy',
                    onOpen: () => {
                    },
                    onClose: function () {
                        console.log(this.get('select', 'yyyy-mm-dd'))
                    }
                });

                this.jq('#reg-closed-date').pickadate({
                    selectMonths: true,
                    selectYears: 14,
                    format: 'dd/mm/yyyy',
                    formatSubmit: 'dd/mm/yyyy',
                    onOpen: () => {
                    },
                    onClose: function () {
                        console.log(this.get('select', 'yyyy-mm-dd'))
                    }
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
