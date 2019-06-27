<template>
    <div class="ctn gallery gallery-tablet-portrait-up-6 mt-24 clearfix"
         id="orgCausesSelection">

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
        <!--
                <ul class="gallery__item checkbox-list">
                    <li>
                        <label class="checkbox-list__checkbox">
                            <input type="checkbox"
                                   name="causeBox[]"
                                   value="26746">
                            <div class="checkbox-list__lbl-spn">Animal
                                Welfare
                            </div>
                        </label>
                    </li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26747">
                        <div class="checkbox-list__lbl-spn">Arts
                            &amp; Heritage
                        </div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26748">
                        <div class="checkbox-list__lbl-spn">
                            Children &amp; Youth
                        </div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26749">
                        <div class="checkbox-list__lbl-spn">Community</div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26750">
                        <div class="checkbox-list__lbl-spn">Disability
                        </div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26751">
                        <div class="checkbox-list__lbl-spn">Education</div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26752">
                        <div class="checkbox-list__lbl-spn">Elderly</div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26753">
                        <div class="checkbox-list__lbl-spn" data-content="Environment">Environment
                        </div>
                    </label></li>
                </ul>

                <ul class="gallery__item checkbox-list">
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26754">
                        <div class="checkbox-list__lbl-spn" data-content="Families">Families</div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26755">
                        <div class="checkbox-list__lbl-spn" data-content="Health">Health</div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="1637026">
                        <div class="checkbox-list__lbl-spn" data-content="Humanitarian">
                            Humanitarian
                        </div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26756">
                        <div class="checkbox-list__lbl-spn" data-content="Social Service">Social
                            Service
                        </div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26745">
                        <div class="checkbox-list__lbl-spn" data-content="Sports">Sports</div>
                    </label></li>
                    <li><label class="checkbox-list__checkbox">
                        <input type="checkbox"
                               name="causeBox[]"
                               value="26757">
                        <div class="checkbox-list__lbl-spn" data-content="Women &amp; Girls">Women
                            &amp; Girls
                        </div>
                    </label></li>
                </ul>
             -->
        <div class="controls clearfix">
            <label class="help-block error-msg" id="causes-error" style="display: block;">{{msg}}</label></div>
    </div>
</template>

<script>
    export default {
        name: "Causes",
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
                    this.msg = `Please select up to ${this.max} causes.`;
                    let scrollTop = this.$utils.offsetTop(`orgCausesSelection`);
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
