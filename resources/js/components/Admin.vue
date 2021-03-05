<template>
    <a-layout id="components-layout-demo-side" style="min-height: 100vh">
        <a-layout-sider v-model="collapsed" collapsible>
            <div class="logo" />
            <a-menu theme="dark" :default-selected-keys="['Products']" mode="inline" @click="selectedItem">
                <a-menu-item key="Products">
                    <a-icon type="stock" />
                    <span>Products</span>
                </a-menu-item>
                <a-menu-item key="Orders">
                    <a-icon type="shopping-cart" />
                    <span>Orders</span>
                </a-menu-item>
                <a-menu-item key="Users">
                    <a-icon type="team" />
                    <span>Users</span>
                </a-menu-item>
                <a-sub-menu key="sub2">
                    <span slot="title"><a-icon type="plus-circle" />
                        <span>Categories</span></span>
                    <a-menu-item key="6">
                        Team 1
                    </a-menu-item>
                    <a-menu-item key="8">
                        Team 2
                    </a-menu-item>
                </a-sub-menu>
                <a-menu-item key="9" @click="logout">
                    <a-icon type="logout" />
                    <span>Logout</span>
                </a-menu-item>
            </a-menu>
        </a-layout-sider>
        <a-layout>
            <a-page-header style="background: #002140; padding: 5px; color:#fff" >

                <template slot="extra">
                   <div>
                       <a-icon type="user"/>
                       {{admin.userData.userName}}
                   </div>
                </template>

            </a-page-header>
            <a-layout-content style="margin: 0 16px">
                <a-breadcrumb style="margin: 16px 0" >
                    <a-breadcrumb-item>Admin</a-breadcrumb-item>
                    <a-breadcrumb-item>{{optionSelected}}</a-breadcrumb-item>

                   </a-breadcrumb>

                <div :style="{ padding: '24px', background: '#fff', minHeight: '360px' }">
                    <span v-if="optionSelected==='Products'"><Products/></span>
                    <span v-if="optionSelected==='Users'"><UsersList/></span>
                    <span v-if="optionSelected==='Orders'"><Orders/></span>
                </div>
            </a-layout-content>
            <a-layout-footer style="text-align: center">
                Inventory Management ©2021
            </a-layout-footer>
        </a-layout>
    </a-layout>
</template>
<script>
import Products from './Products'
import Orders  from "./Orders";
import UsersList from "./UsersList";

export default {
    data() {
        const admin = JSON.parse(localStorage.getItem('admin'))
        return {
            admin,
            collapsed: false,
            optionSelected:'Products',
            basePath:'/admin'
        };
    },
components:{
        Products,
        Orders,
    UsersList
},
    methods:{
        logout(){
            if(localStorage.admin){
                localStorage.removeItem('admin')
                this.$router.push('/login')
            }
       },
        selectedItem( item, key, keyPath){
            this.optionSelected = item.key
        }
    },

    computed:{
        getLoggedInAdmin(){
            let userName = ''
            if(localStorage.admin){
                const admin = JSON.parse(localStorage.getItem('admin'))

                userName = admin.userData.userName
            }

            return userName
        },

    }
};
</script>

<style>
#components-layout-demo-side .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}
</style>
