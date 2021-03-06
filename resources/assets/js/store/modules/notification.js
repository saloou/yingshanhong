import * as types from './../mutation-type'


export default {
    state: {
        level: 'success',
        msg: null
    },
    mutations: {
        [types.SHOW_NOTIFICATION](state, payload) {
            state.level = payload.notification.level,
            state.msg = payload.notification.msg
        },
        [types.HIDE_NOTIFICATION](state, payload) {
            state.level = 'success',
            state.msg = ''
        }
    },
    actions: {
        showNotification({commit}, notification) {
            console.log('13131313');

            commit({
                type: types.SHOW_NOTIFICATION,
                notification: notification
            })
        },
        hideNotification({commit}) {
            commit({
                type: types.HIDE_NOTIFICATION
            })
        },

    }
}