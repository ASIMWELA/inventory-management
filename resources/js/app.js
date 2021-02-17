import Vue from 'vue'
import router from './routes/router'
import BootstrapVue from 'bootstrap-vue'
import Antd from 'ant-design-vue';
import Vuelidate from 'vuelidate'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'ant-design-vue/dist/antd.css'
Vue.use(BootstrapVue)
Vue.use(Antd)
Vue.use(Vuelidate)




//Main pages
import App from './components/app.vue'






const app = new Vue({
    el: '#app',
    render: h=>h(App) ,
    router

});
