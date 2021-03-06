<template>
    <div>
        <div>
            <a-tabs default-active-key="pending" @change="callback">
                <a-tab-pane key="pending" tab="PENDING">
                    <h6>PENDING ORDERS</h6>
                </a-tab-pane>
                <a-tab-pane key="complete" tab="COMPLETED" force-render>
                    <h6>COMPLETED ORDERS</h6>
                </a-tab-pane>
            </a-tabs>
        </div>
        <a-row :gutter="20">
            <a-col class="gutter-row" :span="6" v-for="order in orders" :key="order.id" style="margin-top: 2%; margin-bottom:3%; margin-left: 5%">
                <div class="gutter-box">
                    <a-card hoverable style="width: 300px">
                        <img
                            slot="cover"
                            alt="example"
                            src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
                        />

                        <template slot="actions" class="ant-card-actions" v-if="order.status==='PENDING'">
                            <span @click="confirmOrder(order.id)"> <a-icon key="edit" type="check-square" />Complete Order</span>

                            <span> <a-icon key="ed,./it" type="close-square" />Decline Order</span>
                        </template>
                        <a-card-meta :title="order.details">
                        </a-card-meta>
                        <div>
                           <span> Order status: <strong>{{order.status}}</strong></span> <br/>
                            <span>Order Date : <strong>{{order.orderDate}}</strong></span><br/>
                            <span>Ordered By : <strong>{{order.orderName}}</strong></span><br/>
                            <span>Order subtotal : <strong>  K{{order.subtotal}} . 00</strong></span><br/>

                        </div>
                    </a-card>
                </div>
            </a-col>
        </a-row>
        <template>
            <a-pagination :current="currentPage" :total="totalPages" @change="onChange" />
        </template>

    </div>
</template>

<script>
    import Axios from 'axios'
    import {BASE_API_URL} from '../constants/appConstants'
    const key = 'completeOrder'
    export default {
        name:'Orders',
        data:()=>{
            let orders = []

            const admin = JSON.parse(localStorage.getItem('admin'))

            return{
                admin,
                orders,
                currentPage: 1,
                totalPages:0
            }
        },

        methods: {
            onChange(current) {
                this.currentPage = current;
                Axios.get(BASE_API_URL+`/orders?page=${this.currentPage}`, {headers:{
                    Authorization:'Bearer '+this.admin.token
                    }}).then(res=>{
                    this.orders = res.data.orders.data
                    console.log(res.data)
                }).catch(err=>{
                    if(err.message.includes('401')){
                        localStorage.removeItem('admin')
                        this.$router.push('/login')
                    }
                })
            },

            async getCompletedOrders(){
                const response = await Axios.get(BASE_API_URL+'/orders/complete', {headers:{
                        Authorization:'Bearer ' + this.admin.token
                    }}).catch(err=>{
                    if(err.message.includes('401')){
                        localStorage.removeItem('admin')
                        this.$router.push('/login')
                    }else{
                        console.log(err)
                    }
                })

                this.orders = response.data.orders.data
                this.totalPages = response.data.orders.total
            },

            async getPendingOrders(){
                const response = await Axios.get(BASE_API_URL+'/orders', {headers:{
                        Authorization:'Bearer ' + this.admin.token
                    }}).catch(err=>{
                    if(err.message.includes('401')){
                        localStorage.removeItem('admin')
                        this.$router.push('/login')
                    }else{
                        console.log(err)
                    }
                })
                this.orders = response.data.orders.data
                this.totalPages = response.data.orders.total
            },
            async callback(key) {
                    if(key==='complete'){
                       await this.getCompletedOrders()
                    }

                    if(key==='pending'){
                        await this.getPendingOrders()
                    }
            },
            async confirmOrder(orderId){
                this.$message.loading({ content: 'Please Wait.. Completing The Order', key });
              await Axios.put(BASE_API_URL + `/orders/${orderId}`, {}, {
                    headers:{
                        Authorization:`Bearer ${this.admin.token}`
                    }
                }).then(async res=>{
                    if(res.data.status==='ok'){
                        this.$message.success({ content: 'Process Complete...!', key, duration: 2});
                        await this.getPendingOrders()
                    }
              }).catch(err=>{
                  if(err.message.includes('401')){
                      localStorage.removeItem('admin')
                      this.$router.push('/login')
                  }else{
                      console.log(err)
                  }
              })
            }
        },

       async mounted() {
           await this.getCompletedOrders();
           await this.getPendingOrders();
        }
    }
</script>
