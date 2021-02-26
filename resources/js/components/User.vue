<template>
    <a-layout id="components-layout-demo-top" class="layout">
        <a-layout-header>
            <div class="logo" />
            <a-menu
                theme="dark"
                mode="horizontal"
                :default-selected-keys="['2']"
                :style="{ lineHeight: '64px', marginLeft:'40%' }"
            >
                <a-menu-item key="1">
                    nav 1
                </a-menu-item>
                <a-menu-item key="2">
                    nav 2
                </a-menu-item>
                <a-menu-item key="3">
                    nav 3
                </a-menu-item>
                <a-menu-item key="3" :style="{marginLeft:'45%'}">
                    <a-icon type="user"/>{{user.userData.userName}}
                </a-menu-item>

                <a-menu-item key="3" :style="{marginLeft:'4%'}" @click="logout">
                   Logout <a-icon type="logout"/>
                </a-menu-item>
            </a-menu>
        </a-layout-header>
        <a-layout-content style="padding: 0 50px">

            <div :style="{ background: '#fff', padding: '24px', minHeight: '280px' }">
                Content
            </div>
        </a-layout-content>
        <a-layout-footer style="text-align: center">
            Ant Design ©2018 Created by Ant UED
        </a-layout-footer>
    </a-layout>
</template>


<script>
export default {

    data: ()=>{

        const user  = JSON.parse(localStorage.getItem('user'));

        return{
            user
        }
    },
    methods:{
       logout(){
           if(localStorage.user){
             localStorage.removeItem('user')
               this.$router.push('/login')
           }
        }
    }
}
</script>

<style>
#components-layout-demo-top .logo {
    width: 120px;
    height: 31px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px 24px 16px 0;
    float: left;
}
</style>
