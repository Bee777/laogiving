<template>
    <div class="preloader" id="loadingPartialGif"
         style="display: block;">
        <div style="text-align: center;">Loading now..</div>
        <div class="preloader-ctn" role="dialog" id="js-flex-ctn--preloader-modal">
            <svg version="1.1" id="" class="preloader-ctn__svg"
                 xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink"
                 x="0px" y="0px" width="40px" height="40px" viewBox="0 0 50 50"
                 style="enable-background: new 0 0 50 50;" xml:space="preserve">
                                        <path class="preloader-ctn__loader" fill="#000"
                                              d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"></path>
                                    </svg>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ItemsLoading"
    }
</script>

<style scoped>

</style>
