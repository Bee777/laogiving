<template>
    <div>
        <Tabs :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas">
                    <div class="md-single-grid provider-list">
                        <!--Table card-->
                        <TablePaginate v-model="query"
                                       :searchPlaceholder="'Search by skill name'"
                                       :searchButtonText="'Add Skill'"
                                       :headers="headers"
                                       :notFoundText="'Please make sure you type or spell the skill information correctly.'"
                                       :isSearch="isSearch"
                                       :isLoading="validated().loading_searches"
                                       :formTopState="formTopState"
                                       @onItemPerPageClick="getItems"
                                       @onSearchActionButton="toggleFormTop(true)"
                                       @onSearchReLoadButtonClick="getItems"
                                       @onSearchInputEnter="getItems"
                                       @onSearchInputClose="getItems"
                                       @onRemoveChipText="getItems"
                                       :paginateData="paginate"
                                       @paginateNavigate="paginateNavigator">
                            <!--Slot Form Top -->
                            <template slot="form-top" v-if="formTopState.show">
                                <form class="admin-form-card user-form" @submit.prevent>
                                    <div class="user-form-title"> Create new skill</div>
                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput v-model="models.formTop.name"
                                                    :focus="true"
                                                    :validateText="validated().name"
                                                    :label="'Skill Name'"
                                                    :inputType="'text'"
                                                    @onInputEnter="addItem"/>
                                    </div>

                                    <div class="user-form-action layout-align-end-center layout-row">
                                        <button @click="toggleFormTop(false)"
                                                class="v-md-button secondary theme-blue">
                                            Cancel
                                        </button>
                                        <button @click="addItem" class="v-md-button primary theme-blue"> Create
                                        </button>
                                    </div>
                                </form>
                            </template>
                            <!--Slot Form Top -->
                            <!--Slot Actions row -->
                            <template slot-scope="{fireEvent, position, data}" slot="action-row">
                                <button @click="toggleFormRowContent(fireEvent, position, {active: true})"
                                        class="v-md-button v-md-icon-button"><i
                                    class="material-icons v-icon">edit</i></button>
                                <button @click="deleteItem(data.column)" class="v-md-button v-md-icon-button"><i
                                    class="material-icons v-icon">delete</i></button>
                            </template>
                            <!--Slot Actions row-->
                            <!--Slot Row Detail Content-->
                            <template slot-scope="{fireEvent, position, rowContent}" slot="form-row-detail">
                                <AdminInput v-model="rowContent.data.name" class="provider-edit-inset-content"
                                            :validateText="rowContent.validated.skill_name"
                                            :label="'Category Name'"
                                            :inputType="'text'"
                                            @onInputEnter="editItem(fireEvent, rowContent.data, position)"/>

                                <div class="user-form-action provider-list-actions layout-align-end-center layout-row">
                                    <button
                                        @click="toggleFormRowContent(fireEvent, position, {active: false})"
                                        class="v-md-button secondary theme-blue">
                                        Cancel
                                    </button>
                                    <button @click="editItem(fireEvent, rowContent.data, position)"
                                            class="v-md-button primary theme-blue">
                                        Save
                                    </button>
                                </div>
                            </template>
                            <!--Slot Row Detail Content-->
                        </TablePaginate>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <!--warning-->
        <AdminModal :isActive="modal.type==='warning' && modal.active" @close="modal.active=false">
            <template slot="title"> {{modal.name}}</template>
            <div class="fb-dialog-body-section">
                <div class="body-message-container has-icon is-warning">
                    <div class="inner">
                        <i class="material-icons m-icon">warning</i>
                        <div class="admin-modal-message">{{ modal.message }}</div>
                    </div>
                </div>
                <div>
                    <div class="form-label"> Skill Name</div>
                    <div class="form-input-static-value"> {{ modal.data.name }}</div>
                </div>
            </div>
            <template slot="actions">
                <button @click="positiveAction()" class="v-md-button warning"> {{ modal.action.text }}</button>
            </template>
        </AdminModal>
        <!--warning -->
        <!--Modal -->
    </div>
</template>

