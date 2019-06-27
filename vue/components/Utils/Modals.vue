<template>
    <div>
        <modal id="reportmodal" transition="pop-out" :name="modalNames.report" classes="modal-ctn"
               :width="modalWidth"
               height="auto"
               @opened="reportForm"
               @before-open="beforeOpen"
               @before-close="beforeClose">
            <div class="content-area">
                <main class="site-main activity" style="padding-bottom: 0">
                    <div class="login-form form">
                        <h2 class="h2 text-center mb-16">Report Abuse</h2>
                        <div class="cursor" @click="hide(modalNames.report, {close: true})">
                            <i class="material-icons close-modal-ctn">close</i>
                        </div>
                        <form name="reportform" @submit.prevent method="post">
                            <div class="input-ctrl">
                                <label for="userEmail">
                                    <h3 class="h3 font-dark-grey font-16-tablet-portrait-down">Your Email Address</h3>
                                </label>
                                <input v-model="modalData.reportAbuse.email" required id="userEmail" class="input-ctn"
                                       autocomplete="username email"
                                       name="email" value="" type="email"
                                       placeholder="e.g. Your Email Address">
                                <label for="userEmail" style="display: block"
                                       class="error-msg">{{validated().email}}</label>
                            </div>
                            <div class="input-ctrl">
                                <label class="lbl"><h3
                                    class="h3 font-dark-grey font-16-tablet-portrait-down">Your Feedback</h3></label>

                                <TextareaLimit ref="textarea-limit" max="800" v-model="modalData.reportAbuse.reason"
                                               rows="10"/>
                                <label style="display: block;" class="help-block error-msg">{{ validated().reason
                                    }}</label>

                                <!--<textarea v-model="report.reason" id="reason" class="textarea-ctn" rows="10" required=""-->
                                <!--name="reason">{{report.reason}}</textarea>-->
                                <!--<label for="reason" style="display: block;"-->
                                <!--class="help-block error-msg">{{ validated().reason }}</label>-->
                            </div>

                            <div class="text-center">
                                <button v-if="!modalData.reportAbuse.loading" @click="reportAbuse()"
                                        style="margin-bottom: 0;"
                                        class="button-ctn button--large button--135 mr-24">
                                    SUBMIT
                                </button>
                                <button v-else style="margin-bottom: 0;"
                                        class="button-ctn button--large button--135 mr-24">
                                    SUBMIT...
                                </button>
                            </div>

                        </form>
                    </div>
                </main>
            </div>
        </modal>
    </div>
</template>

<script>
    const MODAL_WIDTH = 858, SCROLL_WIDTH = 32;
    import {mapActions, mapMutations, mapState, mapGetters} from 'vuex'
    import TextareaLimit from '@com/Utils/TextAreaLimiter.vue'

    export default {
        name: "Modals",
        components: {
            TextareaLimit
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            modalNames: {report: 'reportAbuse'},
            modalWidth: MODAL_WIDTH,
            excludeOutSideClose: {reportAbuse: true},
            modalData: {reportAbuse: {}},
        }),
        computed: {
            ...mapState(['authUserInfo', 'userProfile']),
        },
        watch: {
            '$route.path': function (n, o) {
                for (let m in this.modalNames) {
                    if (this.modalNames.hasOwnProperty(m)) {
                        this.hide(this.modalNames[m], {close: true});
                    }
                }
            }
        },
        methods: {
            ...mapMutations(['setClearValidate']),
            ...mapActions(['postReportAbuse']),
            beforeOpen(e) {
                this.jq("html").addClass("hidden sidebar");
                this.jq("body").addClass("hidden sidebar");
                this.modalData[e.name] = e.params;
            },
            beforeClose(e) {
                /*
                Stopping close event execution
                */
                if (this.excludeOutSideClose[e.name] && !(e.params && e.params.close)) {
                    e.stop();
                    return;
                }
                this.setClearValidate(this.modalData[e.name]);
                this.modalData[e.name] = {};
                this.jq("body").removeClass("hidden sidebar");
                this.jq("html").removeClass("hidden sidebar");
            },
            hide(n, params) {
                this.$modal.hide(n, params);
            },
            reportForm(e) {
            },
            reportAbuse() {
                this.modalData.reportAbuse.loading = true;
                this.postReportAbuse(this.modalData.reportAbuse)
                    .then(res => {
                        if (res.success) {
                            this.toaster(res.msg);
                            setTimeout(() => {
                                this.hide(this.modalNames.report, {close: true});
                            }, 600)
                        }
                        this.modalData.reportAbuse.loading = false;
                    })
                    .catch(err => {
                        //console.log(err);
                        this.modalData.reportAbuse.loading = false;
                    })
            },
            //Toaster
            toaster(msg, delay = 3500) {
                let toaster = this.jq('.toast');
                if (!toaster.length) {
                    return;
                }
                toaster.get(0).innerHTML = msg;
                toaster.css('display', 'block');
                setTimeout(() => {
                    toaster.get(0).innerHTML = '';
                    toaster.css('display', 'none');
                }, delay)
            },
            //Toaster
        },
        created() {
            let wWidth = this.jq(document).width();
            this.modalWidth = wWidth - SCROLL_WIDTH < MODAL_WIDTH
                ? wWidth - ((wWidth + SCROLL_WIDTH) * 8 / 100)
                : MODAL_WIDTH;
        }
    }
</script>

<style lang="scss">

    .pop-out-enter-active,
    .pop-out-leave-active {
        transition: all 0.5s;
    }

    .pop-out-enter,
    .pop-out-leave-active {
        opacity: 0;
        transform: translateY(24px);
    }
</style>
