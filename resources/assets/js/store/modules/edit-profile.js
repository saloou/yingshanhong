import jwtToken from './../../helpers/jwt';


export default {
    actions: {
        updateProfileRequest({dispatch}, formData) {
            var instance = axios.create();
            instance.defaults.headers.common['Authorization'] = 'Bearer ' + jwtToken.getToken();
            return instance.post('/api/user/profile/update', formData).then(response => {
                dispatch('showNotification',{level:'success',msg:'个人资料修改成功'});

                console.log('1010101010')
            }).catch(error => {
                dispatch('hideNotification',{level:'error',msg:'个人资料修改失败'});

                console.log(error.response);
            })
        },


    }
}