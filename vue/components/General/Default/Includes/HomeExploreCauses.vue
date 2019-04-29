<template>
    <div>
        <section class="our-features causes">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h3><span>Explore </span> Causes</h3>
                        <ul>
                            <li>By inspiring and supporting one another, we can show the world that we are a nation with a big heart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="our-causes-items">
            <div class="causes-primary">
                <div class="causes-panel">
                    <a :key="idx" v-for="(i, idx) in causes" href="/search?q=&amp;causeId=26746" class="sqr-panel-item"
                       style="background-image:url('https://www.giving.sg/givingsg-theme/images/img-causes-animal.jpg')">
                        <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><title>
                            ic-animal-welfare-hp</title>
                            <g fill="none" fill-rule="evenodd">
                                <path
                                    d="M34.513 30.25c.694 1.76.645 3.58-.14 5.262-.896 1.927-2.897 2.988-5.634 2.988h-.002c-2.785 0-5.768-1.056-7.36-2.037-1.602-.985-2.298-1.16-2.47-1.19-.106.013-.215.013-.324 0-.147.026-.84.192-2.46 1.19-1.594.98-4.578 2.037-7.362 2.037-2.738 0-4.74-1.06-5.636-2.988-.785-1.683-.832-3.503-.14-5.262.932-2.36 2.98-4.043 4.6-4.665 1.393-.536 2.065-2.022 3.453-5.333.238-.57.494-1.18.775-1.832 1.97-4.565 5.602-4.92 6.667-4.92.108 0 .198.003.268.007.07-.004.16-.007.267-.007 1.066 0 4.696.355 6.667 4.92.28.652.537 1.263.777 1.833 1.39 3.31 2.06 4.796 3.455 5.332 1.618.622 3.667 2.306 4.598 4.665zM6.535 23.354c2.623-.657 4.07-3.37 3.223-6.045-.71-2.244-2.807-3.81-5.104-3.81-.402 0-.802.05-1.19.146-2.622.657-4.068 3.37-3.222 6.045.71 2.244 2.808 3.81 5.104 3.81.402 0 .802-.05 1.19-.146zM12.82 13.5c.24 0 .484-.022.722-.065 1.35-.247 2.53-1.193 3.24-2.594.658-1.303.873-2.895.606-4.483C16.865 3.253 14.675 1 12.18 1c-.24 0-.484.022-.722.066-1.35.246-2.53 1.192-3.24 2.594-.658 1.303-.873 2.896-.606 4.483.522 3.104 2.712 5.357 5.207 5.357zm26.688 2.518c-.59-1.18-1.673-2.046-2.975-2.372-.387-.097-.787-.146-1.19-.146-2.294 0-4.393 1.566-5.1 3.808-.847 2.677.6 5.39 3.22 6.046.388.097.788.146 1.19.146 2.295 0 4.394-1.566 5.103-3.808.396-1.254.308-2.56-.248-3.674zm-15.55-2.583c.238.043.48.065.723.065 2.496 0 4.687-2.253 5.21-5.357.574-3.41-1.152-6.585-3.848-7.078C25.804 1.022 25.56 1 25.32 1c-2.496 0-4.687 2.253-5.21 5.357-.574 3.41 1.152 6.585 3.848 7.078z"
                                    fill-rule="nonzero" fill="#666"></path>
                                <path d="M0 0h40v40H0z"></path>
                            </g>
                        </svg>
                        <div>{{ i.title }}</div>
                    </a>
                    <div class="sqr-panel-item__last-panel">
                        <a class="text-link font-bold nowrap" >VIEW ALL CAUSES<i class="ico ico-arrow-next-alt ml-8 mt-2neg"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "HomeExploreCauses",
        data: () => ({
            causes: [
                {title: 'Animal Welfare', bgImage: '', svg: ``},
                {title: 'Arts & Heritage', bgImage: '', svg: ``},
                {title: 'Children & Youth', bgImage: '', svg: ``},
                {title: 'Community', bgImage: '', svg: ``},
                {title: 'Disability', bgImage: '', svg: ``},
                {title: 'Education', bgImage: '', svg: ``},
                {title: 'Elderly', bgImage: '', svg: ``},
                {title: 'Environment', bgImage: '', svg: ``},
                {title: 'Families', bgImage: '', svg: ``},
                {title: 'Health', bgImage: '', svg: ``},
                {title: 'Humanitarian', bgImage: '', svg: ``},
                {title: 'Social Service', bgImage: '', svg: ``},
                {title: 'Sports', bgImage: '', svg: ``},
                {title: 'Women & Girls', bgImage: '', svg: ``}
            ]
        })
    }
