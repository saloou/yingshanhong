<template>
    <div>
        <top-menu></top-menu>
        <notification></notification>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import TopMenu from './common/TopMenu.vue';
    import Notification from './common/Notification.vue';
    import jwtToken from './../helpers/jwt';
    import Cookie from 'js-cookie';

    export default {
        //解决刷新后 保持登陆状态
        created(){
            if (jwtToken.getToken()){
                this.$store.dispatch('setAuthUser')
            }else if (Cookie.get('auth_id')){
                this.$store.dispatch('refreshToken')
            }

        },
        components: {
            TopMenu,
            Notification
        }
    }
</script>
