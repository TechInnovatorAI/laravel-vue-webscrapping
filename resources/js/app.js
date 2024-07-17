import './bootstrap'
import { createApp } from 'vue'
import router from './routes';
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue'
import mixins from './mixins';
import moment from 'moment'

// const basePath = 'https://karate-ranking.online';
const basePath = '//127.0.0.1:8000';

const app = createApp(App);
const global = app.config.globalProperties;
global.$appUrl = `${basePath}/`;
global.$paypal_client_id = `AXgXunnUu5mqFGbrYHze3fgyMUfUx9nKkKKmkWnTQ37ROYTSH5Hf83p8zuyecfTD2F1qYd3Kcl2gDdnl`;
global.$paypal_secret = `EHUOYsmZGqrTb9jOvKZjZOKrgkaJn8nGlOPenLldobRMkN9LNfn9spX0LUUvGFZ5av8cicHk_H7ksxzD`;
global.$paypal_mode = `sandbox`;
global.$isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? true : false;
global.$isMobileWeb = window.innerWidth < 480 ? true : false;
global.$apiUrl = `${basePath}/api/`;
global.$appDir = `${basePath}/app/`;
global.$uploads = `${basePath}/uploads/`;
global.$images = `${basePath}/dist/images/`;
global.$user = JSON.parse(localStorage.getItem('user'));
global.$date = {
    format(date, format = "YYYY-MM-DD") {
        return moment(date).format(format)
    },
}


app.use(router);
// app.use(cors('*'));
app.use(VueAxios, axios);
app.mixin(mixins);
app.mount('#app');
