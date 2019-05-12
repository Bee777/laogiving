<template>
    <div class="ctn">
        <div class="cWidth-1200 clearfix">
            <div class="grid-12 grid-tablet-landscape-up-4-last text-center">
                <button class="button-ctn button--ghost mt-24" @click="$emit('editProfileClicked')"
                        id="editProfileLink">EDIT PROFILE
                </button>
            </div>
        </div>
        <div class="cWidth-1200 clearfix">
            <section class="company-profile__body ctn clearfix">
                <div class="company-profile__main objectfit ">
                    <div class="swiper-arrow-wrap swiper-container-horizontal">
                        <div class="swiper-container--images swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img alt="" class="img-placeolder"
                                         src="https://www.giving.sg/image/logo?img_id=6080036">
                                </div>
                                <div class="swiper-slide">
                                    <img alt="" class="img-placeolder"
                                         src="https://www.giving.sg/image/logo?img_id=9040323">
                                </div>
                            </div>
                            <div class="swiper-button-prev rotage"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <div class="swiper-pagination swiper-pagination-bullets"><span
                            class="swiper-pagination-bullet swiper-pagination-bullet-active"></span></div>
                    </div>
                </div>
                <div class="company-profile__donate">
                    <div class="accordion-card">
                        <div class="accordion-card__head">
                            <h6 class="h6">VISION &amp;
                                MISSION</h6>
                            <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                            <div class="accordion-card__hitarea"></div>
                        </div>
                        <div class="accordion-card__body"><p>NNI is the national
                            specialist centre and regional centre for clinical referrals for the management and
                            treatment of the neurosciences.</p></div>
                    </div>
                </div>
                <div class="company-profile__options">
                    <div class="company-profile__description">

                        <div class="accordion-card accordion-card--borderless">
                            <div class="accordion-card__head"><h3 class="h3">About
                                Us</h3> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div class="body-txt break-word"> National Neuroscience Institute (NNI) is the
                                    national specialist centre and regional centre for clinical referrals for
                                    the management and treatment of the neurosciences, as well as for education
                                    and research conducted in the field. <br><br>Offering a comprehensive range
                                    of Neurology, Neurosurgery and Neuroradiology services using the latest
                                    technology and experience of our healthcare professionals, NNI is at the
                                    forefront of neuroscience care in Singapore and across the region. <br><br>NNI
                                    operates directly from two campuses; Tan Tock Seng Hospital and Singapore
                                    General Hospital (SGH), as well as provides specialty services to most other
                                    hospitals in Singapore. <br><br>We are a member of the SingHealth (Singapore
                                    Health Services) Group, an integrated healthcare delivery network which
                                    offers a complete range of multi-disciplinary and integrated medical care.
                                    The Group comprises hospitals, national specialty centres and a network of
                                    polyclinics.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-card accordion-card--borderless">
                            <div class="accordion-card__head"><h3 class="h3">Our
                                Programmes</h3> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                                <div class="accordion-card__hitarea"></div>
                            </div>
                            <div class="accordion-card__body">
                                <div class="body-txt break-word"> Our
                                    programmes are centered around our 3 pillars - Education, Research and
                                    Clinical Services. We believe strongly in patients at the heart of all we
                                    do. Find out more at www.nni.com.sg today!
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="company-profile__causes-contact">
                    <div class="accordion-card">
                        <div class="accordion-card__head"><h6 class="h6">SUPPORTED
                            CAUSES</h6> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                            <div class="accordion-card__hitarea"></div>
                        </div>
                        <div class="accordion-card__body">
                            <ul class="list list--spacing">
                                <li><i
                                    style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-community.svg');"
                                    class="ico ico--medium ico-community mr-8"></i>Community
                                </li>
                                <li><i
                                    style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-education.svg');"
                                    class="ico ico--medium ico-education mr-8"></i>Education
                                </li>
                                <li><i
                                    style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-elderly.svg');"
                                    class="ico ico--medium ico-elderly mr-8"></i>Elderly
                                </li>
                                <li><i
                                    style="background-image: url('https://www.giving.sg/givingsg-theme/images/mt/ic-health.svg');"
                                    class="ico ico--medium ico-health mr-8"></i>Health
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="accordion-card mt-16">
                        <div class="accordion-card__head"><h6 class="h6">CONTACT
                            US</h6> <i class="material-icons accordion-card__chevron">keyboard_arrow_up</i>
                            <div class="accordion-card__hitarea"></div>
                        </div>
                        <div class="accordion-card__body">
                            <div><h4 style="margin-bottom:10px">Volunteer Co-ordinator</h4>
                                <p class="body-txt">National Neuroscience Institute</p></div>
                            <div class="mb-16"><i class="ico material-icons gray mr-6">call</i>
                                <a href="tel:63577095"
                                   class="text-link text-link--dark-grey">63577095</a>
                            </div>
                            <div class="mb-16">
                                <i class="ico material-icons gray mr-6">email</i>
                                <a
                                    class="text-link text-link--dark-grey" href="mailto:giving@nni.com.sg">giving@nni.com.sg</a>
                            </div>
                            <div class="mb-16">
                                <i class="ico material-icons gray mr-6">public</i>
                                <a
                                    href="http://www.giving.sg" class="text-link text-link--dark-grey"
                                    target="_blank">www.giving.sg</a></div>
                        </div>
                    </div>

                    <div class="text-center mb-16">
                        <a id="report-abuse-button" class="text-link"><i
                            class="ico  material-icons ico-flag mr-8">outlined_flag</i>Report
                            abuse</a>
                    </div>

                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OrganizeProfile",
        methods: {
            initCarousel() {
              new Swiper('.swiper-container', {
                    loop: true,
                    // Navigation arrows
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    spaceBetween: 10,
                })
            },
        },
        mounted() {
            this.initCarousel();
        },
    }
</script>

<style scoped>

</style>
