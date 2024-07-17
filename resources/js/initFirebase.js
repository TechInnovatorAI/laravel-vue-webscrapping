import { initializeApp } from 'firebase/app'
import { getAuth } from 'firebase/auth'

// const firebaseConfig = {
//     apiKey: "AIzaSyBJXDPF046Pycb5sbZISfMneERpXVh-uYY",
//     authDomain: "laravel-vue-62e36.firebaseapp.com",
//     projectId: "laravel-vue-62e36",
//     storageBucket: "laravel-vue-62e36.appspot.com",
//     messagingSenderId: "697250453585",
//     appId: "1:697250453585:web:18813429d5848b3bfb4070",
//     measurementId: "G-KLGD8K29K9"
// };
const firebaseConfig = {
    apiKey: "AIzaSyD8HoxDyO3mJHJspiS6-w2yWTmfRrX5J64",
    authDomain: "karate-ranking-d17a3.firebaseapp.com",
    projectId: "karate-ranking-d17a3",
    storageBucket: "karate-ranking-d17a3.appspot.com",
    messagingSenderId: "132629231565",
    appId: "1:132629231565:web:5904594175fcaa020db684",
    measurementId: "G-1VKYYFNR4D"
};

const app = initializeApp(firebaseConfig)
export const auth = getAuth(app)

