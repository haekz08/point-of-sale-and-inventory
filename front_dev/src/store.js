import Vue from 'vue'
import Vuex from 'vuex'

import axios from 'axios'
Vue.use(Vuex)

const state = {
  sidebarShow: 'responsive',
  sidebarMinimize: false,
  token:localStorage.getItem('token') || null,
  user:localStorage.getItem('user') || null,
  loading:false
}
const getters = {
    loggedIn(state){
        return state.token !== null
    },
    isLoading(state){
        return state.loading
    },
    userDetails(state){
        return JSON.parse(state.user);
    }
}
const mutations = {
  toggleSidebarDesktop (state) {
    const sidebarOpened = [true, 'responsive'].includes(state.sidebarShow)
    state.sidebarShow = sidebarOpened ? false : 'responsive'
  },
  toggleSidebarMobile (state) {
    const sidebarClosed = [false, 'responsive'].includes(state.sidebarShow)
    state.sidebarShow = sidebarClosed ? true : 'responsive'
  },
  set (state, [variable, value]) {
    state[variable] = value
  },
  retrieveStorage(state,payload){
      state.token = payload.token
      state.user = payload.user
  },
  destroyStorage(state){
      state.token = null
      state.user = null
  }
}
const actions = {
    logInAction(context, credentials){
        return new Promise((resolve,reject)=>{
            axios.post('oauth/token',credentials).then((response) => {
                const token = response.data.access_token
                const user = JSON.stringify(response.data.user)

                localStorage.setItem('user',user)
                localStorage.setItem('token',token)
                context.commit('retrieveStorage',{token:token,user:user})
                axios.defaults.headers.common['Authorization']= 'Bearer '+token;
                resolve()
            })
                .catch(error => {
                    reject(error)
                });
        })
    },
    logOutAction(context){
        return new Promise((resolve,reject)=>{
            if(context.getters.loggedIn) {
                localStorage.removeItem('token')
                localStorage.removeItem('user')
                context.commit('destroyStorage')
                resolve()
            }else{
                reject(error)
            }
        })
    }
}

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters
})