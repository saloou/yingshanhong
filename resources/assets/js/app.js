
require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import router from './routes';
import store from './store/index';
import App from './components/App.vue';
import Admin from './components/Admin.vue';
import zh_CN from './locale/zh_CN';
import VeeValidate, {Validator} from 'vee-validate';




Validator.localize('zh_CN', zh_CN);
Vue.use(VeeValidate, {local: 'zh_CN'});


//在这里全局定义了 app 为 App（这样就可以全局使用到<app></app>）
Vue.component('app', App);
Vue.component('admin', Admin);


new Vue({
    el: '#app',
    router,
    store
});


new Vue({
    el: '#admin',
    router,
    store
});
