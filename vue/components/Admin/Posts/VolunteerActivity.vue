<template>
    <div>
        <Tabs :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas">
                    <div class="md-single-grid provider-list">
                        <!--Table card-->
                        <TablePaginate
                            v-model="query"
                            :searchPlaceholder="'Search by name, description'"
                            :showSearchButton="false"
                            :headers="headers"
                            :notFoundText="'Please make sure you type or spell information correctly.'"
                            :isSearch="isSearch"
                            :isLoading="validated().loading_searches"
                            :formTopState="formTopState"
                            @onItemPerPageClick="getItems"
                            @onSearchReLoadButtonClick="getItems"
                            @onSearchInputEnter="getItems"
                            @onSearchInputClose="getItems"
                            @onRemoveChipText="getItems"
                            :paginateData="paginate"
                            @onMenuContextClick="showModalAction"
                            @paginateNavigate="paginateNavigator">
                            <!--Slot Actions row context-->
                            <template slot-scope="{fireEvent, position, data}" slot="action-row-context">
                                <button
                                    @click="openVolunteeringTab(data.row.data.id)"
                                    class="v-md-button v-md-icon-button">
                                    <i class="material-icons v-icon">visibility</i>
                                </button>
                            </template>
                            <!--Slot Actions row context-->
                        </TablePaginate>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <!--info-->
        <AdminModal :isActive="modal.type==='info' && modal.active" @close="modal.active=false">
            <template slot="title"> {{modal.name}}</template>
            <div class="fb-dialog-body-section">
                <div v-html="modal.message"></div>
                <div>
                    <div class="form-label">Volunteer Activity Information</div>
                    <div class="form-input-static-value">
                        {{ `Name: ${modal.data.name}, Organize Name: ${modal.data.organize_name}`}}
                    </div>
                </div>
            </div>
            <template slot="actions">
                <button @click="positiveAction()" class="v-md-button primary"> {{modal.action.text}}</button>
            </template>
        </AdminModal>
        <!--info -->
        <!--warning-->
        <AdminModal :isActive="modal.type==='warning' && modal.active" @close="modal.active=false">
            <template slot="title">{{modal.name}}</template>
            <div class="fb-dialog-body-section">
                <div class="body-message-container has-icon is-warning">
                    <div class="inner">
                        <i class="material-icons m-icon">warning</i>
                        <div class="admin-modal-message">{{ modal.message }}</div>
                    </div>
                </div>
                <div>
                    <div class="form-label">Volunteer Activity Information</div>
                    <div class="form-input-static-value">
                        {{ `Name: ${modal.data.name}, Organize Name: ${modal.data.organize_name}`}}
                    </div>
                </div>
            </div>
            <template slot="actions">
                <button @click="positiveAction()" class="v-md-button warning">{{ modal.action.text }}</button>
            </template>
        </AdminModal>
        <!--warning -->
        <!--Modal -->
    </div>
</template>

<script>
    import AdminBase from "@bases/AdminBase.js";
    import {mapActions} from "vuex";

    export default AdminBase.extend({
        name: "VolunteerActivity",
        data: () => ({
            title: "ກິດຈະກໍາ",
            type: "volunteer_activities",
            watchers: true,
            tabs: [{name: "ກິດຈະກໍາທັງຫມົດ"}],
            headers: [
                {class: "th-sortable", name: "Name", width: "30%"},
                {class: "hide-xs th-sortable", name: "Organize Name", width: "25%"},
                {class: "th-sortable", name: "Status", width: "120"},
                {class: "hide-xs th-sortable", name: "Created", width: "20%"},
                {class: "th-not-sortable", name: "", width: "80"}
            ],
            models: {formTop: {imageSrc: null}},//override base data
        }),
        methods: {
            ...mapActions([
                "postChangeStatusVolunteerActivity",
                "postDeleteVolunteerActivity"
            ]),
            callbackBuildItem(data) {
                let contextMenu, activityStatus;
                contextMenu = [
                    {
                        name: 'Delete activity',
                        active: false,
                        type: 'warning',
                        message: `When you delete the volunteer activity, the volunteer activity will be permanently deleted and cannot be un-deleted.`,
                        action: {act: this.postDeleteVolunteerActivity, text: 'Delete'},
                        data: data,
                    }
                ];
                //set user status menu
                if (data.status === 'live') {
                    activityStatus = {
                        name: 'Cancel Activity',
                        active: false,
                        type: 'warning',
                        message: `Activity with cancelled cannot sign up.`,
                        action: {
                            act: this.postChangeStatusVolunteerActivity,
                            params: {status: 'cancel'},
                            text: 'Cancel'
                        },
                        data: data
                    };
                    contextMenu.splice(1, 0, activityStatus);//add item at second position

                    activityStatus = {
                        name: 'Close Activity',
                        active: false,
                        type: 'warning',
                        message: `Activity with closed cannot sign up.`,
                        action: {
                            act: this.postChangeStatusVolunteerActivity,
                            params: {status: 'close'},
                            text: 'Close'
                        },
                        data: data
                    }
                } else if (data.status === 'closed') {
                    activityStatus = {
                        name: 'Live Activity',
                        active: false,
                        type: 'info',
                        message: `<p>Activity with enabled cannot sign up.</p>`,
                        action: {
                            act: this.postChangeStatusVolunteerActivity,
                            params: {status: 'live'},
                            text: 'Live'
                        },
                        data: data

                    }
                } else if (data.status === 'cancelled') {
                    activityStatus = {
                        name: 'Live Activity',
                        active: false,
                        type: 'info',
                        message: `<p>Approve the activity then the user can sign up.</p>`,
                        action: {
                            act: this.postChangeStatusVolunteerActivity,
                            params: {status: 'live'},
                            text: 'Live'
                        },
                        data: data
                    }
                }
                //set status menu
                //add menu status
                if (activityStatus) {
                    contextMenu.splice(1, 0, activityStatus);//add item at second position
                }
                return {
                    rowContent: {
                        data: data,
                    },
                    rows: [
                        {data: data.name, type: "id", class: "user-email"},
                        {
                            data: data.organize_name,
                            type: "text",
                            class: "hide-xs"
                        },
                        {
                            data: this.$utils.firstUpper(data.status),
                            type: "text",
                            textColor: data.statusColor,
                        },
                        {
                            data: data.created_at,
                            type: "text",
                            class: "hide-xs"
                        },
                        {
                            data: data.email, type: 'action', class: '',
                            contextMenu
                        },
                    ]
                }
            },
            //positive action for modal buttons
            positiveAction() {
                this.modal.active = false; //close modal on positive button clicked
                let action = this.modal.action,
                    dt = 3500, //dt is toasted show length in time
                    data = {...this.modal.data, ...action.params};
                if (action.act) {
                    //@important action.act must non native functions
                    action.act({id: data.id, data})
                        .then(r => {
                            if (r.success) {
                                this.showInfoToast({msg: r.msg, dt});
                                this.getItems();
                            } else {
                                this.showErrorToast({msg: r.msg, dt});
                            }
                        })
                        .catch(e => {
                            this.showErrorToast({msg: 'The action failed!', dt});
                        });
                }
            },
            showModalAction(m) {
                m.active = true; //close modal on menu context clicked
                this.modal = m;
            },
            deleteItem(data) {
                data.modal.active = true;
                this.modal = data.modal;
            },
            openVolunteeringTab(id) {
                window.open("/posts/volunteer-activity/" + id)
            }
        },
        created() {
            this.getItems = this.debounce(this.getItems, 150);
            this.getItems();
        }
    });
</script>

