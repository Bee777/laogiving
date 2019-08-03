<template>
    <div class="ctn gallery gallery-tablet-portrait-up-6 clearfix"
         :id="`orgTagsSelection-${_uid}`">

        <ul v-if="chunkSize <= 0" class="gallery__item checkbox-list">
            <li v-for="(item, idx) in items" :key="idx">
                <label class="checkbox-list__checkbox">
                    <input type="checkbox"
                           v-model="mSelected"
                           name="causeBox[]"
                           :value="item.id">
                    <div class="checkbox-list__lbl-spn">{{item.name}}</div>
                </label>
            </li>
        </ul>

        <ul v-else class="gallery__item checkbox-list" v-for="(p, idx) in chunked" :key="idx">
            <li v-for="(item, jdx) in p" :key="jdx">
                <label class="checkbox-list__checkbox">
                    <input type="checkbox"
                           v-model="mSelected"
                           name="causeBox[]"
                           :value="item.id">
                    <div class="checkbox-list__lbl-spn">{{item.name}}</div>
                </label>
            </li>
        </ul>
        <div class="clearfix"></div>
        <div class="controls clearfix">
            <label class="help-block error-msg" id="causes-error" style="display: block;">{{msg}}</label></div>


        <!--<ul class="checkbox-list mt-16">-->
            <!--<li><label class="checkbox-list__checkbox">-->
                <!--<input class="position-suitability"-->
                       <!--data-info="First Timers"-->
                       <!--name="position_suitabilities"-->
                       <!--id="position_suitabilities_1638419"-->
                       <!--type="checkbox" value="1638419">-->
                <!--<div class="checkbox-list__lbl-spn">First Timers</div>-->
            <!--</label></li>-->
            <!--<li id="yui_patched_v3_11_0_1_1557583322558_1863">-->
                <!--<label class="checkbox-list__checkbox">-->
                    <!--<input class="position-suitability"-->
                           <!--name="position_suitabilities"-->
                           <!--type="checkbox" value="1638420">-->
                    <!--<div class="checkbox-list__lbl-spn">-->
                        <!--Seniors-->
                    <!--</div>-->
                <!--</label></li>-->
            <!--<li>-->
                <!--<label class="checkbox-list__checkbox">-->
                    <!--<input class="position-suitability" data-info="Open to All"-->
                           <!--name="position_suitabilities"-->
                           <!--type="checkbox" value="1638421">-->
                    <!--<div class="checkbox-list__lbl-spn">-->
                        <!--Open to All-->
                    <!--</div>-->
                <!--</label></li>-->
            <!--<li><label class="checkbox-list__checkbox">-->
                <!--<input class="position-suitability"-->
                       <!--name="position_suitabilities"-->
                       <!--type="checkbox" value="1638422">-->
                <!--<div class="checkbox-list__lbl-spn">-->
                    <!--Family Friendly-->
                <!--</div>-->
            <!--</label></li>-->
            <!--<li><label class="checkbox-list__checkbox">-->
                <!--<input class="position-suitability"-->
                       <!--name="position_suitabilities"-->
                       <!--type="checkbox" value="1638423">-->
                <!--<div class="checkbox-list__lbl-spn">Organisation or Groups</div>-->
            <!--</label></li>-->
        <!--</ul>-->


    </div>
</template>

<script>
    export default {
        name: "Tags",
        props: {
            chunkSize: {
                default: 8
            },
            value: {
                default: function () {
                    return [];
                }
            },
            items: {
                default: function () {
                    return [];
                }
            },
            max: {
                default: null,
            }
        },
        data: () => ({
            mSelected: [],
            msg: '',
        }),
        watch: {
            mSelected: function () {
                this.emit();
            }
        },
        computed: {
            chunked() {
                return this.$utils.chunkArray(this.items, this.chunkSize);
            }
        },
        methods: {
            emit() {
                if (this.max && this.max < this.mSelected.length) {
                    this.msg = `Please select up to ${this.max} items.`;
                    let scrollTop = this.$utils.findPos(document.getElementById(`orgTagsSelection-${this._uid}`)).y;
                    if (scrollTop > 0) {
                        this.$utils.scrollToY('html,body', scrollTop + 20);
                    }
                    return;
                } else {
                    this.msg = '';
                }
                this.$emit('send', this.mSelected);
                this.$emit('input', this.mSelected);
            },
            setValue(val) {
                this.mSelected = this.$utils.deepCopy(val);
            }
        },
        created() {
            this.setValue(this.value);
        }
    }
</script>

<style scoped>

</style>
