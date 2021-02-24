<template>
    <a-table :columns="columns" :data-source="data" rowKey="Id" >
        <a slot="name" slot-scope="text">{{ text }}</a>
        <span slot="customTitle"><a-icon type="smile-o" /> Name</span>

        <span slot="action" slot-scope="text, record">
      <a-divider type="vertical" />
      <a @click="deleteUser(record.userName)">Delete</a>
      <a-divider type="vertical" />
     <a>Edit</a>
    </span>
    </a-table>
</template>

<script>

    import Axios from 'axios';
    import {BASE_API_URL} from '../constants/appConstants'
const columns = [
    {
        title: 'First Name',
        dataIndex: 'firstName',
        key: 'fname',
    },
    {
        title: 'Last Name',
        dataIndex: 'lastName',
        key: 'lname',
    },
    {
        title: 'User Name',
        key: 'uname',
        dataIndex: 'userName',
        scopedSlots: { customRender: 'tags' },
    },

    {
        title: 'Email',
        key: 'email',
        dataIndex: 'email',
        scopedSlots: { customRender: 'tags' },
    },
    {
        title: 'Action',
        key: 'action',
        scopedSlots: { customRender: 'action' },
    },
];
    let data = []
export default{
        name:'Userslist',

       data: ()=>{
           return {
               columns,
               data
           }
       },
methods:{
  async deleteUser(userName){
      console.log(userName)
  }
},
   async mounted() {

            let userData = [];

            await Axios.get(BASE_API_URL+'/users').then(res=>{

                res.data.users.map((user, index)=>{
                     user.Id = index
                     userData.push(user)
            })
          });
          this.data = userData
    }
}
</script>
