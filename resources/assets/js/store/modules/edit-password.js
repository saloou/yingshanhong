import jwtToken from './../../helpers/jwt';


export default {
    actions: {
        updatePasswordRequest({dispatch}, formData) {
            var instance = axios.create();
            instance.defaults.headers.common['Authorization'] = 'Bearer ' + jwtToken.getToken();
            return instance.post('/api/user/password/update', formData).then(response => {
               dispatch('showNotification',{level:'success',msg:'密码修改成功'});
                console.log('1212121212')
            }).catch(error => {
                dispatch('hideNotification',{level:'error',msg:'密码修改失败'});
                console.log(error.response);
            })
        },


    }
}