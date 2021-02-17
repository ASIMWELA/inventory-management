<template>
    <div>
        User section
    </div>
</template>

<script>
export default {

    data: ()=>{
        return{

        }
    },
    methods:{
       logout(){
           if(LocalStorage.user){
             LocalStorage.removeItem('user')
               this.$router.push('/login')
           }
        }
    }
}
</script>
