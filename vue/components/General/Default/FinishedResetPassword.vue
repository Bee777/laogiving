<template>
    <div>
        <div class="general-from-container is-65">
            <div class="form-represent is-65">
                <!--Start form login-->
                <div class="form-represent-form-container">
                    <!--Logo-->
                    <div class="form-represent-form is-full-height">
                        <div class="form-represent-form-logo-container">
                            <div class="form-represent-form-logo-inner">
                                <img :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`">
                            </div>
                        </div>
                    </div>
                    <!--Logo-->
                    <!--Elements-->
                    <div class="form-represent-form-elements-container">
                        <div>
                            <div class="form-represent-form-elements-container-inner">
                                <!--Header Caption -->
                                <div class="form-represent-form-header-caption">
                                    <div class="header-text-centered">
                                        <h1 class="headingText">
                                            <content>Thank you for attention</content>
                                        </h1>
                                        <div class="headingSubtext">
                                            <content>Sign in to continue to our site with your new password.
                                            </content>
                                        </div>
                                    </div>
                                </div>
                                <!--Header Caption -->
                            </div>
                        </div>
                    </div>
                    <!--Elements-->
                </div>
                <!--End form login-->
                <div class="masked-blur-form"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        name: "FinishedResetPassword",
        mounted() {
            this.setPageTitle('Finished ResetPassword');

            if (this.$utils.hasSession('finished-reset-password', true))
                this.$utils.Location('/', 2000);
            else
                this.Route({name: 'home'});
        }
    })
</script>

<style scoped>

</style>
