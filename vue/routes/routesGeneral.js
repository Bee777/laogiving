import Login from '@com/General/Login.vue'
import ResetPassword from '@com/General/ResetPassword.vue'
import Register from '@com/General/Register.vue'
import Registered from '@com/General/Registered.vue'
import FinishedResetPassword from '@com/General/FinishedResetPassword.vue'
import Home from '@com/General/Default/Home.vue'
const About = ()=> import('@com/General/Default/About.vue')
const Contact = ()=> import('@com/General/Default/Contact.vue')
const News = ()=> import('@com/General/Pages/News.vue');
import Activities from '@com/General/Pages/Activities.vue'
import NewsSingle from '@com/General/Pages/Single/NewsSingle.vue'
import ActivitySingle from  '@com/General/Pages/Single/ActivitySingle.vue'

const metas = {
    guestMeta: {
        requiresVisitor: true,
        except: ['admin', 'super_admin'],
        redirect: 'home', //don't use any route name of requiresVisitor
        path: '/', //don't use any route path of requiresVisitor
    },
    defaultMeta: {
        navFixed: true,
        hideNavFooter: true,
    },
    authMeta: {
        requiresAuth: true
    },
    df(prm) {
        let r = Object.assign({}, this.defaultMeta);
        for (let p in prm) {
            if (prm.hasOwnProperty(p))
                r[p] = prm[p];
        }
        return r;
    }
};

export default [
    {
        path: "/login",
        component: Login,
        name: 'login',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/register",
        component: Register,
        name: 'register',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/register-successfully",
        component: Registered,
        name: 'registered',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/password/reset/:token",
        component: ResetPassword,
        name: 'reset-password',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/reset-password-successfully",
        component: FinishedResetPassword,
        name: 'finished-reset-password',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '*', component: Home, meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/about',
        name: 'about',
        component: About,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/news',
        name: 'news',
        component: News,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/news/single/:id',
        name: 'news-single',
        component: NewsSingle,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/activities',
        name: 'activities',
        component: Activities,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/volunteer-activity/:id',
        name: 'activity-single',
        component: ActivitySingle,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    }
];
