import {createActions, axiosClient} from "./actions/organizeActions";
import {
    createInit,
    defaultStates,
    defaultGetters,
    defaultMutations,
    defaultActions
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
        isSidebarCollapsed: '',
        isSidebarMobileOpen: '',
        userImage: 'user.png' + settings.fresh_version,
        authInfo: {img: 'admin.png' + settings.fresh_version},
        sidebarWidth: {normal: 256, collapsed: 68},
        isSidebar: '',
        selectedSidebarItem: {},
        menuContext: {menus: []},
        menuContextItemClicked: {},
        searchQuery: {text: '', filters: {}},
        userProfile: {
            group_size: '0',
            registration_date: '',
            profile_image_base64: '',
            visibility: true,
            website_in_our_site: '',
        },
        dashboardData: {
            activities_count: 0,
            latest_members_count: 0,
        },
        searchesData: {
            members: {},
            activity: {},
        },
        searchesAllowed: {
            activity: true,
            members: true,
        },
    },
    getters: {
        ...defaultGetters,
        getSideBarWidthForTabs(s) {
            return s.isSidebarCollapsed !== '' ? s.sidebarWidth.collapsed : s.sidebarWidth.normal;
        }
    },
    mutations: {
        ...defaultMutations,
        setSidebar(s, p) {
            s.isSidebar = p.isSidebar;
        },
        setSidebarCollapsed(s, p) {
            s.isSidebarCollapsed = s.isSidebarCollapsed === 'app-sidebar-collapsed' ? '' : 'app-sidebar-collapsed'
        },
        setSelectedSidebarItem(s, p) {
            s.selectedSidebarItem = p;
            if (s.isMobile)
                s.isSidebarMobileOpen = '';
            $utils.setWindowTitle(`${p.name} | ${settings.site_name}`, 'html,body');
        },
        setSidebarMobileOpen(s, p) {
            s.isSidebarMobileOpen = p.isOpen ? 'mobile-nav-open' : ''
        },
        setMenuContext(s, p) {
            if (p.el)
                p.el.stopPropagation();
            s.menuContext = p;
        },
        setOnMenuContextItemClick(s, p) {
            s.menuContextItemClicked = {};
            s.menuContextItemClicked = p;
        },
        setSearchesData(s, p) {
            if (!!s.searchesAllowed[p.type]) {
                s.searchesData[p.type] = p.data;
                s.searchesData[p.type].items = [];
            }
        },
        setSearchQuery(s, p) {
            s.searchQuery.text = p.text;
            s.searchQuery.filters = p.filters;
        },
        setDashboardData(s, p) {
            s.dashboardData = p;
        },
        setUserProfile(s, p) {
            s.userProfile = p;
        },
        setUserProfileKey(s, p) {
            s.userProfile[p.key] = p.value;
        }
    },
    actions: {
        ...defaultActions(axiosClient()),
        ...addedActions,
        setPageTitle(c, n) {
            if (n !== c.state.selectedSidebarItem.name)
                c.commit('setSelectedSidebarItem', {name: n});
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
