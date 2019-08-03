<template>
    <div class="filter-item" :class="[{'is-expanded' : expanded}]">
        <div @click="toggleExpand()" class="title-head">
            {{ name }}
            <i class="material-icons title-head-icon"> {{ expanded ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</i>
        </div>
        <div class=" title-body title-body-collapsible">
            <ul v-if="type==='checkbox'" class="checkbox-list" style="max-height: none;">
                <li class="title-child" v-for="(item, idx) in items" :key="idx">
                    <label class="checkbox-list__checkbox">
                        <input name="filterItem[]" v-model="mSelected" type="checkbox" :value="item.id">
                        <span class="checkbox-list__lbl-spn">{{item.name}}</span>
                    </label>
                </li>
            </ul>
            <ul v-else-if="type==='radio'" class="radio-btn--large list--bot-space-large"
                style="max-height: none;">
                <li v-for="(item, idx) in items" :key="idx">
                    <label class="radio-btn__lbl">
                        <input v-model="mSelected" name="filter-range" :value="item.id" class="radio-btn__radio"
                               type="radio">
                        <span class="radio-btn__value">
                                                {{ item.name }}
                                            </span>
                    </label>
                </li>
            </ul>
            <template v-else>
                <div class="radio-filters" v-for="(item, idx) in items" :key="idx">
                    <label class="radio-filters__lbl">
                        <input @click="clearSelectedVal()" type="radio" name="filter-single"
                               v-model="mSelected"
                               :value="item.id"
                               class="radio-filters__radio callSearch categoriesType targetCategory">
                        <span
                            class="radio-filters__text-left">{{item.name}}</span>
                        <span class="radio-filters__text-right">{{item.count}}</span>
                    </label>
                </div>
            </template>

        </div>
    </div>
</template>

<script>
    export default {
        name: "FilterItem",
        props: {
            value: {
                default: function () {
                    return [];
                }
            },
            name: {
                default: 'name'
            },
            items: {
                default: function () {
                    return [];
                }
            },
            type: {
                default: 'checkbox'
            }
        },
        data: () => ({
            expanded: true,
            mSelected: null,
        }),
        watch: {
            mSelected: function () {
                this.emit();
            },
            value: function (n) {
                this.mSelected = n;
            }
        },
        methods: {
            toggleExpand() {
                this.expanded = !this.expanded;
            },
            emit() {
                this.$emit('send', this.mSelected);
                this.$emit('input', this.mSelected);
            },
            setValue(val) {
                this.mSelected = this.$utils.deepCopy(val);
            },
            clearSelectedVal() {
                this.$emit('onClearSelected');
            }
        },
        created() {
            this.setValue(this.value);
        }
    }
</script>

<style scoped>

</style>
