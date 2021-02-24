<template>
    <div>
        <div>
            <span>
                <a-icon type="plus-circle" @click="showModal"/>

                 <a-icon type="plus-circle" @click="showProductModal"/>
            </span>


            <a-modal v-model="visible" title="Add Product Category" on-ok="submitCategory">
                <template slot="footer">
                    <a-button key="back" @click="handleCancel">
                        Return
                    </a-button>
                    <a-button key="submit" type="primary" :loading="loading" @click="submitCategory">
                        Submit
                    </a-button>
                </template>
                <p>  <a-form-model >
                    <a-form-model-item label="Name" >
                        <a-input v-model="category.name"/>
                    </a-form-model-item>
                    <a-form-model-item label="Description" >
                        <a-textarea v-model="category.description" />
                    </a-form-model-item>
                </a-form-model></p>

            </a-modal>

            <a-modal v-model="productModalVisible" title="Add Product" on-ok="submitCategory">
                <template slot="footer">
                    <a-button key="back" @click="hideProductModal">
                        Return
                    </a-button>
                    <a-button key="submit" type="primary" :loading="loading" @click="submitProduct" >
                        Submit
                    </a-button>
                </template>
                <p>
                    <a-form-model :label-col="labelCol" :wrapper-col="wrapperCol">
                        <a-form-model-item label="Name">
                            <a-input v-model="productData.name" />
                        </a-form-model-item>
                        <a-form-model-item label="Category">
                            <a-select placeholder="--please select--" v-model="productData.category" >
                                    <a-select-option  v-for="productCategory in productCategories" :value="productCategory.name" :key="productCategory.name">
                                        {{productCategory.name}}
                                     </a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <a-form-model-item label="Quantity">
                           <a-input v-model="productData.quantity"/>
                        </a-form-model-item>
                        <a-form-model-item label="Threshold">
                           <a-input v-model="productData.threshold"/>
                        </a-form-model-item>
                        <a-form-model-item label="Available">
                            <a-select placeholder="--please select--" v-model="productData.available">
                                <a-select-option value=true>
                                    True
                                </a-select-option>
                                <a-select-option value=false>
                                    False
                                </a-select-option>
                            </a-select>
                        </a-form-model-item>

                        <a-form-model-item label="Price/unit">
                            <a-input v-model="productData.price"/>
                        </a-form-model-item>
                        <a-form-model-item label="Description">
                            <a-textarea v-model="productData.description"/>
                        </a-form-model-item>
                    </a-form-model>
                </p>

            </a-modal>
        </div>



        <a-table :columns="columns" :data-source="data">
        <a slot="action" slot-scope="text" href="javascript:;">Delete</a>
        <p slot="expandedRowRender" slot-scope="record" style="margin: 0">
            {{ record.description }}
        </p>
    </a-table>

    </div>

</template>
<script>

import Axios from 'axios';
import {BASE_API_URL} from '../constants/appConstants'

    const columns = [
        { title: 'Name', dataIndex: 'name', key: 'name' },
        { title: 'Age', dataIndex: 'age', key: 'age' },
        { title: 'Address', dataIndex: 'address', key: 'address' },
        { title: 'Action', dataIndex: '', key: 'x', scopedSlots: { customRender: 'action' } },
    ];

    const data = [
        {
            key: 1,
            name: 'John Brown',
            age: 32,
            address: 'New York No. 1 Lake Park',
            description: 'My name is John Brown, I am 32 years old, living in New York No. 1 Lake Park.',
        },
        {
            key: 2,
            name: 'Jim Green',
            age: 42,
            address: 'London No. 1 Lake Park',
            description: 'My name is Jim Green, I am 42 years old, living in London No. 1 Lake Park.',
        },
        {
            key: 3,
            name: 'Joe Black',
            age: 32,
            address: 'Sidney No. 1 Lake Park',
            description: 'My name is Joe Black, I am 32 years old, living in Sidney No. 1 Lake Park.',
        },
    ];

export default {

    name:'Products',
    data() {

        const category = {
            name:'',
            description:''
        }
        let productCategories = []

        const productData={
            name:'',
            category:'',
            threshold:0.0,
            available:'',
            quantity:0.0,
            price:0.0,
            description:''
        }
        return {
            data,
            columns,
            loading: false,
            visible: false,
            productData,
            productModalVisible:false,
            category,
            labelCol: { span: 4 },
            wrapperCol: { span: 14 },
            productCategories
        };
    },

    methods: {

        showModal() {
            this.visible = true;
        },

        showProductModal() {
            this.productModalVisible = true;
        },
        async submitCategory(e) {
            const admin = JSON.parse(localStorage.getItem('admin'));

            e.preventDefault();

            this.loading=true;

            const categoryData = {
                name:this.category.name,
                description: this.category.description
            }
            await Axios({
                url:BASE_API_URL+'/product-categories',
                method:'POST',
                headers:{
                    Authorization:`Bearer ${admin.token}`,
                    'Content-Type':'application/json'
                },
                data:JSON.stringify(categoryData)
            }).then(res=> {
                if(res.data.status==='ok'){
                    this.loading=false
                    this.category.name= ''
                    this.category.description=''
                }
            }).catch(err=>{
                this.loading=false
            })
        },
        handleCancel(e) {
            this.visible = false;

        },

        hideProductModal(){
            this.productModalVisible=false
        },

        async submitProduct(){
            const admin = JSON.parse(localStorage.getItem('admin'));


            let productAvailable = this.productData.available==='True' ? true:false

            let collectData;
            try{
                collectData ={
                    name:this.productData.name,
                    threshold: parseFloat(this.productData.threshold),
                    quantity: parseFloat(this.productData.quantity),
                    price_per_unit:parseFloat(this.productData.price),
                    available: productAvailable,
                    description:this.productData.description
                }

                await Axios({
                    url:BASE_API_URL+`/products/${this.productData.category}`,
                    method:'POST',
                    headers:{
                        Authorization: `Bearer ${admin.token}`,
                        'Content-Type':'application/json'
                    },
                    data:JSON.stringify(collectData)
                }).then(res=>{
                    if(res.data.status==='ok'){
                      this.productData.length = 0
                    }
                }).catch(err=>{
                    console.log(err)
                })
            }catch (err){

            }


        }
    },

    async mounted() {
       const categories = await Axios.get(BASE_API_URL+'/product-categories')
       this.productCategories = categories.data.categories

        console.log(this.productCategories)

    }
};
</script>
