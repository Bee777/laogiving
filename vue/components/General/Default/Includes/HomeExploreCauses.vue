<template>
    <div>
        <section class="our-features causes">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h3><span>Explore </span> Causes</h3>
                        <ul>
                            <li>By inspiring and supporting one another, we can show the world that we are a nation with
                                a big heart
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="our-causes-items">
            <div class="causes-primary">
                <div class="causes-panel">
                    <a :key="idx" v-for="(i, idx) in $store.state.homeData.all_causes.slice(0, 14)"
                       :href="`/posts/activities?q=&causes=${i.id}&search=yes`"
                       class="sqr-panel-item"
                       :style="`background-image:url('${i.background_image}')`">
                        <content v-html="i.icon"></content>
                        <div>{{ i.name }}</div>
                    </a>
                    <div class="sqr-panel-item__last-panel">
                        <a :href="`/posts/activities?q=&search=yes`" class="text-link font-bold nowrap">VIEW ALL CAUSES<i
                            class="ico ico-arrow-next-alt ml-8 mt-2neg"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "HomeExploreCauses"
    }
</script>
