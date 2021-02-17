<template>
   <div class="register-form-container" >

       <div class="vue-template">
           <form @submit.prevent="login">
               <h3>Sign In</h3>

               <div class="form-group">
                   <label>User name</label>
                   <input type="text" class="form-control form-control-lg" v-model="userState.userName"/>
               </div>

               <div class="form-group">
                   <label>Password</label>
                   <input type="password" class="form-control form-control-lg" v-model="userState.password"/>
               </div>

               <button type="submit" class="btn btn-dark btn-lg btn-block" v-if="isSubmitting">Authenticating...</button>

               <button type="submit" class="btn btn-dark btn-lg btn-block" v-else>Sign In</button>

               <p class="forgot-password text-right mt-2 mb-4">
                   <router-link to="/forgot-password">Forgot password ?</router-link>
               </p>


           </form>
       </div>
   </div>


</template>


<script>
import Axios from 'axios';
import {BASE_API_URL} from "../constants/appConstants";
export default{


   data(){
        const userState = {
            userName : '',
            password: '',

        }
        const isSubmitting= false;

        return {
            userState,
            isSubmitting
        }
   },
    methods:{
       async login(){
           const data = {...this.userState}
           this.isSubmitting = true
           Axios({
               method:"post",
               url:BASE_API_URL+'/users/auth',
               headers:{
                   "Content-Type": "application/json",
                   "Accept":"application/json"
               },
               data:JSON.stringify(data)
           }).then(res=>{
               if(res.data.status === 'ok'){
                   if(res.data.userData.isAdmin){

                       localStorage.setItem('admin', JSON.stringify(res.data))
                       this.$router.push('/admin')

                   }

                   if(!res.data.userData.isAdmin){
                       localStorage.setItem('user', JSON.stringify(res.data))
                       this.$router.push('/user')
                   }

                   console.log(res.data)
                   this.isSubmitting=false
               }



           }).catch(err=>{
               console.log(err)
               this.isSubmitting = false
           })
        }
    }

}
</script>

<style scoped>
.register-form-container{

    margin: 5% 25% auto 35%;

}

</style>
