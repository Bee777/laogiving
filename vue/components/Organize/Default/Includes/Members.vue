<template>
    <div class="cWidth-1200 pt-16-custom-1024-up-0 clearfix">
        <div class="volunteer-admin__container" id="my-volunteer-activities">
            <div
                class="grid-12 grid-custom-1024-up-3 mt-0-custom-1024-up-114">
                <div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">
                    <div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span
                        class="nav-acdr__title">All Members</span> <span
                        class="nav-acdr__stats live-count">1</span></div>
                    <div class="nav-acdr__body">
                        <div class="nav-acdr__grp nav-acdr__grp--single">
                            <div class="radio-filters radio-filters--blk"><label
                                class="radio-filters__lbl">
                                <input type="radio" checked=""
                                       name="categories"
                                       class="radio-filters__radio" value="LIVE">
                                <span class="radio-filters__text-left">All Members</span>
                                <span class="radio-filters__text-right live-count">1</span>
                                <div class="radio-filters--blk__hilite"></div>
                            </label>
                            </div>
                        </div>

                        <div class="nav-acdr__grp by-roles">
                            <div class="nav-acdr__grp-title">ROLES</div>

                            <div class="radio-filters radio-filters--blk">
                                <label class="radio-filters__lbl">
                                    <input type="radio" name="categories" class="radio-filters__radio">
                                    <span class="radio-filters__text-left" data-no-item="You have no Volunteer Leader">Volunteer Leader</span>
                                    <span class="radio-filters__text-right">0</span>
                                    <div class="radio-filters--blk__hilite"></div>
                                </label>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="grid-12 grid-custom-1024-up-9-last">
                <div class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--just-spc-btw mt-40 mb-24">
                    <button style="padding: 0;"
                            class="button-ctn button--with-icon button--no-bg button--no-left-pad"></button>
                    <div class="search-result__field-right input-ctrl mb-0"><input
                        type="text" class="input-ctn input--icon input--bold input--h-40"
                        placeholder="Search all users">
                        <i class="ico material-icons input-ctrl__icon">search</i>
                    </div>
                </div>

                <div id="item-list">
                    <div v-for="i in 3" :key="i"
                        class="flex-ctn flex-ctn--dir-col-tablet-portrait-up-row flex-ctn--border-grey-rounded-corners flex-ctn--just-spc-btw">
                        <div class="media-obj">
                            <div class="media-obj__asset">
                                <img class="profile-pic profile-pic--small-all"
                                     src="https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg">
                            </div>
                            <div class="media-obj__main">
                                <h4 class="h4 mt-0 body-txt font-dark-grey mb-0">Bee Organization</h4>
                                <p class=" mb-0">beeostin@gmail.com</p>
                                <div class="ribbon--container">
                                    <div class="ribbon ribbon--role">Community-based Group Admin</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Members",
        data: () => ({
            toggleRadio: false,
        })
    }
</script>

<style scoped>

</style>
