<template>
    <div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">
        <div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span
            class="nav-acdr__title">{{getSelected().text}}</span> <span
            class="nav-acdr__stats live-count">{{ getSelected().count }}</span></div>

        <div class="nav-acdr__body">
            <template v-for="(item, idx) in items">
                <div v-if="!item.group" :key="idx" class="nav-acdr__grp nav-acdr__grp--single">
                    <div class="radio-filters radio-filters--blk"><label
                        class="radio-filters__lbl">
                        <input type="radio"
                               v-model="mSelected"
                               name="filter_status"
                               class="radio-filters__radio" :value="item.value">
                        <span class="radio-filters__text-left">{{item.text}}</span>
                        <span class="radio-filters__text-right live-count">{{item.count}}</span>
                        <div class="radio-filters--blk__hilite"></div>
                    </label>
                    </div>
                </div>

                <div v-else class="nav-acdr__grp by-roles" :key="idx">
                    <div class="nav-acdr__grp-title">{{item.group.name}}</div>

                    <div class="radio-filters radio-filters--blk" v-for="(jItem, jdx) in item.group.items" :key="jdx">
                        <label class="radio-filters__lbl">
                            <input type="radio"
                                   v-model="mSelected"
                                   name="filter_status"
                                   :value="jItem.value"
                                   class="radio-filters__radio">
                            <span class="radio-filters__text-left">{{jItem.text}}</span>
                            <span class="radio-filters__text-right">{{jItem.count}}</span>
                            <div class="radio-filters--blk__hilite"></div>
                        </label>
                    </div>

                </div>

            </template>

            <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
            <!--<div class="radio-filters radio-filters&#45;&#45;blk"><label-->
            <!--class="radio-filters__lbl">-->
            <!--<input type="radio" checked=""-->
            <!--name="filter_status"-->
            <!--class="radio-filters__radio" value="LIVE">-->
            <!--<span class="radio-filters__text-left">Current Opportunities</span>-->
            <!--<span class="radio-filters__text-right live-count">2</span>-->
            <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
            <!--</label>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
            <!--<div class="radio-filters radio-filters&#45;&#45;blk">-->
            <!--<label class="radio-filters__lbl">-->
            <!--<input type="radio"-->
            <!--name="filter_status"-->
            <!--class="radio-filters__radio" value="CLOSED">-->
            <!--<span class="radio-filters__text-left">Past Opportunities</span>-->
            <!--<span class="radio-filters__text-right closed-count">5</span>-->
            <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
            <!--</label>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
            <!--<div class="radio-filters radio-filters&#45;&#45;blk">-->
            <!--<label class="radio-filters__lbl">-->
            <!--<input type="radio"-->
            <!--name="filter_status"-->
            <!--class="radio-filters__radio" value="DRAFT">-->
            <!--<span class="radio-filters__text-left">Drafts</span>-->
            <!--<span class="radio-filters__text-right cancelled-count">0</span>-->
            <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
            <!--</label>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="nav-acdr__grp nav-acdr__grp&#45;&#45;single">-->
            <!--<div class="radio-filters radio-filters&#45;&#45;blk">-->
            <!--<label class="radio-filters__lbl">-->
            <!--<input type="radio"-->
            <!--name="filter_status"-->
            <!--class="radio-filters__radio" value="CANCELLED">-->
            <!--<span class="radio-filters__text-left">Cancelled</span>-->
            <!--<span class="radio-filters__text-right cancelled-count">0</span>-->
            <!--<div class="radio-filters&#45;&#45;blk__hilite"></div>-->
            <!--</label>-->
            <!--</div>-->
            <!--</div>-->

        </div>
    </div>
</template>

<script>
    export default {
        name: "RadioToggle",
        props: {
            value: {
                default: function () {
                    return '';
                }
            },
            items: {
                default: function () {
                    return [];
                }
            }
        },
        data: () => ({
            toggleRadio: false,
            mSelected: '',
        }),
        watch: {
            mSelected: function (n) {
                this.emit();
            }
        },
        methods: {
            getSelected() {
                let selected = {};
                this.items.map(f => {
                    let gItem = {};
                    if (f.group) {
                        gItem = f.group.items.filter(gF => {
                            return gF.value === this.mSelected;
                        }).shift() || {};
                        if (gItem.value === this.mSelected) {
                            selected = gItem;
                        }
                    }
                    if (f.value === this.mSelected) {
                        selected = f;
                    }
                });
                return selected;
            },
            emit() {
                this.$emit('send', this.mSelected);
                this.$emit('input', this.mSelected);
            }
        },
        created() {
            this.mSelected = this.value;
            this.emit();
        }
    }
</script>

<style scoped>

</style>
