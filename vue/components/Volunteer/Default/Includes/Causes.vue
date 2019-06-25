<template>
    <div class="ctn gallery gallery-tablet-portrait-up-6 mt-24 clearfix"
         id="orgCausesSelection">
        <ul class="gallery__item checkbox-list" v-for="(p, idx) in chunked" :key="idx">
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
    </div>
</template>

<script>
    export default {
        name: "Causes",
        props: {
            value: {
                default: function () {
                    return [];
                }
            },
            items: {
                default: function () {
                    return [];
                }
            }
        },
        data: () => ({
            mSelected: [],
            shouldEmit: false,
        }),
        watch: {
            mSelected: function () {
                this.emit();
            },
            value: function () {
                this.setValue();
            }
        },
        computed: {
            chunked() {
                return this.$utils.chunkArray(this.items, 8);
            }
        },
        methods: {
            emit() {
                if (!this.shouldEmit) {
                    this.shouldEmit = true;
                    return;
                }
                this.$emit('send', this.mSelected);
                this.$emit('input', this.mSelected);
            },
            setValue() {
                this.shouldEmit = false;
                this.mSelected = this.$utils.deepCopy(this.value);
            }
        },
        created() {
            this.setValue();
        }
    }
</script>

<style scoped>

</style>