</script>

<style scoped>
    .causes-primary {
        margin-top: 40px;
        background-color: #7955B4;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .causes-panel {
        margin: 0 auto;
        text-align: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding: 1rem;
        background-color: #7955B4;
    }

    .causes-panel .sqr-panel-item {
        display: block;
        -ms-flex-preferred-size: 50%;
        flex-basis: 50%;
        -webkit-box-flex: 0;
        -ms-flex-positive: 0;
        flex-grow: 0;
        cursor: pointer;
        position: relative;
        padding: 32px 0;
        outline: 1px solid #CCCCCC;
        background-color: #fafafc;
        transition: background-color .4s;
        background-size: 0 0;
        background-position: center center;
    }

    .causes-panel .sqr-panel-item:hover {
        text-decoration: none;
        background-color: #6BC1CC;
        background-size: cover;
        box-shadow: inset 0 0 0 8px #F4F4F4;
        outline: 0;
    }

    .causes-panel .sqr-panel-item svg {
        margin-bottom: 1rem;
        z-index: 1;
        position: relative;
    }

    .causes-panel .sqr-panel-item div {
        z-index: 2;
        position: relative;
        color: #666666;
        transition: color .4s;
    }

    .causes-panel .sqr-panel-item:hover div {
        color: #fff;
    }

    .causes-panel .sqr-panel-item:hover svg path[fill][fill-rule="nonzero"], .causes-panel .sqr-panel-item:hover svg g[fill][fill-rule="nonzero"] {
        fill: white;
    }

    .causes-panel .sqr-panel-item svg path[fill][fill-rule="nonzero"], .causes-panel .sqr-panel-item svg g[fill][fill-rule="nonzero"] {
        transition: fill .4s;
        fill: #666666;
    }

    .causes-panel .sqr-panel-item:after {
        content: '';
        background-color: #fafafc;
        transition: background-color .4s;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .causes-panel .sqr-panel-item:hover:after {
        content: '';
        background-color: rgba(107, 193, 204, 0.8);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .causes-panel .sqr-panel-item__last-panel {
        outline: 1px solid #CCCCCC;
        background-color: #F4F4F4;
        display: none;
        position: relative;
    }

    .causes-panel .sqr-panel-item__last-panel .text-link {
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    @media (min-width: 37.5rem) {
        .causes-panel .sqr-panel-item {
            padding: 50px 0;
            -ms-flex-preferred-size: 33.333333%;
            flex-basis: 33.333333%;
        }
        .causes-panel .sqr-panel-item__last-panel {
            display: block;
            -ms-flex-preferred-size: 33.3333%;
            flex-basis: 33.3333%;
        }
    }


    @media (min-width: 56.25rem) {
        .causes-panel .sqr-panel-item {
            -ms-flex-preferred-size: 25%;
            flex-basis: 25%;
            padding: 60px 0;
        }
        .causes-panel .sqr-panel-item__last-panel {
            -ms-flex-preferred-size: 50%;
            flex-basis: 50%;
        }
    }

    @media (min-width: 75rem) {
        .causes-panel .sqr-panel-item {
            -ms-flex-preferred-size: 14.2857%;
            flex-basis: 14.2857%;
        }
        .causes-panel .sqr-panel-item__last-panel {
            display: none;
        }
    }

</style>
