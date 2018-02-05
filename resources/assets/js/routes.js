import VueRouter from 'vue-router';
import Store from './store/index';
import jwtToken from './helpers/jwt';


let routes = [
    {
        path: '/',
        name: 'home',
        component: require('./components/pages/Home.vue'),
        meta: {}
    },
    {
        path: '/about',
        component: require('./components/pages/About.vue'),
        meta: {}
    },
    {
        path: '/product/:id',
        name: 'product',
        component: require('./components/products/product.vue'),
        meta: {}
    },
    {
        path: '/register',
        name: 'register',
        component: require('./components/register/Register.vue'),
        meta: {requiresGuest: true}

    },
    {
        path: '/login',
        name: 'login',
        component: require('./components/login/Login.vue'),
        meta: {requiresGuest: true}
    },
    {
        path: '/confirm',
        name: 'confirm',
        component: require('./components/confirm/Email.vue'),
        meta: {}
    },
    {
        path: '/getQrCode',
        component: require('./components/pages/QrCode.vue'),
        meta: {}
    },
    {
        path: '/profile',
        component: require('./components/user/ProfileWrapper.vue'),
        children: [
            {
                path: '',
                name: 'profile',
                component: require('./components/user/Profile.vue'),
                meta: {requiresAuth: true}
            },
            {
                path: '/edit-profile',
                name: 'profile.editProfile',
                component: require('./components/user/EditProfile.vue'),
                meta: {requiresAuth: true}
            },
            {
                path: '/edit-password',
                name: 'profile.editPassword',
                component: require('./components/password/EditPasssword.vue'),
                meta: {requiresAuth: true}
            }
        ],
        meta: {requiresAuth: true}

    },
    {
        path: '/api/admin',
        component: require('./components/admin/AdminWrapper.vue'),
        children: [
            {
                path: '/api/admin',
                name: 'admin.index',
                component: require('./components/admin/Index.vue'),
                meta: {requiresAuth: true}
            },
            {
                path: '/api/admin/create-product',
                name: 'admin.createProduct',
                component: require('./components/admin/CreateProduct.vue'),
                meta: {requiresAuth: true}
            },
            {
                path: '/api/admin/users-manage',
                name: 'admin.usersManage',
                component: require('./components/admin/UsersManage.vue'),
                meta: {requiresAuth: true}
            },
        ],
        meta: {requiresAuth: true}

    }


];

const router = new VueRouter({
    mode: 'history',
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        if (Store.state.AuthUser.authenticated || jwtToken.getToken()) {
            return next()
        } else {
            return next({'name': 'login'})
        }
    }
    if (to.meta.requiresGuest) {
        if (Store.state.AuthUser.authenticated || jwtToken.getToken()) {
            return next({'name': 'home'})

        } else {
            return next()
        }
    }
    next()

});

export default router
