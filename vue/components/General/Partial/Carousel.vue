<template>
    <div>
        <div id="flex-home-banners" class="flexslider laogiving">
            <ul class="slides">
                <slot v-for="(data, idx) in items" :path="path" :idx="idx" :data="data"></slot>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['items'],
        data() {
            return {
                path: `${this.baseUrl}${this.baseRes}/assets/images/`,
            }
        },
        watch: {
            items: function (n) {
                this.$nextTick(() => {
                    this.initSlider();
                });
            }
        },
        methods: {
            openLink(link) {
                if (this.hasLink(link)) {
                    window.open(link, '_blank');
                }
            },
            initSlider() {
                this.jq('#flex-home-banners').flexslider({
                    animation: "fade",
                    start: () => {
                        this.jq('body').removeClass('loading');
                    },
                    before: (slider) => {
                        const $animateSlide = this.jq(slider).find("[data-animation ^= 'animated']");
                        doAnimations($animateSlide);
                    }
                });
            }
        },
        mounted() {
            this.initSlider();
        },
    }
</script>
