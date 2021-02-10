import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

//components

import Login from '../components/login'
import Home from '../components/Home'
import Register from '../components/Register'
import Admin from '../components/Admin'

const routes=[
    {
        path:'/login',
        name:'login',
        component:Login

    },
    {
        path:'/',
        name:'home',
        component:Home

    },
    {
        path:'/register',
        name:'register',
        component:Register
    },
    {
        path:'/admin',
        name:'admin',
        component:Admin
    }
]


const router = new VueRouter({
    mode:'history',
    hash: false,
    root:'/',
    routes

})

export default router
