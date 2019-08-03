<template>
    <div class="text-center mb-16">
        <a @click="showModal()" id="report-abuse-button" class="text-link"><i
            class="ico  material-icons ico-flag mr-8">outlined_flag</i>Report
            abuse</a>
    </div>
</template>

<script>
    export default {
        name: "ReportAbuse",
        props: {
            email: {
                default: ''
            },
            data: {
                default: function () {
                    return {};
                }
            }
        },
        methods: {
            showModal() {
                this.$modal.show('reportAbuse', {email: this.email, reason: '', loading: false, data: this.data});
            }
        }
    }
</script>

<style scoped>

</style>
