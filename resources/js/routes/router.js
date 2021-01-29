import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//components

import Login from '../components/login'
import Home from '../components/Home'

const router = new VueRouter({
    routes:[
        {
            path:'/login',
            component:Login

        },
        {
            path:'/',
            component:Home

        },
    ]

})

export default router
