<style>
    #nav-title,#nav-reg,#nav-log,#nav-name,#nav-qrCode,#nav-out{
        color: #FFFFFF;
    }


</style>
<template>
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <router-link id="nav-title" to="/" class="navbar-brand">映山红</router-link>
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span>
                </button>

            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <!--这里要修改 原标签的 属性（vue-router的规则）-->
                    <router-link v-if="!user.authenticated" to="/register" tag="li">
                        <a id="nav-reg">注册</a>
                    </router-link>
                    <router-link v-if="!user.authenticated" to="/login" tag="li">
                        <a id="nav-log">登陆</a>
                    </router-link>
                    <router-link v-if="user.authenticated" to="/profile" tag="li">
                        <a id="nav-name">{{ user.name}}</a>
                    </router-link>
                    <router-link v-if="user.authenticated" to="/getQrCode" tag="li">
                        <a id="nav-qrCode">生成二维码</a>
                    </router-link>
                    <li v-if="user.authenticated">
                        <a id="nav-out" @click.prevent="logout" href="#">退出</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>

    import {mapState} from 'vuex'

    export default {
        computed: {
            ...mapState({
                user: state => state.AuthUser
            })
        },
        methods: {
            logout() {
                this.$store.dispatch('logoutRequest').then(response => {
                    this.$router.push({name: 'home'})
                })
            }
        }

    }
</script>
