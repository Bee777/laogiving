<template>
    <div class>
        <section class="contact">
            <div class="container">
                <div class="title section-heading">
                    <h3 class="h3 entry-title dark">Contact us</h3>
                </div>
                <div class="row">
                    <div class="contact-content">
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                            <div class>
                                <h3 class="h3 dark">Get in touch with us</h3>
                                <p>Got a cool idea, feedback on how we can improve or maybe just to say hi?</p>
                                <p>We'd love to hear from you! Please drop us an email at below.</p>
                                <div
                                    class="con-icon">
                                    <h3 class="h3">
                                        <i class="fas fa-phone"></i>
                                        {{s.phone}}
                                    </h3>
                                    <h3 class="h3">
                                        <i class="fas fa-envelope"></i>
                                        {{s.email}}
                                    </h3>
                                    <h3 class="h3">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{s.address}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                            <ContactForm :isFullWidth="true"/>
                        </div>
                    </div>
                </div>
                <!-- <google-map /> -->
                <div class="map">
                    <iframe
                        :src="s.google_map"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                    ></iframe>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import Base from "@com/Bases/GeneralBase.js";
    import ContactForm from '@com/General/Default/ContactForm.vue'

    export default Base.extend({
        components: {
            ContactForm
        },
        created() {
            this.setPageTitle(`Contact Us`);
        }
    });
</script>
<style lang="scss">
    .contact {
        padding: 8px 0.9rem 42px;
        background: #edf3f5;
    }
    .contact .general-from-container {
        min-height: 100%;
        height: 100%;
    }
    .title {
        font-size: 24px;
        margin-top: 15px;
    }

    input.general-input {
        border: none;
    }

    .general-from-container:before, .general-from-container:after {
        height: 0;
        content: none;
    }

    .form-represent-form-container .field .control textarea {
        -webkit-box-shadow: none;
        box-shadow: none;
        box-shadow: unset;
        display: block;
        max-width: 100%;
        min-width: 100%;
        padding: 0.625em;
        resize: vertical;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #dadce0;
    }

    .form-represent-form-container .field .control textarea:hover {
        border: 1px solid #dadce0;
    }

    .form-represent-form-container .field .control textarea:focus {
        border: 2px solid #1a73e8;
        padding: 0.825em;
        outline: none;
    }
    .form-represent-form-container .textarea:not([rows]) {
        max-height: 600px;
        min-height: 120px;
    }

    input[type=text]:focus, input[type=email]:focus, input[type=url]:focus, input[type=password]:focus, input[type=search]:focus, textarea:focus {
        border: none;
    }

    .contact button.button-contact.contact-button {
        background-color: #1a73e8;
        margin-top: 20px;
    }

    .button-contact {
        background-color: white;
        border-color: #dbdbdb;
        border-width: 1px;
        color: #363636;
        cursor: pointer;
        justify-content: center;
        text-align: center;
        white-space: nowrap;
    }

    .button-contact {
        border: 1px solid transparent;
        border-radius: 4px;
        box-shadow: none;
    }

    .button-contact.is-fullwidth {
        display: flex;
        width: 100%;
    }

    .button-contact.is-large {
        font-size: 1.5rem;
    }

    .button-contact.is-info {
        background-color: #209cee;
        border-color: transparent;
        color: #fff;
    }

    button.button-contact:hover, input[type=button].button-contact:hover, input[type=reset].button-contact:hover, input[type=submit].button-contact:hover,
    button.button-contact:focus, input[type=button].button-contact:focus, input[type=reset].button-contact:focus, input[type=submit].button-contact:focus {
        color: #fff !important;
        border: 1px solid transparent;
    }

    .contact .form-represent.is-65 {
        min-height: 0;
    }
    .contact .form-represent {
        -webkit-flex-shrink: 0;
        flex-shrink: 0;
        background: #fff;
        -webkit-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-shadow: none;
        box-shadow: none;
        display: block;
        margin: 0 auto;
        min-height: 0;
        width: 450px;
    }

    .contact .form-represent {
        border: 1px solid #dadce0;
    }
    .con-icon{
        padding: 8px 0.9rem 42px;
        background: #edf3f5;
    }
    .form-represent-form-container .field .control textarea.is-error {
        border: 2px solid #d93025;
    }
    .map {
        padding: 6px 6px 0;
        -webkit-border-radius: 8px;
        border-radius: 8px;
        border: 1px solid #dadce0;
        background-color: white;
    }
    .map {
        margin-top: calc(2rem - 0.55rem);
    }
    .map > iframe {
        width: 100%;
        height: 400px;
    }
</style>
