<template>
    <div class="rounded-card__body rounded-card__body--responsive text-center">
        <h3 class="h3 mb-16 font-dark-grey">This is a preview of your volunteer opportunity</h3>
        <div class="card " style="width:54% ; ">
            <div class="card__head card__head--content-ratio-270-200">
                <div class="card__abs-ctn gradient-over-image">
                    <div class="gradient-over-image__image gradient-over-image__image--bg volunteer-preview-image"
                         :style="`background-image:url(${preview.firstImage.image_base64})`"></div>
                </div>
                <div class="card__head-overlay font-white">
                    <div class="font-white">
                        <div class="stats"><span class="stats__num volunteer-preview-vacancy">{{preview.total_vacancies}}</span>
                            <span
                                class="stats__des openings-label">openings</span></div>
                    </div>
                </div>
            </div>
            <div class="card__body"><h2 class="card__title volunteer-preview-title">{{preview.title}}</h2>
                <div class="media-obj"><p class="body-txt body-txt--smaller body-txt--no-letter-space font-mid-grey"> by
                    <span class="bold volunteer-preview-creater-org">{{preview.organization}}</span></p></div>
                <div class="media-obj mt-16">
                    <div class="media-obj__asset"><i class="ico material-icons ico-calendar">event</i></div>
                    <div
                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space">
                        <span
                            class="volunteer-preview-start-date">{{getMonthsTextRange()}}</span>
                    </div>
                </div>
                <div class="media-obj mt-16">
                    <div class="media-obj__asset"><i class="ico ico--small material-icons">query_builder</i></div>
                    <div
                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space">
                        <span class="volunteer-preview-frequency volunteer-preview-start-time">{{preview.frequency}} on {{preview.days_of_week}}</span>
                        <br><span
                        class="font-mid-grey body-txt--small frequency_duration_view">{{ preview.duration}} hours per session</span>
                    </div>
                </div>
                <div class="media-obj mt-16">
                    <div class="media-obj__asset"><i class="ico ico--small material-icons">place</i></div>
                    <div
                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space volunteer-preview-town">
                        {{preview.town}}
                    </div>
                </div>
                <div class="media-obj mt-16">
                    <div class="media-obj__asset"><i class="ico ico--small material-icons">group</i></div>
                    <div
                        class="media-obj__main media-obj__main--small-spacing body-txt body-txt--small body-txt--no-letter-space volunteer-preview-suitability">
                        Suitable for: {{preview.suitable}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState, mapMutations, mapActions} from 'vuex'

    export default {
        name: "ActivityStepFive",
        props: {
            edit: {
                default: false,
            },
            visible: {
                default: false
            },
            finalData: {
                default: function () {
                    return {
                        formData: new FormData(),
                        volunteering: {},
                    }
                }
            },
            suitables: {
                default: function () {
                    return [];
                }
            }
        },
        data: () => ({
            ...mapGetters(['validated', 'succeeded']),
            preview: {
                title: '',
                organization: '',
                total_vacancies: 0,
                duration: 0,
                firstImage: {image_base64: `${baseUrl}/assets/images/user_profiles/logo.png`},
                town: '',
                months: 0,
                frequency: '',
                days_of_week: '',
                suitable: '',
            }

        }),
        computed: {
            ...mapState(['authUserInfo']),
        },
        watch: {
            visible: function (n) {
                if (n) {
                    this.setPreview()
                }
            }
        },
        methods: {
            ...mapActions([]),
            ...mapMutations(['setValidated']),
            setPreview() {
                let data = this.finalData.volunteering;
                this.preview.title = data.title;
                this.preview.firstImage = data.media.images[0];
                this.preview.organization = this.authUserInfo.name;
                this.preview.total_vacancies = 0;
                this.preview.suitable = '';
                let suitablesTexts = [];
                data.positions.map(i => {
                    this.preview.total_vacancies += parseInt(i.vacancies);
                    i.position_suitables.map(suitable => {
                        let mSuitable = this.suitables.filter((filter) => {
                            return filter.id === suitable;
                        }).map(i => i.name).join('');
                        if (suitablesTexts.indexOf(mSuitable) === -1) {
                            suitablesTexts.push(mSuitable);
                        }
                    })
                });
                this.preview.suitable = suitablesTexts.join(', ');
                this.preview.town = data.town;
                this.preview.duration = data.duration;
                this.preview.days_of_week = data.days_of_week.map(i => {
                    return i.toLowerCase()
                }).join(' or ');
                this.preview.frequency = this.getFrequency()[data.frequency];
                this.preview.months = this.getDiffMonths(data.commitment_from_date, data.commitment_to_date, 1)
            },
            getMonthsTextRange() {
                if (this.preview.months <= 1) {
                    return `1 Month`;
                } else {
                    return `1 - ${this.preview.months} Months`;
                }
            },
            getDiffMonths(date1, date2, includes = 0) {
                let months;
                date1 = new Date(date1);
                date2 = new Date(date2);
                months = (date2.getFullYear() - date1.getFullYear()) * 12 + (date2.getMonth() - date1.getMonth()) + includes;
                return months <= 0 ? 0 : months;
            },
            getFrequency() {
                return {
                    '1_DAY_PER_WEEK': 'One day per week',
                    '2_3_DAYS_PER_WEEK': '2-3 days per week',
                    'FORTNIGHTLY': 'Fortnightly',
                    'MONTHLY': 'Monthly',
                    'QUARTERLY': 'Quarterly',
                    'FLEXIBLE': 'Flexible',
                    'FULL_TIME': 'Full Time'
                }
            }
        },
    }
</script>

<style scoped>

</style>
