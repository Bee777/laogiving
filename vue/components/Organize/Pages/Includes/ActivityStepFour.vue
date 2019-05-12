<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form id="volunteer-step-4" novalidate="novalidate" class="active"><h3 class="h3 mb-16 font-dark-grey">Contact
            details</h3>
            <div class="input-ctrl mt-16"><label class="lbl">Title</label>
                <select class="select-ctn select--full"
                        name="volunteer_salutation">
                    <option value="">Please Select</option>
                    <option value="Mr">Mr</option>
                    <option value="Ms">Ms</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Mdm">Mdm</option>
                    <option value="Dr">Dr</option>
                </select> <label class="error-msg">Please select title</label></div>
            <div class="input-ctrl mt-16"><label class="lbl">Name</label> <input
                name="volunteer_contactName"
                id="volunteer_contactName" type="text"
                class="input-ctn field-required" placeholder="Name of the contact person"
                value="">
                <label for="volunteer_contactName" class="error-msg">Error message</label>
            </div>
            <div class="input-ctrl mt-16">
                <label class="lbl">Designation</label>
                <input name="volunteer_contactDesignation"
                       id="volunteer_contactDesignation" type="text"
                       class="input-ctn field-required"
                       placeholder="Designation of contact person" value=""> <label
                for="volunteer_contactDesignation" class="error-msg">Error
                message</label></div>
            <div class="input-ctrl mt-16">
                <label class="lbl">Mobile phone number</label>
                <input
                    id="volunteer_contactOfficePhone"
                    name="volunteer_contactOfficePhone" type="text"
                    class="input-ctn" placeholder="Enter mobile number" value=""> <label
                for="volunteer_contactOfficePhone" class="error-msg">Error
                message</label>
            </div>
            <div class="input-ctrl mt-16">
                <label class="lbl">Email</label> <input
                name="volunteer_contactEmail"
                id="volunteer_contactEmail" type="email"
                class="input-ctn field-required" placeholder="Enter contact email" value="">
                <label for="volunteer_contactEmail" class="error-msg">Error
                    message</label></div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "ActivityStepFour"
    }
</script>

<style scoped>

</style>
