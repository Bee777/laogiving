import {createActions, axiosClient} from "./actions/generalActions";
import {
    createInit,
    defaultStates,
    defaultGetters,
    defaultMutations,
    defaultActions,
} from '../initial/initializer';

/**
 * @initialize
 */
let {Vue, Vuex, $utils, debounce, initRouter} = createInit();
let addedActions = createActions($utils);
let {client, ajaxConfig, apiUrl} = axiosClient();
//@start set vue prototype
Vue.prototype.initRouter = initRouter;
Vue.prototype.apiUrl = apiUrl;
Vue.prototype.ajaxConfig = ajaxConfig;
Vue.prototype.client = client;
//@end set vue prototype
export default new Vuex.Store({
    state: {
        ...defaultStates,
        isSidebar: '',
        homeData: {
            banners: banners,
            latest_news: latest_news,
            states: states,
            all_causes: all_causes,
            all_suitables: all_suitables,
            all_skills: all_skills,
            openings: [
                {name: '1-10', id: '1-10'},
                {name: '11-20', id: '11-20'},
                {name: '21-30', id: '21-30'},
                {name: 'Above 30', id: '31-9999'},
            ],
            dates: [
                {name: 'All Dates', id: 'all_date'},
                {name: 'Tomorrow', id: 'tomorrow'},
            ],
            frequency: [],
            weekday_or_weekend: [],
            commitment_duration: [],
        },
        postsData: {
            news: news,//{posts: {}, mostViews: [], comingEvents: []},
            activities: activities,
        },
        singlePostsData: {
            news: {data: {}, others: []},
            activities: {data: {}, others: []},
        },
        postsAllowed: {
            news: true,
            activities: true,
            organizations: true,
        },
        searchQuery: {text: '', filters: {}},
    },
    getters: {
        ...defaultGetters,
    },
    mutations: {
        ...defaultMutations,
        setSidebar(s, p) {
            s.isSidebar = p.isSidebar;
        },
        setHomeData(s, p) {
            s.homeData = p;
        },
        setPostsData(s, p) {
            if (!!s.postsAllowed[p.type]) {
                s.postsData[p.type] = p.data;
            }
        },
        setSinglePostsData(s, p) {
            if (!!s.postsAllowed[p.type]) {
                s.singlePostsData[p.type] = p.data;
            }
        },
        setSearchQuery(s, p) {
            s.searchQuery.text = p.text;
            s.searchQuery.filters = p.filters;
        },
    },
    actions: {
        ...defaultActions(axiosClient()),
        ...addedActions,
        setPageTitle(c, n) {
            $utils.setWindowTitle(`${n} | ${settings.site_name}`, 'html,body');
        },
        showErrorToast(c, data) {
            Vue.toasted.error(data.msg, {
                duration: data.dt,
                action: {
                    text: 'Close',
                    onClick: (e, t) => {
                        t.goAway(0);
                    }
                }
            });
        },
        showInfoToast(c, data) {
            Vue.toasted.show(data.msg, {
                duration: data.dt,
                action: {
                    text: 'Close',
                    onClick: (e, t) => {
                        t.goAway(0);
                    }
                }
            });
        },
    } //end actions
});
