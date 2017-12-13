<template>
    <form class="form-horizontal" @submit.prevent="login">

        <div class="form-group" :class="{'has-error' : errors.has('email')}">
            <label for="email" class="col-md-4 control-label">邮箱</label>
            <div class="col-md-6">
                <input v-model="email"
                       v-validate data-vv-rules="required|email" data-vv-as="邮箱"
                       id="email" type="email" class="form-control" name="email" required>
                <span class="help-block" v-show="errors.has('email')">{{errors.first('email')}}</span>
            </div>
        </div>

        <div class="form-group" :class="{'has-error' : errors.has('password')  || bag.has('password:auth')}">
            <label for="password" class="col-md-4 control-label">密码</label>
            <div class="col-md-6">
                <input v-model="password"
                       v-validate data-vv-rules="required|min:6" data-vv-as="密码"
                       id="password" type="password" class="form-control" name="password" required>
                <span class="help-block" v-show="errors.has('password')">{{errors.first('password')}}</span>
                <span class="help-block" v-if="mismatchError">{{bag.first('password:auth')}}</span>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary form-control">
                    登陆
                </button>
            </div>
        </div>
    </form>

</template>

<script>
    import jwtToken from './../../helpers/jwt';
    import {ErrorBag} from 'vee-validate';


    export default {
        data() {
            return {
                email: '',
                password: '',
                bag: new ErrorBag()
            };
        },
        computed: {
            mismatchError() {
                return this.bag.has('password:auth') && !this.errors.has('password')
            },

        },
        watch: {
            password() {
                if (this.bag.has('password:auth')) {
                    this.bag.remove('password');
                }
            },
        },

        methods: {

            login() {
                this.$validator.validateAll().then(result => {
                    if (result) {
                        let formData = {
                            email: this.email,
                            password: this.password
                        };

                        this.$store.dispatch('loginRequest', formData).then(response => {
                            this.$router.push({name: 'profile'})
                        }).catch(error => {
                            if (error.response.status === 421) {
                                this.bag.add('password', '邮箱和密码不匹配', 'auth');
                            }
                            console.log('99999999999');

                            console.log(error.response)
                        })
                    }
                })
            }
        }
    }
</script>