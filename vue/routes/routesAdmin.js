import Dashboard from '@com/Admin/Dashboard.vue'
import Members from '@com/Admin/Members/All.vue'
import SingleMemberProfile from '@com/Admin/Members/SingleMemberProfile.vue'
import Organize from '@com/Admin/Members/Organize.vue'
import MembersProfile from '@com/Admin/Members/MembersProfile.vue'
import SiteSetting from '../components/Admin/Default/SiteSetting.vue'
import ContactInfo from '@com/Admin/Posts/ContactInfo.vue'
import AboutSite from '@com/Admin/Posts/AboutSite.vue'
import News from '@com/Admin/Posts/News.vue'
import Activity from '@com/Admin/Posts/Activity.vue'
import UploadFile from '@com/Admin/Posts/Uploadfile.vue'

const prefix = '/admin/me';
const metas = {
    authMeta: {
        requiresAuth: true,
        allows: ['admin', 'super_admin']
    },
    guestMeta: {
        requiresVisitor: true,
        except: ['admin', 'super_admin'],
        redirect: 'admin/me', //don't use any route name of requiresVisitor
        path: '/admin/me', //don't use any route path of requiresVisitor
    }
};

export default [{
    path: `${prefix}/site-setting`,
    component: SiteSetting,
    name: 'site-setting',
    meta: metas.authMeta,
},
    {
        path: prefix,
        component: Dashboard,
        name: 'dashboard',
        meta: metas.authMeta,
    },
    {
        name: 'members',
        path: `${prefix}/members`,
        component: Members,
        meta: metas.authMeta,
    },
    {
        name: 'organization',
        path: `${prefix}/organizations`,
        component: Organize,
        meta: metas.authMeta,
    },
    {
        name: 'members-profile',
        path: `${prefix}/members-profile`,
        component: MembersProfile,
        meta: metas.authMeta,
    },
    {
        name: 'member-profile',
        path: `${prefix}/members-profile/:user_id`,
        component: SingleMemberProfile,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/contact-info`,
        name: 'contact-info',
        component: ContactInfo,
        meta: metas.authMeta,
    }, {
        path: `${prefix}/about`,
        name: 'about',
        component: AboutSite,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/news`,
        name: 'news',
        component: News,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/activity`,
        name: 'activity',
        component: Activity,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/upload-files`,
        name: 'upload-file',
        component: UploadFile,
        meta: metas.authMeta,
    },

];
