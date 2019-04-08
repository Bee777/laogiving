<template>
    <div class>
        <section class="contact">
            <div class="container">
                <div class="title section-heading">
                    <div class="entry-title">Contact us</div>
                </div>
                <div class="columns is-multiline contact-content">
                    <div class="column is-5">
                        <div class>
                            <p class="title">Get in touch with us</p>
                            <p>
                                For more information, please contact us through these contact info
                            </p>
                            <div
                                class="con-icon contact"
                                v-if="!$utils.isEmptyVar( homeData.ContactInfo )">
                                <h3>
                                    <i class="fas fa-phone"></i>
                                    {{homeData.ContactInfo.phone}}
                                </h3>
                                <h3>
                                    <i class="fas fa-envelope"></i>
                                    {{homeData.ContactInfo.email}}
                                </h3>
                                <h3>
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{homeData.ContactInfo.address}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="column is-7-desktop is-12-mobile is-7-tablet">
                        <ContactForm :isFullWidth="true"/>
                    </div>
                </div>
                <!-- <google-map /> -->
                <div class="map">
                    <iframe
                        src="https://maps.google.com/maps?width=100%&amp;height=400&amp;hl=en&amp;q=Laos%2C%20Dongdork+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=13&amp;iwloc=B&amp;output=embed"
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
    import ContactForm from '@com/General/ContactForm.vue'

    export default Base.extend({
        components: {
            ContactForm
        },
        created() {
            this.fetchHomeData();
            this.setPageTitle(`Contact Us`);
        }
    });
</script>
