<template>
    <div class="app-sidebar">
        <div class="nav">
            <button @click="GoToHomePage()" class="button v-md-button app-sidebar-left-top-menu flex-left">
                <div class="app-sidebar-logo-lockup">
                    <img
                        class="app-sidebar-logo-lockup-icon"
                        :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                        alt="Admin Icon Logo"
                    >
                    <!--   src="https://www.gstatic.com/mobilesdk/160503_mobilesdk/logo/2x/firebase_28dp.png"-->
                    <img
                        class="app-sidebar-logo-lockup-logotype logotype-white"
                        :src="`${baseUrl}/assets/images/admin-logo.svg${s.fresh_version}`"
                        alt="Admin Text Logo"
                    >
                    <!--
                    src="//www.gstatic.com/mobilesdk/160323_mobilesdk/images/firebase_logotype_white_18dp.svg"-->
                </div>
            </button>
            <div class="app-sidebar-container-nav">
                <div class="app-sidebar-content-container-root side-group">
                    <div class="app-sidebar-overview">
                        <a
                            class="app-sidebar-item"
                            @click="GoToOverview"
                            :class="[{'selected-entry' : $route.name==='dashboard'}]"
                        >
                            <div class="app-sidebar-item-lockup">
                                <i class="material-icons selected-icon">home</i>
                                <span class="app-sidebar-entry-displayname">Overview</span>
                            </div>
                        </a>
                    </div>

                    <div @click="GoToSiteSetting" class="app-sidebar-item-settings">
                        <button class="button v-md-button v-md-icon-button app-sidebar-item-settings-button">
                            <i class="material-icons app-sidebar-item-settings-icon">settings</i>
                            <i class="material-icons app-sidebar-item-settings-arrow-icon">arrow_drop_down</i>
                        </button>
                    </div>

                    <div @click="GoToSiteSetting" class="app-sidebar-item-settings-collapsed">
                        <button class="button v-md-button app-sidebar-item-settings-button">
                            <i class="material-icons app-sidebar-item-settings-icon">settings</i>
                            <i class="material-icons app-sidebar-item-settings-arrow-icon">arrow_drop_down</i>
                        </button>
                    </div>
                </div>
                <!--@Start Sidebar content menu-->
                <div class="sidebar-tree">
                    <SidebarItem
                        @onItemClick="itemAction"
                        v-for="(side, index) in sideItems"
                        :contentHeader="side.contentHeader"
                        :items="side.items"
                        :key="index"
                    />
                </div>
                <!--@End Sidebar content menu-->
            </div>
            <!--@Start Footer Sidebar -->
            <button @click="setSidebarCollapsed" class="button v-md-button app-sidebar-item-expando">
                <i class="material-icons">chevron_left</i>
            </button>

            <button class="button v-md-button app-sidebar-item-expando is-mobile"></button>
            <!--@End Footer Sidebar -->
        </div>
    </div>
</template>

<script>
    import {mapMutations, mapActions, mapState} from "vuex";
    import SidebarItem from "@com/Admin/Default/SidebarItem.vue";

    export default {
        name: "sidebar",
        data() {
            return {
                sideItems: [
                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນຜູ້ໃຊ້",
                            description: "ຈັດການຂໍ້ມູນຜູ້ໃຊ້, ການອະນຸຍາດຜຸູ້ໃຊ້, ການຄົ້ນຫາ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ອາສາສະຫມັກ", //required
                                icon: "group", //required
                                action: this.Route, //required
                                params: {name: "volunteer"} //required
                            },
                            {
                                name: "ອົງກອນ ຫລື ກຸ່ມ",
                                icon: "business", //required
                                action: this.Route, //required
                                params: {name: "organize"} //required
                            }
                        ]
                    },
                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນກິດຈະກໍາ",
                            description: "ຈັດການຂໍ້ມູນກິດຈະກໍາ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            // {
                            //     name: "ສ້າງກິດຈະກໍາ", //required
                            //     icon: "add_circle", //required
                            //     action: this.Route, //required
                            //     params: {name: "create-activity"} //required
                            // },
                            {
                                name: "ກິດຈະກໍາ", //required
                                icon: "list_alt", //required
                                action: this.Route, //required
                                params: {name: "activities"} //required
                            },
                            {
                                name: "ປະເພດກິດຈະກໍາ", //required
                                icon: "category", //required
                                action: this.Route, //required
                                params: {name: "causes"} //required
                            },
                            {
                                name: "ຂໍ້ມູນຄວາມຊໍານານ", //required
                                icon: "equalizer", //required
                                action: this.Route, //required
                                params: {name: "skill"} //required
                            },
                            {
                                name: "ຂໍ້ມູນຄວາມເຫມາະສົມ", //required
                                icon: "streetview", //required
                                action: this.Route, //required
                                params: {name: "suitable"} //required
                            },
                        ]
                    },
                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນຂ່າວສານຕ່າງໆ",
                            description: "ຈັດການຂໍ້ມູນຂ່າວສານຕ່າງໆ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ຂ່າວສານ", //required
                                icon: "rss_feed", //required
                                action: this.Route, //required
                                params: {name: "news"} //required
                            },
                        ]
                    },
                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນເວັບໄຊ",
                            description: "ຈັດການຂໍ້ມູນຂ່າວ.",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ຂໍ້ມູນເວັບ ແລະ ແບຣນເນີ້", //required
                                icon: "settings", //required
                                action: this.Route, //required
                                params: {name: "site-setting"} //required
                            },
                            {
                                name: "ຂໍ້ມູນກ່ຽວກັບ", //required
                                icon: "business", //required
                                action: this.Route, //required
                                params: {name: "about"} //required
                            },
                            {
                                name: "ຂໍ້ມູນຕິດຕໍ່", //required
                                icon: "call", //required
                                action: this.Route, //required
                                params: {name: "contact-info"} //required
                            },
                        ]
                    }
                ]
            };
        },
        components: {
            SidebarItem
        },
        methods: {
            ...mapActions([]),
            ...mapMutations(["setSidebarCollapsed", "setSelectedSidebarItem"]),
            itemAction(i) {
                if (i.action) {
                    i.action(i.params);
                }
            },
            routeActions(data) {
                this.Route({name: data.params.name});
                this.setSelectedSidebarItem(data);
            },
            GoToOverview() {
                let i = {name: "Dashboard", params: {name: "dashboard"}};
                this.routeActions(i);
            },
            GoToSiteSetting() {
                let i = {name: 'Site Setting', params: {name: 'sitesetting'}};
                this.routeActions(i);
            },
            GoToHomePage() {
                this.$utils.Location('/');
            }
        }
    };
</script>

<style scoped>
</style>
