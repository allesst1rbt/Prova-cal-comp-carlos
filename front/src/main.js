import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import Home from '../src/components/Home.vue'
import DqcModels from '../src/components/DqcModels.vue'
import Dqc84 from '../src/components/Dqc84.vue'
import Dqc841 from '../src/components/Dqc841.vue'
import Report from '../src/components/Report.vue'
import moment from 'moment';
import VueJsonToCsv from 'vue-json-to-csv'
Vue.component('downloadCsv', VueJsonToCsv)



Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY hh:mm')
    }
});
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter)
Vue.config.productionTip = false
const router = new VueRouter({
    routes: [
        { path: '/', component: Home },
        { path: '/dqcmodels', component: DqcModels },
        { path: '/dqc84', component: Dqc84 },
        { path: '/dqc841', component: Dqc841 },
        { path: '/report', component: Report }
    ]
})
new Vue({
    router: router,
    render: h => h(App),
}).$mount('#app')
