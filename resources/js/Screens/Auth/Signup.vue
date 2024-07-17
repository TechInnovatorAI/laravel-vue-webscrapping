<template lang="">
    <div
        class="page-wrapper"
        id="main-wrapper"
        data-layout="vertical"
        data-sidebartype="full"
        data-sidebar-position="fixed"
        data-header-position="fixed"
    >
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100"
        >
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <a
                            href="/"
                            class="text-nowrap logo-img d-block px-4 py-9 w-100"
                        >
                            <!-- <img :src="`${$appDir}logo.gif`" width="180" alt=""> -->
                        </a>
                        <div
                            class="d-none d-xl-flex align-items-center justify-content-center"
                            style="height: calc(100vh - 80px)"
                        >
                            <img
                                :src="`${$appDir}auth/artificial-intelligence.svg`"
                                alt=""
                                class="img-fluid"
                                width="500"
                            />
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4"
                        >
                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <h2 class="mb-3 fs-7 fw-bolder">
                                    Welcome to Scraper
                                </h2>
                                <p class="mb-9">Continue Your Journey</p>
                                <div class="position-relative text-center my-4">
                                    <p
                                        class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative"
                                    >
                                        Register
                                    </p>
                                    <span
                                        class="border-top w-100 position-absolute top-50 start-50 translate-middle"
                                    ></span>
                                </div>
                                <form @submit="register">
                                    <div class="mb-3">
                                        <label class="form-label"
                                            >Email</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="user.email"
                                        />
                                        <Error :message="errors.email" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label"
                                            >Password</label
                                        >
                                        <input
                                            type="password"
                                            class="form-control"
                                            v-model="user.password"
                                        />
                                        <Error :message="errors.password" />
                                    </div>
                                    <!-- <div class="mb-4">
                                        <label class="form-label"
                                            >Confirm Password</label
                                        >
                                        <input
                                            type="password"
                                            class="form-control"
                                            v-model="user.password"
                                        />
                                        <Error :message="errors.password" />
                                    </div> -->
                                    <button
                                        class="btn btn-warning w-100 py-8 mb-4 rounded-2"
                                        @click="register"
                                        :disabled="isLoading"
                                    >
                                        {{
                                            isLoading
                                                ? "Please wait..."
                                                : "Sign Up"
                                        }}
                                    </button>
                                    <router-link to="/forgot"
                                        >go to login</router-link
                                    >
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Error from "../../Components/Error.vue";
import { getAuth, createUserWithEmailAndPassword } from "firebase/auth";
import { ref } from 'vue';
import * as firebase from '../../initFirebase'

const errMsg = ref();

export default {
    components: {
        Error,
    },
    data() {
        return {
            errors: {},
            user: {
                email: "",
                password: "",
            },
            isLoading: false,
        };
    },
    methods: {
        register(e) {
            e.preventDefault();
            createUserWithEmailAndPassword(firebase.auth, this.user.email, this.user.password)
                .then((data) => {
                    const userData = data.user.reloadUserInfo
                    this.noti("success", "Register successfully!");
                    this.axios.post(`${this.$apiUrl}auth/sign`, { email: userData.email, pass: userData.passwordHash }).then(() => {
                        this.$router.push('/');
                    })
                })
                .catch((error) => {
                    alert(error.message)
                });
        },

    },
};
</script>
<style lang=""></style>
