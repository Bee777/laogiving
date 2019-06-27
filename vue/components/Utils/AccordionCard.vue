<template>
    <div class="accordion-card" :class="[containerClasses]">
        <div class="accordion-card__head" @click="toggleBody()" :class="[{'is-collapsed': !expand}]">
            <slot name="header-title"></slot>
            <i class="material-icons accordion-card__chevron">{{ expand ? 'keyboard_arrow_up': 'keyboard_arrow_down'}}</i>
            <div class="accordion-card__hitarea"></div>
        </div>
        <div class="accordion-card__body" :class="[bodyClasses, {'is-collapsed': !expand}]">
            <slot name="body-content"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AccordionCard",
        props: {
            containerClasses: {
                default: ''
            },
            bodyClasses: {
                default: ''
            }
        },
        data: () => ({
            expand: true,
        }),
        methods: {
            toggleBody() {
                this.expand = !this.expand;
            }
        }
    }
</script>

<style scoped>

</style>
