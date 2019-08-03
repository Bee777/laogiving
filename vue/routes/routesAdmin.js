import Dashboard from '@com/Admin/Dashboard.vue'
import Volunteer from '@com/Admin/Members/Volunteer.vue'
import Organize from '@com/Admin/Members/Organize.vue'
import SiteSetting from '../components/Admin/Default/SiteSetting.vue'
import ContactInfo from '@com/Admin/Posts/ContactInfo.vue'
import AboutSite from '@com/Admin/Posts/AboutSite.vue'
import News from '@com/Admin/Posts/News.vue'
import Volunteering from '@com/Admin/Posts/VolunteerActivity.vue'
import Causes from '@com/Admin/Activity/Cause.vue'
import Skill from '@com/Admin/Activity/Skill.vue'
import Suitable from '@com/Admin/Activity/Suitable.vue'

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
        name: 'volunteer',
        path: `${prefix}/volunteer`,
        component: Volunteer,
        meta: metas.authMeta,
    },
    {
        name: 'organize',
        path: `${prefix}/organize`,
        component: Organize,
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
        path: `${prefix}/volunteer-activities`,
        name: 'activities',
        component: Volunteering,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/news`,
        name: 'news',
        component: News,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/causes`,
        name: 'causes',
        component: Causes,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/skill`,
        name: 'skill',
        component: Skill,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/suitable`,
        name: 'suitable',
        component: Suitable,
        meta: metas.authMeta,
    },
];
