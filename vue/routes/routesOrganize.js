import Home from '@com/Organize/Default/Home.vue'
import AllVolunteers from '@com/Organize/Pages/AllVolunteers.vue'
import ManageSignUpVolunteers from '@com/Organize/Pages/ManageSignUpVolunteers.vue'
import CreateActivity from "@com/Organize/Pages/CreateActivity.vue";

let adminTypes = ['admin', 'super_admin'];
const metas = {
    guestMeta: {
        requiresVisitor: true,
        except: adminTypes,
        redirect: 'home', //don't use any route name of requiresVisitor
        path: '/', //don't use any route path of requiresVisitor
    },
    defaultMeta: {
        navFixed: true,
        hideNavFooter: true,
    },
    authMeta: {
        requiresAuth: true,
        allows: adminTypes.concat(['organize'])
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
const prefix = '/organize/me';
export default [
    {
        path: `${prefix}/`,
        name: 'home',
        component: Home,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            }),
            ...metas.authMeta
        },
    },
    {
        path: `${prefix}/all-volunteers`,
        name: 'all-volunteers',
        component: AllVolunteers,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            }),
            ...metas.authMeta
        },
    },
    {
        path: `${prefix}/manage-sign-up-volunteers`,
        name: 'manage-sign-up-volunteers',
        component: ManageSignUpVolunteers,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            }),
            ...metas.authMeta
        },
    },
    {
        path: `${prefix}/create-activity`,
        name: 'create-activity',
        component: CreateActivity,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            }),
            ...metas.authMeta
        },
    },
    {
        path: '*', component: Home, meta: {
            ...metas.df({
                hideNavFooter: false,
            }),
            ...metas.authMeta
        },
    }
];
