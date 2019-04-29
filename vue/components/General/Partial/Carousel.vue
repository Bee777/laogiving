<template>
    <div>
        <div id="flex" class="flexslider laogiving">
            <ul class="slides">
                <slot :path="path"></slot>
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
        methods: {
            openLink(link) {
                if (this.hasLink(link)) {
                    window.open(link, '_blank');
                }
            }
        },
        mounted() {
            this.jq('.laogiving').flexslider({
                animation: "fade",
                start: () => {
                    this.jq('body').removeClass('loading');
                },
                before: (slider) => {
                    var $animateSlide = this.jq(slider).find("[data-animation ^= 'animated']");
                    doAnimations($animateSlide);
                }
            });
        },
    }
</script>
