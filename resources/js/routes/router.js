import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

//components

import Login from '../components/login'
import Home from '../components/Home'
import Register from '../components/Register'
import Admin from '../components/Admin'
import User from '../components/User'
import Products from '../components/Products'

const routes=[
    {
        path:'/admin',
        name:'admin',
        breadcrumbName:'Admin',
        component:Admin,
        beforeEnter:(from , to, next)=>{
            const admin =  JSON.parse(localStorage.getItem('admin'));

            if(admin){
                next()
            }else{
                next('/login')
            }
        },


    },
    {
        path:'/login',
        name:'login',
        breadcrumbName:'Login',
        component:Login

    },
    {
        path:'/',
        name:'home',
        breadcrumbName:'Home',
        component:Home

    },
    {
        path:'/register',
        name:'register',
        breadcrumbName:'Register',
        component:Register
    },
    {
        path:'/user',
        name:'user',
        breadcrumbName:'User',
        component:User,
        beforeEnter:(from , to , next)=>{
            const user = JSON.parse(localStorage.getItem('user'))

            if(user){
                next()
            }else {
                next('/login')
            }
        }
    }
]


const router = new VueRouter({
    mode:'history',
    hash: false,
    root:'/',
    routes

})

export default router
