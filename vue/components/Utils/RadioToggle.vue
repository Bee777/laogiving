<template>
    <div class="nav-acdr" :class="[{'is-expanded' : toggleRadio}]">
        <div class="nav-acdr__head" @click="toggleRadio=!toggleRadio"><span
            class="nav-acdr__title">Live</span> <span
            class="nav-acdr__stats live-count">3</span></div>

        <div class="nav-acdr__body">

            <div v-for="(item, idx) in items" :key="idx" class="nav-acdr__grp nav-acdr__grp--single">
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
            mSelected:'',
        }),
        watch: {
            mSelected: function (n) {
               this.emit();
            }
        },
        methods: {
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