<script>

    import AdminBase from '@bases/AdminBase.js'
    import {mapActions} from 'vuex'

    export default AdminBase.extend({
        name: "Skill",
        data: () => ({
            title: 'ຂໍ້ມູນຄວາມຊໍານານ',
            type: 'skills',
            watchers: true,
            tabs: [{name: 'Skill'}],
            headers: [
                {class: 'th-sortable', name: 'Skill Name', width: '45%'},
                {class: 'hide-xs th-sortable', name: 'Created At', width: '28%'},
                {class: 'hide-xs th-sortable', name: 'Updated At', width: '28%'},
                {class: 'th-not-sortable', name: '', width: '80'},
            ],
            models: {formTop: {name: ''}},
        }),
        methods: {
            ...mapActions(['postCreateSkill', 'postUpdateSkill', 'postDeleteSkill']),
            callbackBuildItem(data) {
                return {
                    rowContent: {
                        validated: {},
                        state: {active: false, loading: false},
                        originData: this.$utils.clone(data), //clone to separate data for object
                        data: data,
                        wholeEdit: true
                    },
                    rows: [
                        {data: data.name, type: 'id', class: 'user-email'},
                        {data: this.$utils.formatTimestmp(data.created_at), type: 'text', class: 'hide-xs'},
                        {data: this.$utils.formatTimestmp(data.updated_at), type: 'text', class: 'hide-xs'},
                        {
                            data: data.name, type: 'action', class: '',
                            modal: {
                                name: 'Delete Skill',
                                active: false,
                                type: 'warning',
                                message: `When you delete the skill, the skill will be permanently deleted and cannot be un-deleted.`,
                                action: {act: this.postDeleteSkill, text: 'Delete'},
                                data: data,
                            }
                        },
                    ]
                }
            },
            //positive action for modal buttons
            positiveAction() {
                this.modal.active = false;//close modal on positive button clicked
                let action = this.modal.action, dt = 3500, //dt is toasted show length in time
                    data = this.modal.data; //set data from modal
                if (action.act) {//@important action.act must non native functions
                    action.act({id: data.id})
                        .then(r => {
                            if (r.success) {
                                this.showInfoToast({msg: 'The Skill was deleted!', dt});
                                this.getItems();
                            } else {
                                this.showErrorToast({msg: 'Failed to delete the skill!', dt});
                            }
                        })
                        .catch(e => {
                            this.showErrorToast({msg: 'Failed to delete the skill!', dt});
                        });
                }
            },
            addItem() {
                let ft = this.formTopState;
                ft.loading = true;
                this.postCreateSkill(this.models.formTop)
                    .then(r => {
                        if (r.success) {
                            this.getItems();
                            ft.show = false;
                            this.models.formTop = {};
                        }
                        ft.loading = false;
                    })
                    .catch(e => {
                        ft.loading = false;
                    })
            },
            editItem(fireEvent, data, position) {
                let dt = 3500, v = this.paginate.items[position.row].rowContent;
                data.category_name = data.name;
                this.toggleFormRowContent(fireEvent, position, this.Event.loadingState().ActiveLoading);
                this.postUpdateSkill(data)
                    .then(r => {
                        if (r.success) {
                            this.showInfoToast({msg: 'The skill was updated!', dt});
                            this.getItems();
                        } else {
                            this.showErrorToast({msg: 'Failed to update the skill!', dt});
                        }
                        this.toggleFormRowContent(fireEvent, position, this.Event.loadingState().NorActiveLoading);
                    })
                    .catch(err => {
                        v.validated = {};
                        if ((err && err.errors) || (err.response && err.response.data && err.response.data.errors)) {
                            this.toggleFormRowContent(fireEvent, position, this.Event.loadingState().ActiveNotLoading);
                            v.validated = this.validated();
                        } else {
                            this.toggleFormRowContent(fireEvent, position, this.Event.loadingState().NorActiveLoading);
                            this.showErrorToast({msg: 'Failed to update the skill!', dt});
                        }
                    });
            },
            deleteItem(data) {
                data.modal.active = true;
                this.modal = data.modal;
            }
        },
        created() {
            this.getItems = this.debounce(this.getItems, 150);
            this.getItems();
        }
    })
</script>
