<template>

    <div :id="`carousel-${_uid}`" class="swiper-container"
         :class="[{'swiper-container--images' : type==='image'}, containerClasses]">

        <div class="swiper-wrapper " :class="[wrapperClasses]">
            <slot name="slide-item"></slot>
        </div>

        <template v-if="!hasSlot('swiper-control')">
            <div class="swiper-button-prev rotage"></div>
            <div class="swiper-button-next"></div>
        </template>
        <slot v-else name="swiper-control"></slot>
    </div>

</template>

<script>
    export default {
        name: "Carousel",
        props: {
            type: {
                default: 'image'
            },
            hasVideos: {
                default: false,
            },
            containerClasses: {
                default: ''
            },
            wrapperClasses: {
                default: ''
            },
            options: {
                default: function () {
                    return {
                        loop: true,
                        // Navigation arrows
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        spaceBetween: 10,
                    }
                }
            }
        },
        data: () => ({
            carousel: null,
            id: null,
        }),
        methods: {
            initCarousel() {
                //init swiper
                this.carousel = new Swiper(this.id, {
                    ...this.options,
                    ...{
                        on: {
                            init: () => {
                                if (this.hasVideos) {
                                    this.setVideosOnload();
                                }
                            },
                        }
                    }
                });
                this.carousel.on('slideChangeTransitionStart', () => {
                    let swiper = this.carousel;
                    this.removeVideoIframes(swiper);
                    this.addVideoIframes(swiper);
                });
                //init swiper
                return this.carousel;
            },
            addVideoIframes(swiper) {
                let Video = swiper.slides[swiper.activeIndex];
                if (Video) {
                    Video = swiper.slides[swiper.activeIndex].querySelector('.video-container');
                    if (Video && !Video.querySelector('iframe')) {
                        this.setVideoYoutube(Video);
                    }
                }
            },
            removeVideoIframes(swiper) {
                for (let o in swiper.slides) {
                    if (swiper.slides.hasOwnProperty(o) && !this.$utils.isNumber(swiper.slides[o])) {
                        let el = swiper.slides[o];
                        let Videos = el.querySelectorAll('.video-container');
                        for (let i = 0; i < Videos.length; i++) {
                            let Video = Videos[i];
                            if (Video && Video.querySelector('iframe')) {
                                Video.removeChild(Video.querySelector('iframe'));
                            }
                        }
                    }
                }
            },
            setVideoYoutube(youtube) {
                youtube.innerHTML = `<button class="ytp-large-play-button ytp-button" aria-label="Play">
                                        <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%">
                                            <path class="ytp-large-play-button-bg"
                                                  d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"
                                                  fill="#212121" fill-opacity="0.8"></path>
                                            <path d="M 45,24 27,14 27,34" fill="#fff"></path>
                                        </svg>
                                    </button>`;
                let source = "https://img.youtube.com/vi/" + youtube.dataset.embed + "/sddefault.jpg";
                let image = new Image();
                image.src = source;
                image.addEventListener("load", function () {
                    youtube.appendChild(image);
                }());
                youtube.addEventListener("click", function () {
                    let iframe = document.createElement("iframe");
                    iframe.setAttribute("height", "100%");
                    iframe.setAttribute("width", "100%");
                    iframe.setAttribute("frameborder", "0");
                    iframe.setAttribute("allowfullscreen", "");
                    iframe.setAttribute("allow", "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture");
                    iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");
                    this.innerHTML = "";
                    this.appendChild(iframe);
                });
                youtube.className = youtube.className.replace('none-active', '');
            },
            youtubeVideos() {
                let youtube = document.querySelectorAll(".video-container");
                for (let i = 0; i < youtube.length; i++) {
                    this.setVideoYoutube(youtube[i]);
                }
            },
            setVideosOnload() {
                this.youtubeVideos();
            },
            removeCarousel() {
                if (this.carousel) {
                    this.carousel.destroy();
                    this.carousel = undefined;
                }
                this.jq('.swiper-wrapper').removeAttr('style');
                this.jq('.swiper-slide').removeAttr('style');
            }
        },
        created() {
            this.id = `#carousel-${this._uid}.swiper-container`;
        },
        beforeDestroy() {
            this.removeCarousel();
        }
    }
</script>

<style scoped>

</style>
