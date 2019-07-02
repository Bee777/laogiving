<template>
    <div class="rounded-card__body rounded-card__body--responsive">
        <form id="volunteer-step-4" novalidate="novalidate" class="active"><h3 class="h3 mb-16 font-dark-grey">Contact
            details</h3>

            contact_designation
            contact_phone_number
            contact_email

            <div class="input-ctrl mt-16"
                 :class="[{'error': validated().contact_title }]"><label class="lbl">Title</label>
                <select class="select-ctn select--full"
                        v-model="contact_title"
                        name="volunteer_salutation">
                    <option value="">Please Select</option>
                    <option value="mr">Mr</option>
                    <option value="ms">Ms</option>
                    <option value="mrs">Mrs</option>
                    <option value="miss">Miss</option>
                    <option value="mdm">Mdm</option>
                    <option value="dr">Dr</option>
                </select> <label class="error-msg" style="display:block;">{{validated().contact_title}}</label></div>
            <div class="input-ctrl mt-16"
                 :class="[{'error': validated().contact_name }]"><label class="lbl">Name</label> <input
                v-model="contact_name"
                name="volunteer_contactName"
                id="volunteer_contactName" type="text"
                class="input-ctn field-required" placeholder="Name of the contact person"
                value="">
                <label for="volunteer_contactName" style="display:block;" class="error-msg">{{validated().contact_name}}</label>
            </div>
            <div class="input-ctrl mt-16"
                 :class="[{'error': validated().contact_designation }]">
                <label class="lbl">Designation</label>
                <input name="volunteer_contactDesignation"
                       v-model="contact_designation"
                       id="volunteer_contactDesignation" type="text"
                       class="input-ctn field-required"
                       placeholder="Designation of contact person" value=""> <label
                for="volunteer_contactDesignation" style="display:block;" class="error-msg">{{validated().contact_designation}}</label>
            </div>
            <div class="input-ctrl mt-16"
                 :class="[{'error': validated().contact_phone_number }]">
                <label class="lbl">Mobile phone number</label>
                <input
                    v-model="contact_phone_number"
                    id="volunteer_contactOfficePhone"
                    name="volunteer_contactOfficePhone" type="text"
                    class="input-ctn" placeholder="Enter mobile number" value=""> <label style="display:block;"
                                                                                         for="volunteer_contactOfficePhone"
                                                                                         class="error-msg">{{
                validated().contact_phone_number}}</label>
            </div>
            <div class="input-ctrl mt-16"
                 :class="[{'error': validated().contact_email }]">
                <label class="lbl">Email</label> <input
                v-model="contact_email"
                name="volunteer_contactEmail"
                id="volunteer_contactEmail" type="email"
                class="input-ctn field-required" placeholder="Enter contact email" value="">
                <label style="display:block;" for="volunteer_contactEmail" class="error-msg">{{
                    validated().contact_email }}</label></div>
        </form>
    </div>
</template>

<script>
    import {mapGetters, mapMutations, mapActions} from 'vuex'

    export default {
        name: "ActivityStepFour",
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            contact_title: '',
            contact_name: '',
            contact_designation: '',
            contact_phone_number: '',
            contact_email: '',
        }),
        methods: {
            ...mapActions([]),
            ...mapMutations(['setValidated']),
            setData(data) {
                this.contact_title = data.contact_title;
                this.contact_name = data.contact_name;
                this.contact_designation = data.contact_designation;
                this.contact_phone_number = data.contact_phone_number;
                this.contact_email = data.contact_email;
            },
            getData() {
                return new Promise((res, rej) => {
                    //validate data
                    let formData = new FormData();
                    let data = {
                        contact_title: this.contact_title,
                        contact_name: this.contact_name,
                        contact_designation: this.contact_designation,
                        contact_phone_number: this.contact_phone_number,
                        contact_email: this.contact_email
                    };
                    this.$utils.Validate(data, {

                        contact_title: ['required', {max: 191}],
                        contact_name: ['required', {max: 191}],
                        contact_designation: ['required', {max: 191}],
                        contact_phone_number: ['required', 'phone number', {max: 191}],
                        contact_email: ['required', 'email', {max: 191}],

                    }).then(v => {

                        formData.append('contact_title', this.contact_title);
                        formData.append('contact_name', this.contact_name);
                        formData.append('contact_designation', this.contact_designation);
                        formData.append('contact_phone_number', this.contact_phone_number);
                        formData.append('contact_email', this.contact_email);

                        res({formData, data});

                    }).catch(e => {
                        this.setValidated({errors: e.errors});
                        rej(e.errors);
                    })
                })
            },
        },

    }
</script>

<style scoped>

</style>
