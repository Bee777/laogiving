<template>
    <div>
        <Tabs :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas">
                    <div class="md-single-grid provider-list">
                        <!--Table card-->
                        <TablePaginate v-model="query"
                                       :searchPlaceholder="'Search by category name'"
                                       :searchButtonText="'Add Category'"
                                       :headers="headers"
                                       :notFoundText="'Please make sure you type or spell the category information correctly.'"
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
                                    <div class="user-form-title"> Create new category</div>
                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput v-model="models.formTop.name"
                                                    :focus="true"
                                                    :validateText="validated().name"
                                                    :label="'Category Name'"
                                                    :inputType="'text'"
                                                    @onInputEnter="addItem"/>
                                    </div>

                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput
                                            @inputImageBase64="(d)=> models.formTop.imageSrc=d"
                                            @inputFile="(d)=> models.formTop.icon=d"
                                            :validateText="validated().icon"
                                            :label="'Feature Icon'"
                                            :inputType="'file'"
                                            placeholder="Choose icon"
                                        ></AdminInput>
                                    </div>
                                    <div v-if="models.formTop.imageSrc"
                                         class="layout-align-space-around-start layout-row">
                                        <div class="box">
                                            <div class="media-centered">
                                                <figure class="image is-128x128">
                                                    <img :src="models.formTop.imageSrc">
                                                </figure>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput
                                            @inputImageBase64="(d)=> models.formTop.smallSrc=d"
                                            @inputFile="(d)=> models.formTop.small_icon=d"
                                            :validateText="validated().small_icon"
                                            :label="'Feature Small Icon'"
                                            :inputType="'file'"
                                            placeholder="Choose icon"
                                        ></AdminInput>
                                    </div>
                                    <div v-if="models.formTop.smallSrc"
                                         class="layout-align-space-around-start layout-row">
                                        <div class="box">
                                            <div class="media-centered">
                                                <figure class="image is-128x128">
                                                    <img :src="models.formTop.smallSrc">
                                                </figure>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput
                                            @inputImageBase64="(d)=> models.formTop.bgSrc=d"
                                            @inputFile="(d)=> models.formTop.background_image=d"
                                            :validateText="validated().background_image"
                                            :label="'Background Image'"
                                            :inputType="'file'"
                                            placeholder="Choose background image"
                                        ></AdminInput>
                                    </div>
                                    <div v-if="models.formTop.bgSrc"
                                         class="layout-align-space-around-start layout-row">
                                        <div class="box">
                                            <div class="media-centered">
                                                <figure class="image is-128x128">
                                                    <img :src="models.formTop.bgSrc">
                                                </figure>
                                            </div>
                                        </div>
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
                                <AdminInput v-model="rowContent.data.name"
                                            :validateText="rowContent.validated.category_name"
                                            :label="'Category Name'"
                                            :inputType="'text'"
                                            @onInputEnter="editItem(fireEvent, rowContent.data, position)"/>

                                <div class="layout-align-space-around-start layout-row">
                                    <AdminInput
                                        v-model="rowContent.data.filename"
                                        @inputImageBase64="(d)=> rowContent.options.imageSrc=d"
                                        @inputFile="(d) => rowContent.data.icon = d"
                                        :label="'Feature Image'"
                                        :validateText="rowContent.validated.icon"
                                        :inputType="'file'"
                                        placeholder="Choose icon"
                                        @onInputEnter="editNews(fireEvent, rowContent.data, position)"
                                    />
                                </div>
                                <div class="layout-align-space-around-start layout-row">
                                    <div class="box">
                                        <div class="media-centered">
                                            <figure class="image is-128x128">
                                                <img v-if="rowContent.options.imageSrc"
                                                     :src="rowContent.options.imageSrc">
                                            </figure>
                                        </div>
                                    </div>
                                </div>

                                <div class="layout-align-space-around-start layout-row">
                                    <AdminInput
                                        v-model="rowContent.data.filename_small"
                                        @inputImageBase64="(d)=> rowContent.options.smallSrc=d"
                                        @inputFile="(d) => rowContent.data.small_icon = d"
                                        :label="'Feature Small Icon'"
                                        :validateText="rowContent.validated.small_icon"
                                        :inputType="'file'"
                                        placeholder="Choose small icon"
                                        @onInputEnter="editNews(fireEvent, rowContent.data, position)"
                                    />
                                </div>
                                <div class="layout-align-space-around-start layout-row">
                                    <div class="box">
                                        <div class="media-centered">
                                            <figure class="image is-128x128">
                                                <img v-if="rowContent.options.smallSrc"
                                                     :src="rowContent.options.smallSrc">
                                            </figure>
                                        </div>
                                    </div>
                                </div>


                                <div class="layout-align-space-around-start layout-row">
                                    <AdminInput
                                        v-model="rowContent.data.filename_bg"
                                        @inputImageBase64="(d)=> rowContent.options.bgSrc=d"
                                        @inputFile="(d) => rowContent.data.background_image = d"
                                        :label="'Background Image'"
                                        :validateText="rowContent.validated.background_image"
                                        :inputType="'file'"
                                        placeholder="Choose background image"
                                        @onInputEnter="editNews(fireEvent, rowContent.data, position)"
                                    />
                                </div>
                                <div class="layout-align-space-around-start layout-row">
                                    <div class="box">
                                        <div class="media-centered">
                                            <figure class="image is-128x128">
                                                <img v-if="rowContent.options.bgSrc"
                                                     :src="rowContent.options.bgSrc">
                                            </figure>
                                        </div>
                                    </div>
                                </div>


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
                    <div class="form-label"> Category Name</div>
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
        name: "Causes",
        data: () => ({
            title: 'ປະເພດກິດຈະກໍາ',
            type: 'causes',
            watchers: true,
            tabs: [{name: 'Category'}],
            headers: [
                {class: 'th-sortable', name: 'Category Name', width: '30%'},
                {class: "hide-xs th-sortable", name: "Icon", width: "10%"},
                {class: "hide-xs th-sortable", name: "Small Icon", width: "10%"},
                {class: "hide-xs th-sortable", name: "Bg Image", width: "10%"},
                {class: 'hide-xs th-sortable', name: 'Created At', width: '28%'},
                {class: 'hide-xs th-sortable', name: 'Updated At', width: '28%'},
                {class: 'th-not-sortable', name: '', width: '80'},
            ],
            models: {
                formTop: {
                    name: '',
                    imageSrc: null, icon: null,
                    smallSrc: null, small_icon: null,
                    bgSrc: null, background_image: null
                }
            },
        }),
        methods: {
            ...mapActions(['postCreateCategory', 'postUpdateCategory', 'postDeleteCategory']),
            callbackBuildItem(data) {
                //options data
                data.options = {
                    smallSrc: `${this.baseUrl}${data.small_icon}`,
                    imageSrc: `${this.baseUrl}${data.icon}`,
                    bgSrc: `${this.baseUrl}${data.background_image}`
                };
                //options data
                return {
                    rowContent: {
                        validated: {},
                        state: {active: false, loading: false},
                        originData: this.$utils.clone(data), //clone to separate data for object
                        options: this.$utils.clone(data.options),
                        data: data,
                        wholeEdit: true
                    },
                    rows: [
                        {data: data.name, type: 'id', class: 'user-email'},
                        {
                            data: `${this.baseUrl}${data.icon}`,
                            type: "image",
                            class: "hide-xs"
                        },
                        {
                            data: `${this.baseUrl}${data.small_icon}`,
                            type: "image",
                            class: "hide-xs"
                        },
                        {
                            data: `${this.baseUrl}${data.background_image}`,
                            type: "image",
                            class: "hide-xs"
                        },
                        {data: this.$utils.formatTimestmp(data.created_at), type: 'text', class: 'hide-xs'},
                        {data: this.$utils.formatTimestmp(data.updated_at), type: 'text', class: 'hide-xs'},
                        {
                            data: data.name, type: 'action', class: '',
                            modal: {
                                name: 'Delete Category',
                                active: false,
                                type: 'warning',
                                message: `When you delete the category, the category will be permanently deleted and cannot be un-deleted.`,
                                action: {act: this.postDeleteCategory, text: 'Delete'},
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
                                this.showInfoToast({msg: 'The Category was deleted!', dt});
                                this.getItems();
                            } else {
                                this.showErrorToast({msg: 'Failed to delete the category!', dt});
                            }
                        })
                        .catch(e => {
                            this.showErrorToast({msg: 'Failed to delete the category!', dt});
                        });
                }
            },
            addItem() {
                let ft = this.formTopState;
                ft.loading = true;
                this.postCreateCategory(this.models.formTop)
                    .then(r => {
                        if (r.success) {
                            this.getItems();
                            ft.show = false;
                            this.models.formTop = {
                                name: '',
                                imageSrc: null, icon: null,
                                smallSrc: null, small_icon: null,
                                bgSrc: null, background_image: null
                            };
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
                this.postUpdateCategory(data)
                    .then(r => {
                        if (r.success) {
                            this.showInfoToast({msg: 'The category was updated!', dt});
                            this.getItems();
                        } else {
                            this.showErrorToast({msg: 'Failed to update the category!', dt});
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
                            this.showErrorToast({msg: 'Failed to update the category!', dt});
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
