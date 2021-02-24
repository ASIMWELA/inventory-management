<template>
    <div>
        <div>
                <a-icon type="plus-circle" @click="showModal"/>

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
        return {
            data,
            columns,
            loading: false,
            visible: false,
            category
        };
    },

    methods: {
        showModal() {
            this.visible = true;
        },
        async submitCategory(e) {
            e.preventDefault();

            this.loading=true;
            const admin = JSON.parse(localStorage.getItem('admin'));
            const token = admin.token;

            const categoryData = {
                name:this.category.name,
                description: this.category.description
            }
            await Axios({
                url:BASE_API_URL+'/product-categories',
                method:'POST',
                headers:{
                    Authorization:`Bearer ${token}`,
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
    },
};
</script>
