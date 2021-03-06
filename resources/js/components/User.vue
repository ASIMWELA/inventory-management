<template>
    <a-layout id="components-layout-demo-top" class="layout">
        <a-layout-header :style="{position:'fixed',  zIndex: 1000, width:'100%'}">
            <div class="logo" />
            <a-menu
                theme="dark"
                mode="horizontal"
                :default-selected-keys="['2']"
                :style="{ lineHeight: '64px', marginLeft:'30%' }"
            >


                <a-menu-item key="4" :style="{marginLeft:'25%'}" v-if="cartPrice > 0" @click="checkOut">
                    <a-button type="primary" >
                        <span><a-icon type="shopping-cart" />K {{cartPrice}} . 00</span> Checkout
                    </a-button>
                </a-menu-item>
                <a-menu-item key="12" :style="{marginLeft:'15%'}">
                    <a-icon type="user"/>{{user.userData.userName}}
                </a-menu-item>

                <a-menu-item key="5" :style="{marginLeft:'8%'}" @click="logout">
                   Logout <a-icon type="logout"/>
                </a-menu-item>
            </a-menu>
        </a-layout-header>

        <a-layout-content style="padding: 0 50px">

            <a-row :gutter="20" :style="{marginTop:'2%'}">
                <div :style="{marginTop:'4%'}">
                    <a-tabs default-active-key="order" @change="callback">
                        <a-tab-pane key="order" tab="Place An Order">
                            <h6>Place An Order</h6>
                        </a-tab-pane>
                        <a-tab-pane key="complete" tab="Completed Orders" force-render>
                            <h6>Completed Order</h6>
                        </a-tab-pane>

                    </a-tabs>
                </div>
                <a-col class="gutter-row" :span="6" v-for="product in products" :key="product.id" style="margin-top: 4%; margin-bottom:1%" v-if="productList">
                    <div class="gutter-box">
                           <a-card hoverable style="width: 300px">
                                <img
                                    slot="cover"
                                    alt="example"
                                    src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
                                />
                                <template slot="actions" class="ant-card-actions">
                                    <span>K {{product.price_per_unit}} .00</span>
                                   <span @click="addToCart(product.id)"> <a-icon key="edit" type="shopping-cart" /> Add to Cart</span>
                                </template>
                                <a-card-meta :title="product.name" :description="product.description">
                                    <a-avatar
                                        slot="avatar"
                                        src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
                                    />
                                </a-card-meta>
                            </a-card>
                        </div>
                </a-col>

                <a-col class="gutter-row" :span="6" v-for="(order, index) in orders" :key="index" style="margin-top: 4%; margin-bottom:1%" v-if="orderList">
                    <div class="gutter-box">
                        <a-card hoverable style="width: 300px">
                            <img
                                slot="cover"
                                alt="example"
                                src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
                            />
                            <template slot="actions" class="ant-card-actions">
                            </template>
                            <a-card-meta :title="order.details" >
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

        </a-layout-content>

        <template>
            <a-pagination :current="currentPage" :total="totalPages" @change="onChange" v-if="productList" :show-total="total => `Total ${total} items`"/>
        </template>

        <template>
            <a-pagination :current="orderCurrentPage" :total="orderTotalPages" @change="orderPageChange" v-if="orderList" :show-total="total => `Total ${total} items`"/>
        </template>

        <a-layout-footer style="text-align: center">
            Inventory Management © 2020
        </a-layout-footer>
    </a-layout>
</template>


<script>
    import {BASE_API_URL} from '../constants/appConstants'
    import Axios from 'axios'
    const key = 'updatable';
    export default {
        data: ()=>{
            let products = [];
            let orders= []
            const user  = JSON.parse(localStorage.getItem('user'));
            return{
                user,
                products,
                orders,
                currentPage:0,
                totalPages:5,
                orderCurrentPage:0,
                orderTotalPages:1,
                loading:false,
                cartPrice:0.0,
                productList:false,
                orderList:false
            }
        },
        methods:{
           logout(){
               if(localStorage.user){
                      Axios.put(BASE_API_URL+'/orders', {}, {
                          headers:{
                              Authorization:'Bearer '+this.user.token
                          }
                      }).then(res=>{
                          console.log(res.data)
                      }).catch(err=>{
                          console.log(err)
                      })
                      localStorage.removeItem('user')
                      this.$router.push('/login')
               }
            },
            callback(key) {
                if(key==='complete'){
                    this.getCompletedOrders()
                }

                if(key==='order'){
                    this.getAllProducts()
                }
            },

            async orderPageChange(current){
               this.orderCurrentPage = current
              await Axios.get(BASE_API_URL+`/orders/complete/${this.user.userData.userName}?page=${this.orderCurrentPage}`,{headers:{
                      Authorization:`Bearer ${this.user.token}`
                  }}).then(res=>{
                  this.orders = res.data.orders.data
                  this.orderTotalPages = res.data.orders.total
              })
            },
            async getAllProducts(){
               this.productList = true
                this.orderList = false
                await Axios.get(BASE_API_URL+'/products').then(res=>{
                     this.products = res.data.products.data
                     this.totalPages = 50


                    console.log(res.data)
                })
            },

            async getCompletedOrders(){
               this.productList = false,
                   this.orderList = true
                await Axios.get(BASE_API_URL+`/orders/complete/${this.user.userData.userName}`,{headers:{
                    Authorization:`Bearer ${this.user.token}`
                    }}).then(res=>{
                        this.orders = res.data.orders.data
                        this.orderTotalPages = res.data.orders.total
                    console.log(res.data)
                }).catch(err=>{
                    if(err.message.includes('401')){
                        localStorage.removeItem('user')
                        this.$router.push('/login')
                    }
                })
            },

           async onChange(current) {
                this.currentPage = current;
                console.log(this.currentPage)
            await Axios.get(BASE_API_URL+`/products?page=${this.currentPage}`).then(res=>{
                    this.products = res.data.products.data
                    this.totalPages = 50

                    console.log(res)
                })

            },
            async addToCart(productId){
               this.loading=true
               await Axios.post(BASE_API_URL+'/orders/'+productId, {}, {
                   headers:{
                       Authorization: 'Bearer' + this.user.token
                   }
               }).then(res=>{
                   this.loading=false
                   this.cartPrice = res.data.cartPrice
                }).catch(err=>{
                    if(err.message.includes('401')){
                        localStorage.removeItem('user')
                        this.$router.push('/login')
                    }
               })
            },
            checkOut(){
                this.$message.loading({ content: 'Please Wait.. Loading...', key });
               Axios.put(BASE_API_URL+'/orders/checkout',{}, {headers:{
                   Authorization:'Bearer '+this.user.token
                   }}).then(res=>{
                       this.$message.success({ content: 'Checkout Successs...!', key, duration: 2});
                       this.cartPrice = 0
                    }).catch(err=>{
                        if(err.message.includes('401')){
                            localStorage.removeItem('user')
                            this.$router.push('/login')
                        }
               })
            }
        },

        async mounted(){
           await this.getAllProducts();
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
