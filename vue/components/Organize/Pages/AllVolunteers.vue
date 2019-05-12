<template>
    <div>
        <main class="laogiving activity pad clearfix">

            <section class="page-top pt-40">
                <div class="cWidth-1200">
                    <button @click="Route({name: 'home', query: {active_page: 'our-volunteering' } })"
                            class="button-ctn font-bold button--with-icon button--no-bg button--large button--no-left-pad back-button">
                        <div class="button--with-icon__wrapper button--with-icon__wrapper"><i
                            class="ico material-icons button--with-icon__icon">keyboard_backspace</i> BACK
                        </div>
                    </button>
                    <h2 class="h3-tablet-landscape-up-h2 mt-24"><span class="mr-8">View All Volunteers</span></h2>
                    <div class="flex-ctn flex-ctn--dir-col-custom-768-up-row flex-ctn--just-spc-btw">
                        <div>
                            <div class="media-obj">
                                <div class="media-obj__main media-obj__main--small-spacing"></div>
                            </div>
                        </div>
                        <div class="mt-16-custom-768-up-0"></div>
                    </div>
                </div>

                <div class="cWidth-1200 company-profile__nav">
                    <nav class="hori-scroll-nav"></nav>
                </div>

            </section>

            <div class="ctn" id="manage-volunteer-contact">
                <div class="cWidth-1200 pt-40">
                    <div
                        class="flex-ctn flex-ctn--just-spc-btw flex-ctn--tablet-portrait-up-align-center flex-ctn--dir-col-tablet-portrait-up-row">
                        <div class="dbl-stats">
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats">1</div>
                                <div class="dbl-stats__desc">Volunteer Total</div>
                            </div>
                            <div class="dbl-stats__item">
                                <div class="dbl-stats__stats">0</div>
                                <div class="dbl-stats__desc">Leaders</div>
                            </div>
                        </div>
                    </div>
                    <hr class="hr">

                    <div class="flex-ctn flex-ctn--just-end flex-ctn--dir-col-rev-tablet-portrait-up-row">
                        <div class="flex-ctn flex-ctn--align-center" style="justify-content: flex-end;">
                            <div
                                class="select-btn select-btn--w-auto mr-0-tablet-portrait-up-16 mt-16-tablet-portrait-up-0">
                                <label class="mb-0 select-btn__lbl no-mrt"
                                       style="display: inline-block;width: auto;">
                                    <span class="select-btn__lbl-lbl mr-8 font-mid-grey body-txt">Sorted By</span>
                                </label>
                                <select name="" class="select-ctn select-btn__select select--small">
                                    <option data-order="asc" data-path=".volunteer-username" data-type="text"
                                            value="name">
                                        Name Asc
                                    </option>
                                    <option data-order="desc" data-path=".volunteer-username" data-type="text"
                                            value="name">
                                        Name Desc
                                    </option>
                                    <option data-order="asc" data-path=".volunteer-activities-no" data-type="number"
                                            value="number">No. Activities Asc
                                    </option>
                                    <option data-order="desc" data-path=".volunteer-activities-no" data-type="number"
                                            value="number">No. Activities Desc
                                    </option>
                                </select></div>
                        </div>
                        <div class="input-ctrl mb-0 w-211 ">
                            <input type="text" class="input-ctn input--h-36 input--icon"
                                   placeholder="Search volunteer name"> <i
                            class="ico material-icons input-ctrl__icon">search</i></div>
                    </div>

                    <table class="table-ctn res-tbl mt-16 volunteer-contact-list">
                        <thead>
                        <tr>
                            <th class="dark-grey">Name</th>
                            <th class="dark-grey">Contact</th>
                            <th class="dark-grey">No. of Activities</th>
                        </tr>
                        </thead>

                        <tbody> <!-- Start of for loop -->
                        <tr class="volunteer-contact-list-item data-list-item" style="display: table-row;">
                            <th>
                                <div class="media-obj">
                                    <div>
                                        <div class="body-txt volunteer-username name">Bee Organization</div>
                                        <span class="nric-name">Mr Bee Volunteer</span></div>
                                </div>
                            </th>
                            <td>
                                <div class="media-obj">
                                    <div class="body-txt">030984832</div>
                                </div>
                                <span class="block"><a href="javascript: void(0);" class="text-link text-link--blue">beeostin@gmail.com</a></span>
                            </td>
                            <td>
                                <div><span class="block p-top12"><strong
                                    class="number-of-activities volunteer-activities-no">1</strong> activity</span>
                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </table>

                    <div><p class="text-align-left-on-mobile mt-16">1-1 OF 1 VOLUNTEER</p>
                        <nav
                            class="flex-ctn flex-ctn--dir-col-rev-tablet-portrait-up-row mt-16-tablet-portrait-up-40 relative pagination-nav-bar">
                            <ul class="pagi mt-16-tablet-portrait-up-0">
                                <li class="pagi__item" data-role="page-prev">
                                    <a href="#1"><span
                                    class="ico ico-page-prev"></span></a>
                                </li>
                                <li class="pagi__item is-active" data-role="page-num">
                                    <a href="#">1</a>
                                </li>
                                <li class="pagi__item" data-role="page-next"><a href="#">
                                    <span
                                    class="ico ico-page-next"></span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>


        </main>
    </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/OrganizeBase.js";
    import {mapActions} from 'vuex'

    export default Base.extend({
        name: "Home",
        data: () => ({}),
        watch: {},
        methods: {},
        mounted() {
        },
        created() {
            this.setPageTitle(`All Volunteers`);
        }
    });
</script>


