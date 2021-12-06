import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import { initializeApp } from "firebase/app"
import { getMessaging, getToken} from "firebase/messaging";
import VueQrcodeReader from "vue-qrcode-reader";
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.config.productionTip = false
const firebaseConfig = {
  apiKey: "AIzaSyA3b-6Q-jFB09sI4vXAuehZNIQSFS64yDI",
  authDomain: "toolbox-vuewebpush.firebaseapp.com",
  projectId: "toolbox-vuewebpush",
  storageBucket: "toolbox-vuewebpush.appspot.com",
  messagingSenderId: "828373746161",
  appId: "1:828373746161:web:f1f6c4b5cee6b0c9ae8450",
  measurementId: "G-K1BBZMGBZH"
};

Vue.use(VueQrcodeReader);
Vue.use(ViewUI);
Vue.use(VueLoading);

new Vue({
  router,
  store,
  vuetify,
  VueQrcodeReader,
  render: h => h(App)
}).$mount('#app')
const app = initializeApp(firebaseConfig);
const messaging = getMessaging();