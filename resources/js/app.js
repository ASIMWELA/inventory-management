import Vue from 'vue'
import router from './routes/router'
import BootstrapVue from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'ant-design-vue/dist/antd.css'
Vue.use(BootstrapVue)




//Main pages
import App from './components/app.vue'






const app = new Vue({
    el: '#app',
    render: h=>h(App) ,
    router

});
