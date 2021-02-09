<template>
    <div class="register-form-container">
        <div class="vue-template">
            <form @submit.prevent="signUpUser">
                <h3>Sign Up</h3>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" v-model="userState.firstName" class="form-control form-control-sm"/>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" v-model="userState.lastName" class="form-control form-control-sm"/>
                </div>

                <div class="form-group">
                    <label>User Name</label>
                    <input type="text" v-model="userState.userName" class="form-control form-control-sm"/>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" v-model="userState.email" class="form-control form-control-sm"/>
                </div>


                <div class="form-group">
                    <label>Password</label>
                    <input type="password" v-model="userState.password" class="form-control form-control-sm" />
                </div>

                <span>
                    <button type="submit" class="btn btn-dark btn-lg btn-block" v-if="isSubmitting">
                   Please wait...Signing up....
                </button>

                <button type="submit" class="btn btn-dark btn-lg btn-block" v-else>
                    Sign up
                </button>

                </span>

                <p class="forgot-password text-right">
                    Already registered
                    <router-link :to="{name: 'login'}">sign in?</router-link>
                </p>
            </form>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
import {BASE_API_URL} from '../constants/appConstants'

export default {

    data() {
       const userState = {
           firstName: '',
           lastName: '',
           userName: '',
           email: '',
           password: ''
       }
       const isSubmitting=false
        return {
            userState,
            isSubmitting
          }

    },
    methods:{
      async signUpUser(){
          const userData = {...this.userState}
          this.isSubmitting = true

          await axios({
              method:'post',
              url:BASE_API_URL+'/users',
              headers:{
                  "Content-Type": "application/json",
                  "Accept":"application/json"
              },
              data:JSON.stringify(userData)
          }).then(res=>{
              if(res.data.status==='ok'){
                  this.userState.userName=''
                  this.userState.firstName=''
                  this.userState.lastName=''
                  this.userState.email=''
                  this.userState.password=''
                  this.isSubmitting = false
              }
          }).catch(err=>{
              this.isSubmitting = false
              console.log(err)
          })

      }
    }
}
</script>

<style scoped>
.register-form-container{
    margin:5% 30% auto 20%;
}
</style>
