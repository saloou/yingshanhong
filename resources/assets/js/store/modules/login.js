import jwtToken from './../../helpers/jwt'

export default {
    actions: {
        loginRequest({dispatch}, formData) {
            var instance = axios.create();
            return instance.post('/api/login', formData).then(response => {
                console.log('666666666');
                dispatch('loginSuccess', response.data);
            })
        },

        loginSuccess({dispatch}, tokenResponse) {
            jwtToken.setToken(tokenResponse.token);
            jwtToken.setAuthId(tokenResponse.auth_id);
            console.log('77777777777');
            dispatch('setAuthUser');
        },

        logoutRequest({dispatch}) {
            var instance = axios.create();
            instance.defaults.headers.common['Authorization'] = 'Bearer ' + jwtToken.getToken();
            return instance.post('/api/logout').then(response => {
                console.log('8888888888');
                jwtToken.removeToken();
                dispatch('unsetAuthUser')
            }).catch(error => {
                console.log('99999999999');

                console.log(error.response);

            })

        }

    }
}