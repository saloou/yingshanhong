import * as types from './../mutation-type'
import jwtToken from './../../helpers/jwt';


export default {
    state: {
        authenticated: false,
        name: null,
        email: null
    },
    mutations: {
        [types.UPDATE_PROFILE_NAME](state, payload) {
            state.name = payload.value
        },
        [types.UPDATE_PROFILE_EMAIL](state, payload) {
            state.email = payload.value
        },
        [types.SET_AUTH_USER](state, payload) {
            state.authenticated = true
            state.name = payload.user.name
            state.email = payload.user.email
        },
        [types.UNSET_AUTH_USER](state) {
            state.authenticated = false
            state.name = null
            state.email = null
        }
    },
    actions: {
        setAuthUser({commit, dispatch}) {
            var instance = axios.create();
            instance.defaults.headers.common['Authorization'] = 'Bearer ' + jwtToken.getToken();
            return instance.get('/api/user').then(response => {
                console.log('1111111111');
                // console.log('Bearer ' + jwtToken.getToken());
                commit({
                    type: types.SET_AUTH_USER,
                    user: response.data
                })
            }).catch(error => {
                console.log('2222222222');

                dispatch('refreshToken')
            })

        },
        unsetAuthUser({commit}) {
            console.log('33333333');
            commit({
                type: types.UNSET_AUTH_USER
            })
        },
        refreshToken({commit, dispatch}) {
            var instance = axios.create();
            instance.defaults.headers.common['Authorization'] = 'Bearer ' + jwtToken.getToken();
            return instance.post('/api/token/refresh').then(response => {
                console.log('44444444');
                dispatch('loginSuccess', response.data)
            }).catch(error => {
                console.log('555555555');

                dispatch('logoutRequest')
            })

        }
    }
}