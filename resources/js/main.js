// import firebase from "firebase/app";
// import { getAuth } from "firebase/auth";
// import { createApp } from "vue";
// import App from "./App.vue";
// import router from "./routes";
// import { connectAuthEmulator } from "firebase/auth";

// const firebaseConfig = {
//     apiKey: "AIzaSyBJXDPF046Pycb5sbZISfMneERpXVh-uYY",
//     authDomain: "laravel-vue-62e36.firebaseapp.com",
//     projectId: "laravel-vue-62e36",
//     storageBucket: "laravel-vue-62e36.appspot.com",
//     messagingSenderId: "697250453585",
//     appId: "1:697250453585:web:18813429d5848b3bfb4070",
//     measurementId: "G-KLGD8K29K9"
// };

// firebase.initializeApp(firebaseConfig);
// console.log(firebase, "testing")
// // initializeApp(firebaseConfig);

// const auth = getAuth();

// let app;

// // if (location.hostname === "localhost") {
// //     connectAuthEmulator(auth, "http://localhost:9099");
// // }

// auth.onAuthStateChanged(() => {
//     if(!app) {
//         app = createApp(App);
//         app.use(router);
//         app.mount("#app");
//     }
// })

import Vue from "vue";
import App from "./App.vue";
import firebase from "./initFirebase";
import router from "./routes";

Vue.config.productionTip = false;

let app;
firebase.auth().onAuthStateChanged((user) => {
    if (!app) {
        app = new Vue({
            router,
            render: (h) => h(App),
        }).$mount("#app");
    }
});
