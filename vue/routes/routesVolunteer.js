import Home from '@com/Volunteer/Default/Home.vue'

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
        allows: adminTypes.concat(['volunteer'])
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
const prefix = '/volunteer/me';
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
        path: '*', component: Home, meta: {
            ...metas.df({
                hideNavFooter: false,
            }),
            ...metas.authMeta
        },
    }
];
